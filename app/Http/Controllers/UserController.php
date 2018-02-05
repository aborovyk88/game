<?php namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Permission;
use App\User;
use Illuminate\Http\Request;
use Exception;
use Auth;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct() {
        $this->middleware('auth');
    }


    /**
     * View for users table
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
    public function index() {
        if(!Auth::user()->can(Permission::PERMISSION_USER_LIST)) {
            throw new Exception("You are not have permission for this action", 403);
        }
        return view('user.index');
    }


    /**
     * Get users data with page
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request) {
        if(!Auth::user()->can(Permission::PERMISSION_USER_LIST)) {
            return response()->json([
                                        "success" => false,
                                        "msg" => "You are not have permission for this action",
                                    ]);
        }
        $users = User::getData($request->input());
        $columns = User::getColumnLabels();
        return response()->json([
                                    'data' => $users['data'],
                                    'page_count' => $users['count'],
                                    'columns' => $columns,
                                ]);
    }


    /**
     * Get data user with ID
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(User $user) {
        if(!Auth::user()->can(Permission::PERMISSION_USER_LIST)) {
            return response()->json([
                                        "success" => false,
                                        "msg" => "You are not have permission for this action",
                                    ]);
        }
        return response()->json($user);
    }


    /**
     * Create new user
     *
     * @param UserRequest $userRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(UserRequest $userRequest) {
        try {
            if(!Auth::user()->can(Permission::PERMISSION_USER_EDIT)) {
                throw new Exception("You are not have permission for this action", 403);
            }
            $user = new User($userRequest->all());
            $user->generatePassword();
            $user->save();
            return response()->json([
                                        'success' => true,
                                        'msg' => 'User ' . $user->name . ' has been successful created',
                                    ]);
        }
        catch(Exception $exception) {
            return response()->json([
                                        'success' => false,
                                        'msg' => $exception->getMessage(),
                                    ]);
        }
    }


    /**
     * Delete user
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(User $user) {
        try {
            $authUser = Auth::user();
            if(!$authUser->can(Permission::PERMISSION_USER_DELETE)) {
                throw new Exception("You are not have permission for this action", 403);
            }
            if($authUser->id === $user->id) {
                throw new Exception("You can't remove yourself", 500);
            }
            $user->delete();
            return response()->json([
                                        'success' => true,
                                        'msg' => 'User has been successful delete',
                                    ]);
        }
        catch(Exception $exception) {
            return response()->json([
                                        'success' => false,
                                        'msg' => $exception->getMessage(),
                                    ]);
        }
    }


    /**
     * Update exist user
     *
     * @param UserRequest $userRequest
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $userRequest, User $user) {
        try {
            if(!Auth::user()->can(Permission::PERMISSION_USER_EDIT)) {
                throw new Exception("You are not have permission for this action", 403);
            }
            $user->update($userRequest->all());
            return response()->json([
                                        'success' => true,
                                        'msg' => 'User has been successful updated',
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
