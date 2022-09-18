<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRefereeRequest extends FormRequest
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
        $id = $this->route('referee');
        return [
            'name' => 'required',
            'phone' => 'required|min:9|max:11,unique:clients,phone,' . $id,
            'operationstaff_id' => 'required'

        ];
    }
}
