<?php

namespace Azuriom\Plugin\Staff\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => ['required', 'string', 'max:50'],
            'description'  => ['required', 'string', 'max:350'],
            'avatar'  => ['required', 'string', 'max:350'],
        ];
    }
}
