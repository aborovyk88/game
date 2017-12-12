<?php namespace App\Http\Controllers;

use App\Games;
use Illuminate\Http\Request;
use Validator;

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

    public function store (Request $request) {
        $data = $request->input();
        $success = false;
        $validator = Validator::make($data, Games::$validator);

        if ($validator->fails()) {
            session()->flash('error', $validator->errors()->first());
            $this->throwValidationException($request, $validator);
        }
        $game = new Games();

        if ($game->setData($data) && $game->save() && $game->user->updateAmount((boolean)$game->is_win)) {
            $success = true;
        }
        return response()->json([
            'success' => $success
        ]);
    }

    public function listItems ($id) {

    }
}
