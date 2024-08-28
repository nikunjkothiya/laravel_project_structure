<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportCsvRequest;
use App\Http\Requests\UpdateMonsterRequest;
use App\Services\MonsterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class MonsterController extends Controller
{
    /**
     *
     * @var $monsterService
     */
    protected $monsterService;

    /**
     * MonsterService constructor.
     *
     * @param MonsterService $monsterService
     *
     */
    public function __construct(MonsterService $monsterService)
    {
        $this->monsterService = $monsterService;
    }

    /**
     * Update a monster.
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     */
    public function update(UpdateMonsterRequest $request): JsonResponse
    {
        try {
            $monsterId = $request->route('id');
            $newMonster = $request->only([
                'name',
                'attack',
                'defense',
                'hp',
                'speed',
                'imageUrl'
            ]);

            $result = $this->monsterService->getMonsterById($monsterId);

            if (!$result) {
                return response()->json(['message' => 'The monster does not exist.'], Response::HTTP_NOT_FOUND);
            }

            $this->monsterService->updateMonster($monsterId, $newMonster);
            return response()->json(['message' => 'Monster updated successfully.'], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'The monster does not exist.'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while updating the monster.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Import a csv file.
     *
     * @param ImportCsvRequest $request
     *
     * @return JsonResponse
     *
     */
    public function importCsv(ImportCsvRequest $request): JsonResponse
    {
        $file = $request->file('file');
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (!feof($handle)) {
                $rowData[] = fgetcsv($handle);
            }

            $csv_data = array_slice($rowData, 1, count($rowData));

            try {
                $this->monsterService->importMonster($rowData, $csv_data);
                return response()->json(['data' => 'Records were imported successfully.'], Response::HTTP_OK);
            } catch (QueryException $e) {
                return response()->json(['message' => 'Incomplete data, check your file.'], Response::HTTP_BAD_REQUEST);
            } catch (Exception $e) {
                return response()->json(['message' => 'Wrong data mapping.'], Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
