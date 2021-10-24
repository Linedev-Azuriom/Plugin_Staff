<?php

namespace Azuriom\Plugin\Staff\Requests;

use Azuriom\Http\Requests\Traits\ConvertCheckbox;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    use ConvertCheckbox;

    /**
     * The checkboxes attributes.
     *
     * @var array
     */
    protected $checkboxes = [
        'settings.0.description', 'settings.0.effect',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string',
            'settings.*' => 'filled',
            'settings.*.effect' => ['filled', 'boolean'],
            'settings.*.description' => ['filled', 'boolean'],
        ];
    }
}
