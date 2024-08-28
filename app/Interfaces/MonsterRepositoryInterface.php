<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface MonsterRepositoryInterface
{
    public function updateMonster($monsterId, array $newMonster): void;
}
