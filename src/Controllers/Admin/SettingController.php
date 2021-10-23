<?php

namespace Azuriom\Plugin\Staff\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Staff\Models\Setting;
use Azuriom\Plugin\Staff\Requests\SettingRequest;

class SettingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        dump(Setting::all());
        die();
        $setting = Setting::first();
        return view('staff::admin.settings.index', compact('setting',));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Azuriom\Plugin\staff\Requests\SettingRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SettingRequest $request)
    {
        Setting::create($request->validated());

        return redirect()->route('staff.admin.settings.index')
            ->with('success', trans('staff::admin.setting.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Azuriom\Plugin\Staff\Models\Setting $setting
     */
    public function edit(Setting $setting)
    {
        return view('staff::admin.staff.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Azuriom\Plugin\Staff\Requests\SettingRequest $request
     * @param \Azuriom\Plugin\Staff\Models\Setting          $setting
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request, Setting $setting)
    {

        $collect = []; // empty array for collect customised inputs

        foreach($request->all() as $input_key => $input_value){ // split input one by one
            if ($input_key !== 'name'){
                $collect[] = array( //customised inputs
                                    "effect" => $input_value,
                                    "value" => $input_value

                );
            }
        }
        dump($collect);
        die();

        $request->setting = json_encode($collect);
        Setting::updateOrCreate($request->validated());

        $setting->update($request->validated());
        return redirect()->route('staff.admin.settings.index')
            ->with('success', trans('staff::admin.setting.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Azuriom\Plugin\Staff\Models\Setting $setting
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('staff.admin.settings.index')
            ->with('success', trans('staff::admin.setting.deleted'));
    }
}
