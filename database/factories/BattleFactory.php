<?php

namespace Database\Factories;

use App\Models\Monster;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Battle>
 */
class BattleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // public function definition()
    // {
    //     return [
    //         'monsterA' => Monster::first()->id,
    //         'monsterB' => Monster::first()->id,
    //         'winner' => Monster::first()->id
    //     ];
    // }

    public function definition()
    {
        $monsterA = Monster::factory()->create();
        $monsterB = Monster::factory()->create();

        return [
            'monsterA' => $monsterA->id,
            'monsterB' => $monsterB->id,
            'winner' => $this->faker->randomElement([$monsterA->id, $monsterB->id]),
        ];
    }
}
