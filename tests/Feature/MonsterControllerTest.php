<?php

namespace Tests\Feature;

use App\Models\Monster;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MonsterControllerTest extends TestCase
{
    use RefreshDatabase;

    private $monster;

    public function setUp(): void
    {
        parent::setUp();
        $this->monster = $this->createMonsters([
            'name' => 'My monster',
            'attack' => 20,
            'defense' => 40,
            'hp' => 70,
            'speed' => 10,
            'imageUrl' => ''
        ]);
    }

    public function test_should_get_all_monsters_correctly()
    {
        $this->createMonsters([
            'name' => 'Monster A',
            'attack' => 30,
            'defense' => 20,
            'hp' => 100,
            'speed' => 15,
            'imageUrl' => 'http://example.com/imageA.png'
        ]);
        $response = $this->getJson('api/monsters')->assertStatus(Response::HTTP_OK)->json('data');

        $this->assertEquals('My monster Test', $response[0]['name']);
        $this->assertEquals('Monster A', $response[1]['name']);
    }

    public function test_should_get_404_error_if_monster_does_not_exists()
    {
        $response = $this->getJson('api/monsters/999999')->assertStatus(Response::HTTP_NOT_FOUND)->json();
        $this->assertEquals('The monster does not exist.', $response['message']);
    }

    public function test_should_create_a_new_monster()
    {
        $monster = Monster::factory()->make();
        $response = $this->postJson('api/monsters', [
            'name' => $monster->name,
            'attack' => $monster->attack,
            'defense' => $monster->defense,
            'hp' => $monster->hp,
            'speed' => $monster->speed,
            'imageUrl' => $monster->imageUrl
        ])->assertStatus(Response::HTTP_CREATED)->json('data');

        $this->assertEquals($monster->name, $response['name']);
    }

    public function test_should_update_a_monster_correctly()
    {
        $this->putJson('api/monsters/1', ['name' => 'updated name of test monster'])->assertStatus(Response::HTTP_OK)->json();
    }

    public function test_should_delete_a_monster_correctly()
    {
        $this->deleteJson('api/monsters/1')->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_should_delete_with_404_error_if_monster_does_not_exists()
    {
        $response = $this->deleteJson('api/monsters/999999')->assertStatus(Response::HTTP_NOT_FOUND)->json();

        $this->assertEquals('The monster does not exist.', $response['message']);
    }

    public function test_should_fail_when_importing_csv_file_with_empty_monster()
    {

        Storage::fake('local');

        $csvContent = "name,attack,defense,hp,speed,imageUrl\n" .
            "Monster1,10,5,100,8,http://example.com/monster1.jpg\n" .
            ",,,,\n" .
            "Monster3,12,6,110,9,http://example.com/monster3.jpg";

        $file = UploadedFile::fake()->createWithContent('monsters.csv', $csvContent);

        $response = $this->post('api/monsters/import-csv', [
            'file' => $file,
        ]);

        $response->assertStatus(400)
            ->assertJson(['message' => 'Wrong data mapping.']);
    }

    public function test_should_fail_when_importing_csv_file_with_wrong_or_inexistent_columns()
    {

        Storage::fake('local');

        $csvContent = "wrongName,wrongAttack,wrongDefense,wrongHp,wrongSpeed,wrongImageUrl\n" .
            "Monster1,10,5,100,8,http://example.com/monster1.jpg\n" .
            "Monster2,15,8,120,7,http://example.com/monster2.jpg";

        $file = UploadedFile::fake()->createWithContent('monsters.csv', $csvContent);

        $response = $this->post('api/monsters/import-csv', [
            'file' => $file,
        ]);

        $response->assertStatus(400)
            ->assertJson(['message' => 'Incomplete data, check your file.']);
    }

    public function test_should_fail_when_trying_import_a_file_with_different_extension()
    {

        Storage::fake('local');
        $fileContent = "This is not a CSV file.";
        $file = UploadedFile::fake()->createWithContent('monsters.txt', $fileContent, 'text/plain');
        $response = $this->post('api/monsters/import-csv', [
            'file' => $file,
        ]);
        $response->assertStatus(400)
            ->assertJson(['message' => 'File should be csv.']);
    }
}
