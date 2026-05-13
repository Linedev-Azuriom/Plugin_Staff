<?php

namespace Azuriom\Plugin\Staff\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \JsonException
     */
    public function update(Request $request)
    {

        $input = [
            'description' => $request->has('description'),
            'effect'      => $request->has('effect'),
            'style'       => $request->input('style'),
            'column'      => $request->input('column'),
            'alignment'   => $request->input('alignment'),
            'avatar_size' => max(90, min(320, (int) $request->input('avatar_size', 120))),
        ];

        Setting::updateSettings('staff.settings', json_encode($input, JSON_THROW_ON_ERROR));

        return redirect()->route('staff.admin.index')
            ->with('success', trans('staff::admin.setting.updated'));
    }
}
