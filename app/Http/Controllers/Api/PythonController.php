<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessImageRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonController extends Controller
{
    public function processBgRemove(ProcessImageRequest $request)
    {
        try {
            $file = $request->file('image');

            // Run the Python script to process the image
            $process = new Process(['python3', base_path('rembg-main/app.py'), $file->path()]);
            $process->run();

            // Check if the process was successful
            if (!$process->isSuccessful()) {
                // Log the error and throw an exception
                Log::error('Image processing failed', [
                    'error' => $process->getErrorOutput(),
                    'command' => $process->getCommandLine(),
                    'exit_code' => $process->getExitCode(),
                ]);
                throw new ProcessFailedException($process);
            }

            // Decode the output and return the response
            $data = $process->getOutput();
            $decodedImage = base64_decode(str_replace_first('b', '', $data));

            return response($decodedImage, Response::HTTP_OK)
                ->header('Content-Type', 'image/png');
        } catch (ProcessFailedException $e) {
            // Log the exception details
            Log::error('An error occurred during image processing', [
                'exception' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Image processing failed.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            // Log any other exceptions
            Log::error('An unexpected error occurred', [
                'exception' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'An unexpected error occurred.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
