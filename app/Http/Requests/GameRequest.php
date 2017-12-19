<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GameRequest
 * @package App\Http\Requests
 */
class GameRequest extends FormRequest
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
        $rules = [
            'is_win' => ['required', 'integer'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
        return $rules;
    }
}
