<?php

namespace Tests\Feature;

use App\Models\Battle;
use App\Models\Monster;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class BattleControllerTest extends TestCase
{
    use RefreshDatabase;

    private $battle, $monster1, $monster2, $monster3, $monster4, $monster5, $monster6, $monster7;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_should_get_all_battles_correctly()
    {
        $monsterA = Monster::factory()->create();
        $monsterB = Monster::factory()->create();

        Battle::factory()->create([
            'monsterA' => $monsterA->id,
            'monsterB' => $monsterB->id,
            'winner' => $monsterA->id,
        ]);

        Battle::factory()->create([
            'monsterA' => $monsterB->id,
            'monsterB' => $monsterA->id,
            'winner' => $monsterB->id,
        ]);

        $response = $this->getJson('api/battles')
            ->assertStatus(Response::HTTP_OK)
            ->json('data');
        $this->assertCount(2, $response);
    }

    public function test_should_create_a_battle_with_a_bad_request_response_if_one_parameter_is_null()
    {

        $monster = Monster::factory()->create();

        $response = $this->postJson('/api/battles/start', [
            'monsterA' => null,
            'monsterB' => $monster->id,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['monsterA']);

        $response = $this->postJson('/api/battles/start', [
            'monsterA' => $monster->id,
            'monsterB' => null,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['monsterB']);
    }

    public function test_should_create_battle_correctly_with_monsterB_winning()
    {

        $monsterA = Monster::factory()->create([
            'speed' => 10,
            'attack' => 20,
            'defense' => 5,
            'hp' => 100
        ]);

        $monsterB = Monster::factory()->create([
            'speed' => 12,
            'attack' => 25,
            'defense' => 5,
            'hp' => 100
        ]);

        $response = $this->postJson('/api/battles/start', [
            'monsterA' => $monsterA->id,
            'monsterB' => $monsterB->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'Battle created successfully',
                'battle' => [
                    'winner' => $monsterB->id
                ],
            ]);
    }

    public function test_should_create_battle_correctly_with_monsterA_winning_if_theirs_speeds_same_and_monsterA_has_higher_attack()
    {

        $monsterA = Monster::factory()->create(['speed' => 10, 'attack' => 25, 'defense' => 5, 'hp' => 100]);
        $monsterB = Monster::factory()->create(['speed' => 10, 'attack' => 20, 'defense' => 5, 'hp' => 100]);

        $response = $this->postJson('/api/battles/start', [
            'monsterA' => $monsterA->id,
            'monsterB' => $monsterB->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'Battle created successfully',
                'battle' => [
                    'monsterA' => $monsterA->id,
                    'monsterB' => $monsterB->id,
                    'winner' => $monsterA->id,
                    'id' => $response->json('battle.id')
                ],
            ]);
    }

    public function test_should_create_battle_correctly_with_monsterA_winning_if_theirs_defense_same_and_monsterA_has_higher_speed()
    {

        $monsterA = Monster::factory()->create(['speed' => 15, 'attack' => 20, 'defense' => 5, 'hp' => 100]);
        $monsterB = Monster::factory()->create(['speed' => 10, 'attack' => 20, 'defense' => 5, 'hp' => 100]);

        $response = $this->postJson('/api/battles/start', [
            'monsterA' => $monsterA->id,
            'monsterB' => $monsterB->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message' => 'Battle created successfully',
                'battle' => [
                    'monsterA' => $monsterA->id,
                    'monsterB' => $monsterB->id,
                    'winner' => $monsterA->id,
                    'id' => $response->json('battle.id')
                ],
            ]);
    }

    public function test_should_delete_with_404_error_if_battle_does_not_exists()
    {

        $response = $this->deleteJson('/api/battles/999');

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson(['message' => 'Battle not found']);
    }
}
