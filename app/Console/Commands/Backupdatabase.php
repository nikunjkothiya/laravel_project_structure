<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

class Backupdatabase extends Command
{
    protected $signature = 'backup:database';

    protected $description = 'Backup the database using custom logic';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $databaseName = Config::get('database.connections.mysql.database');
        $backupFileName = date('Y-m-d_His') . '.sql';
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');

        $tempBackupDirectory = storage_path('tempbackups/database/');
        $backupDirectory = public_path('backup/database/');
        $zipFileName = date('Y-m-d_His') . '.zip';

        $this->createDirectoryIfNotExists($tempBackupDirectory);
        $this->createDirectoryIfNotExists($backupDirectory);

        $backupFilePath = $tempBackupDirectory . $backupFileName;
        $zipFilePath = $backupDirectory . $zipFileName;

        // Generate the database backup
        if ($this->createDatabaseBackup($username, $password, $databaseName, $backupFilePath)) {
            $this->info('Database backup completed.');

            // Compress the backup file into a ZIP archive
            if ($this->createZipArchive($backupFilePath, $zipFilePath)) {
                $this->info('Backup ZIP file created: ' . $zipFileName);
                unlink($backupFilePath);
            } else {
                $this->error('Failed to create ZIP file.');
            }

            // Remove old backups (older than 181 days)
            $this->removeOldBackups($backupDirectory, 181);
        } else {
            $this->error('Database backup failed.');
        }
    }

    private function createDirectoryIfNotExists($directory)
    {
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    private function createDatabaseBackup($username, $password, $databaseName, $backupFilePath)
    {
        $command = sprintf("mysqldump -u%s -p'%s' %s > %s", escapeshellarg($username), escapeshellarg($password), escapeshellarg($databaseName), escapeshellarg($backupFilePath));
        exec($command, $output, $returnValue);
        return $returnValue === 0;
    }

    private function createZipArchive($filePath, $zipFilePath)
    {
        $zip = new \ZipArchive();
        if ($zip->open($zipFilePath, \ZipArchive::CREATE) === true) {
            $zip->addFile($filePath, basename($filePath));
            $zip->close();
            return true;
        }
        return false;
    }

    private function removeOldBackups($directory, $daysToKeep)
    {
        $backupFiles = glob($directory . '/*.zip');
        if ($backupFiles === false) {
            return;
        }

        $cutoffTimestamp = time() - ($daysToKeep * 24 * 60 * 60);

        foreach ($backupFiles as $backupFile) {
            $fileTimestamp = filemtime($backupFile);

            if ($fileTimestamp !== false && $fileTimestamp < $cutoffTimestamp) {
                unlink($backupFile);
                $this->info("Removed old backup: " . basename($backupFile));
            }
        }
    }
}
