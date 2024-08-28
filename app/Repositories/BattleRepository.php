<?php

namespace App\Repositories;

use App\Interfaces\BattleRepositoryInterface;
use App\Models\Battle;
use Illuminate\Support\Collection;

class BattleRepository implements BattleRepositoryInterface
{
    public function getAllBattles(): Collection
    {
        return Battle::with('winner')->with('monsterA')->with('monsterB')->get();
    }

    public function createBattle(array $data): Battle
    {
        return Battle::create($data);
    }

    public function deleteBattle(int $id): void
    {
        $deletedCount = Battle::destroy($id);

        if ($deletedCount === 0) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Battle not found');
        }
    }
}
