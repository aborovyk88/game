<?php namespace App\Http\Controllers;

use App\Games;
use App\Http\Requests\GameRequest;

/**
 * Class GameController
 * @package App\Http\Controllers
 */
class GameController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('game.index');
    }

    /**
     * Save game and update user amount
     *
     * @param GameRequest $gameRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store (GameRequest $gameRequest) {
        $game = new Games($gameRequest->all());
        $success = false;
        $game->is_win = (integer)$game->is_win;
        if ($game->save() && $game->user->updateAmount((boolean)$game->is_win)) {
            $success = true;
        }
        return response()->json([
            'success' => $success
        ]);
    }
}
