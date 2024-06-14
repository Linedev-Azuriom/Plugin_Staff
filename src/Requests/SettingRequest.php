<?php

namespace Azuriom\Plugin\Staff\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The checkboxes attribute.
     *
     * @var array
     */
    protected $checkboxes = [
        'description', 'effect',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'settings.*' => ['required', 'array'],
            'description' => ['filled', 'boolean'],
            'effect' => ['filled', 'boolean'],
        ];
    }
}
