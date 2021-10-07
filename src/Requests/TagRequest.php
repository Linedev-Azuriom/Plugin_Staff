<?php

namespace Azuriom\Plugin\Staff\Requests;

use Azuriom\Rules\Color;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => ['required','string', 'max:50'],
            'color' => ['required', 'string', 'max:50', new Color()],
        ];
    }
}
