<?php namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
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
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = User::getPaginateData();
        $columns = User::getAttributeLabels();
        $page_count = $data['count'];
        $user_columns = json_encode($columns, JSON_UNESCAPED_UNICODE);
        $user_data = json_encode($data['data'], JSON_UNESCAPED_UNICODE);
        return view('user.index', compact('user_data', 'user_columns', 'page_count'));
    }


    /**
     * Get users data with page
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request) {
        $data = $request->input();
        $users = User::getPaginateData($data['currentPage'], $data['perPage'], $data['filters'], $data['orders']);
        $columns = User::getAttributeLabels();
        return response()->json([
                                    'data' => $users['data'],
                                    'page_count' => $users['count'],
                                    'columns' => $columns
                                ]);
    }


    /**
     * Get data user with ID
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(User $user) {
        return response()->json($user);
    }


    /**
     * Create new user
     * @param UserRequest $userRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(UserRequest $userRequest) {
        try {
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
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(User $user) {
        try {
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
     * @param UserRequest $userRequest
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $userRequest, User $user) {
        try {
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
