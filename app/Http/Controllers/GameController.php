<?php namespace App\Http\Controllers;

use App\Games;
use App\Http\Requests\GameRequest;
use Exception;
use Illuminate\Http\Request;
use Auth;

/**
 * Class GameController
 * @package App\Http\Controllers
 */
class GameController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct() {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('game.index', ['user_id' => Auth::user()->id]);
    }


    /**
     * Save game and update user amount
     *
     * @param GameRequest $gameRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GameRequest $gameRequest) {
        $game = new Games($gameRequest->all());
        $success = false;
        $game->is_win = (integer)$game->is_win;
        if($game->save() && $game->user->updateAmount((boolean)$game->is_win)) {
            $success = true;
        }
        return response()->json([
                                    'success' => $success,
                                ]);
    }


    /**
     * Get games data with page
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request) {
        $users = Games::getData($request->input());
        $columns = Games::getColumnLabels();
        return response()->json([
                                    'data' => $users['data'],
                                    'page_count' => $users['count'],
                                    'columns' => $columns,
                                ]);
    }


    /**
     * Get data game with ID
     *
     * @param Games $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Games $game) {
        return response()->json($game);
    }


    /**
     * Delete game
     *
     * @param Games $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Games $game) {
        try {
            $game->delete();
            return response()->json([
                                        'success' => true,
                                        'msg' => 'Game has been successful delete',
                                    ]);
        }
        catch(Exception $exception) {
            return response()->json([
                                        'success' => false,
                                        'msg' => $exception->getMessage(),
                                    ]);
        }
    }
}
