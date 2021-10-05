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
            'pseudo' => ['required', 'unique:staff_staff', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:350'],
            'avatar' => ['nullable'],
            'link.*.icon' => ['nullable', 'string', 'max:50'],
            'link.*.name' => ['nullable', 'string', 'max:50'],
            'link.*.url' => ['nullable', 'string', 'max:50'],
        ];
    }
}
