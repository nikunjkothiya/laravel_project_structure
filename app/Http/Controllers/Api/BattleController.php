<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StartBattleRequest;
use App\Services\BattleService;
use App\Services\MonsterService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class BattleController extends Controller
{

    /**
     *
     * @var $battleService
     */
    protected $battleService;

    /**
     *
     * @var $monsterService
     */
    protected $monsterService;

    /**
     * BattleService constructor.
     *
     * @param BattleService $battleService
     * @param MonsterService $monsterService
     *
     */
    public function __construct(BattleService $battleService, MonsterService $monsterService)
    {
        $this->battleService = $battleService;
        $this->monsterService = $monsterService;
    }

    /**
     * Get all battles.
     *
     * @return JsonResponse
     *
     */
    public function index(): JsonResponse
    {
        return response()->json(
            [
                'data' => $this->battleService->getAll()
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Start a new battle.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function start(StartBattleRequest $request): JsonResponse
    {
        try {
            // Retrieve validated data directly from the request
            $validated = $request->validated();

            // Fetch monsters from the service
            $monster1 = $this->monsterService->getMonsterById($validated['monsterA']);
            $monster2 = $this->monsterService->getMonsterById($validated['monsterB']);

            // Start the battle and get the result
            $battle = $this->battleService->startBattle($monster1, $monster2);

            // Return a success response
            return response()->json([
                'message' => 'Battle created successfully',
                'battle' => $battle
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return response()->json([
                'message' => 'An error occurred while starting the battle.',
                'error' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete a battle.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->battleService->deleteBattle($id);
            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Battle not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
