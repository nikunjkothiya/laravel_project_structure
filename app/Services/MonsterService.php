<?php

namespace App\Services;

use App\Repositories\MonsterRepository;
use App\Models\Monster;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class MonsterService
{
    /**
     *
     * @var $monsterRepository
     */
    protected $monsterRepository;

    /**
     * MonsterService constructor.
     *
     * @param MonsterRepository $monsterRepository
     *
     */
    public function __construct(MonsterRepository $monsterRepository)
    {
        $this->monsterRepository = $monsterRepository;
    }

    /**
     * Update a monster.
     *
     * @param mixed $monsterId
     * @param mixed $newMonster
     *
     * @return void
     *
     */
    public function updateMonster($monsterId, $newMonster): void
    {
        $this->monsterRepository->updateMonster($monsterId, $newMonster);
    }

    /**
     * Import csv to monster.
     *
     * @param mixed $data
     * @param mixed $csv_data
     *
     * @return void
     *
     */
    public function importMonster($data, $csv_data): void
    {
        foreach ($csv_data as $row) {
            $inserted_data = array(
                $data[0][0] => $row[0],
                $data[0][1] => $row[1],
                $data[0][2] => $row[2],
                $data[0][3] => $row[3],
                $data[0][4] => $row[4],
                $data[0][5] => $row[5]
            );

            Monster::create($inserted_data);
        }
    }
}
