<?php

namespace App\Http\Requests\Esim;

use App\Models\Esims\Esim;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEsimRequest extends EsimRequest
{
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
        return Esim::updateRules($this->esim);
    }
}
