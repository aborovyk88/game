<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UserRequest
 * @package App\Http\Requests
 */
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $uniqueRule = Rule::unique('users');
        $userModel = $this->route('user');
        if($userModel) {
            $uniqueRule->ignore($userModel->email, 'email');
        }
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', $uniqueRule],
            'amount' => ['integer'],
        ];
        return $rules;
    }
}
