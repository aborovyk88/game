<?php namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Exception;
use Auth;

class UserController extends Controller
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
        $users = User::all();
        $array_users = $users->toArray();
        $collection = collect($array_users);
        $array_users = $collection->chunk(10);
        $page_count = $array_users->count();
        $array_users = $array_users->toArray();
        $data = User::getDataLabels($array_users[0]);
        $columns = User::getAttributeLabels();

        $user_columns = json_encode($columns, JSON_UNESCAPED_UNICODE);
        $user_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        return view('user.index', compact('user_data', 'user_columns', 'page_count'));
    }

    public function get(Request $request) {
        $data = $request->input();
        $users = User::all();
        $array_users = $users->toArray();
        $collection = collect($array_users);
        $array_users = $collection->chunk($data['perPage']);
        $page_count = $array_users->count();
        $array_users = $array_users->toArray();
        $data = User::getDataLabels($array_users[$data['currentPage']]);

        return response()->json([
            'data' => $data,
            'page_count' => $page_count
        ]);
    }

    public function getData($id) {
        /** @var User $user */
        $user = User::find($id);

        if (!($user instanceof User)) {
            throw new Exception('User not found', 404);
        }

        $data = $user->toArray();

        return response()->json($data);
    }

    public function create (Request $request) {
        try {
            $data = $request->input('User');
            $user = new User();

            $validator = Validator::make($data, User::$validatorCreate);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 500);
            }

            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['name']);
            $user->remember_token = bcrypt($data['name']);
            $user->created_at = Carbon::now()->format("Y-m-d H:i:s");
            $user->updated_at = Carbon::now()->format("Y-m-d H:i:s");
            if ($user->save()) {
                return response()->json([
                    'success' => true,
                    'msg' => 'User '. $user->name .' has been successful created'
                ]);
            }
        } catch (Exception $exception) {
            return response()->json([
               'success' => false,
               'msg' => $exception->getMessage()
            ]);
        }
    }

    public function delete (Request $request) {
        try {
            $id = $request->input('id');
            $current_user_id = Auth::user()->id;
            $user = User::find($id);

            if (!($user instanceof User)) {
                throw new Exception('User not found', 404);
            } elseif ($current_user_id == $id) {
                throw new Exception('You can not remove yourself', 500);
            }

            if ($user->delete()) {
                return response()->json([
                    'success' => true,
                    'msg' => 'User has been successful delete'
                ]);
            }
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage()
            ]);
        }
    }

    public function update (Request $request) {
        try {
            $id = $request->input('id');
            $data = $request->input('User');

            $user = User::find($id);
            if (!($user instanceof User)) {
                throw new Exception('User not found', 404);
            }

            $validator = Validator::make($data, User::$validatorUpdate);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 500);
            }
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->updated_at = Carbon::now()->format("Y-m-d H:i:s");

            if ($user->update()) {
                return response()->json([
                    'success' => true,
                    'msg' => 'User has been successful updated'
                ]);
            }

        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'msg' => $exception->getMessage()
            ]);
        }
    }
}
