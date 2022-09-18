<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgentRequest extends FormRequest
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
        $id = $this->route('agent');
        return [
            'name' => 'required',
            'phone' => 'required|unique:clients,phone,' . $id,
            'coin_amount' => 'required',
            'commision' => 'required',
            'referee_id' => 'unique:clients,referee_id,' .  $id,
            'operationstaff_id' => 'unique:clients,operationstaff_id,' . $id,
            'profile_img' => 'mimes:jpeg,png,jpg'
        ];
    }
}
