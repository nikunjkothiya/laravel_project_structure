<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BattleRepositoryInterface
{
    public function getAllBattles(): Collection;
}
