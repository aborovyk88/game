<?php namespace App\Http\Controllers;

use App\Games;
use App\Http\Requests\GameRequest;
use App\Permission;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
    public function index() {
        if(!Auth::user()->can(Permission::PERMISSION_GAME_LIST)) {
            throw new Exception("You are not have permission for this action", 403);
        }
        return view('game.index', ['user_id' => Auth::user()->id]);
    }


    /**
     * Save game and update user amount
     *
     * @param GameRequest $gameRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GameRequest $gameRequest) {
        try {
            if(!Auth::user()->can(Permission::PERMISSION_GAME_LIST)) {
                throw new Exception("You are not have permission for this action", 403);
            }
            $game = new Games($gameRequest->all());
            $success = true;
            $game->is_win = (integer)$game->is_win;
            if(!$game->save() || !$game->user->updateAmount((boolean)$game->is_win)) {
                $success = false;
            }
            return response()->json([
                                        'success' => $success,
                                    ]);
        } catch(Exception $ex) {
            return response()->json([
                                        'success' => false,
                                        'msg' => $ex->getMessage(),
                                    ]);
        }
    }


    /**
     * Get games data with page
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request) {
        try {
            if(!Auth::user()->can(Permission::PERMISSION_GAME_LIST)) {
                throw new Exception("You are not have permission for this action", 403);
            }
            $users = Games::getData($request->input());
            $columns = Games::getColumnLabels();
            return response()->json([
                                        'success' => true,
                                        'data' => $users['data'],
                                        'page_count' => $users['count'],
                                        'columns' => $columns,
                                    ]);
        } catch(Exception $ex) {
            return response()->json([
                                        'success' => false,
                                        'msg' => $ex->getMessage(),
                                    ]);
        }
    }


    /**
     * Get data game with ID
     *
     * @param Games $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Games $game) {
        try {
            if(!Auth::user()->can(Permission::PERMISSION_GAME_LIST)) {
                throw new Exception("You are not have permission for this action", 403);
            }
            return response()->json($game);
        } catch(Exception $ex) {
            return response()->json([
                                        'success' => false,
                                        'msg' => $ex->getMessage(),
                                    ]);
        }
    }


    /**
     * Delete game
     *
     * @param Games $game
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Games $game) {
        try {
            if(!Auth::user()->can(Permission::PERMISSION_GAME_LIST)) {
                throw new Exception("You are not have permission for this action", 403);
            }
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
