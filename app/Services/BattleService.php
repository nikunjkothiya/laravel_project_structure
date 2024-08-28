<?php

namespace App\Services;

use App\Models\Monster;
use App\Repositories\BattleRepository;
use App\Models\Battle;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class BattleService
{
    /**
     * @var $battleRepository
     */
    protected $battleRepository;

    /**
     * BattleService constructor.
     *
     * @param BattleRepository $battleRepository
     *
     */
    public function __construct(BattleRepository $battleRepository)
    {
        $this->battleRepository = $battleRepository;
    }

    /**
     * Get all battles.
     *
     * @return Collection
     *
     */
    public function getAll(): Collection
    {
        return $this->battleRepository->getAllBattles();
    }

    /**
     * Start a battle.
     *
     * @param Monster $monster1
     * @param Monster $monster2
     * @return Battle
     */
    public function startBattle(Monster $monster1, Monster $monster2): Battle
    {
        $winner = $this->determineWinner($monster1, $monster2);

        $battle = $this->battleRepository->createBattle([
            'monsterA' => $monster1->id,
            'monsterB' => $monster2->id,
            'winner' => $winner->id,
        ]);

        return $battle;
    }

    /**
     * Delete a battle.
     *
     * @param int $id
     * @return void
     */
    public function deleteBattle(int $id): void
    {
        $this->battleRepository->deleteBattle($id);
    }

    /**
     * Determine the winner of the battle.
     *
     * @param Monster $monster1
     * @param Monster $monster2
     * @return Monster
     */
    private function determineWinner(Monster $monster1, Monster $monster2): Monster
    {
        // Determine the initial attacker and defender based on speed and attack
        if (
            $monster1->speed > $monster2->speed ||
            ($monster1->speed == $monster2->speed && $monster1->attack > $monster2->attack)
        ) {
            $attacker = $monster1;
            $defender = $monster2;
        } else {
            $attacker = $monster2;
            $defender = $monster1;
        }

        // Perform battle until one monster's HP is reduced to 0 or less
        while ($monster1->hp > 0 && $monster2->hp > 0) {
            $this->attack($attacker, $defender);
            // Swap roles
            [$attacker, $defender] = [$defender, $attacker];
        }

        return $monster1->hp > 0 ? $monster1 : $monster2;
    }

    /**
     * Perform an attack.
     *
     * @param Monster $attacker
     * @param Monster $defender
     * @return void
     */
    private function attack(Monster $attacker, Monster $defender): void
    {
        $damage = max($attacker->attack - $defender->defense, 1);
        $defender->hp -= $damage;
    }
}
