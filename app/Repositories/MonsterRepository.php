<?php

namespace App\Repositories;

use App\Interfaces\MonsterRepositoryInterface;
use App\Models\Monster;
use Illuminate\Support\Collection;

class MonsterRepository implements MonsterRepositoryInterface
{
    public function createMonster(array $newMonster): Monster
    {
        return Monster::create($newMonster);
    }

    public function updateMonster($monsterId, array $newMonster): void
    {
        Monster::whereId($monsterId)->update($newMonster);
    }

    public function removeMonster($monsterId): void
    {
        Monster::destroy($monsterId);
    }
}
