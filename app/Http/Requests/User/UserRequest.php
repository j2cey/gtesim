<?php

namespace App\Http\Requests\User;


use App\Models\User;
use App\Traits\Request\RequestTraits;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserRequest
 * @package App\Http\Requests\User
 *
 * @property User $user
 */
class UserRequest extends FormRequest
{
    use RequestTraits;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
