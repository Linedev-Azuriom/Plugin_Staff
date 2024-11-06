<?php

namespace Azuriom\Plugin\Staff\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Azuriom\Plugin\Staff\Models\Staff;

class StaffHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     * @throws \JsonException
     */
    public function index()
    {
        $settings = collect(json_decode(Setting::where('name', 'staff.settings')->first()->value, true, 512, JSON_THROW_ON_ERROR));
        $staffs = Staff::orderBy('position')->get();
        return view('staff::index', compact('staffs', 'settings'));
    }
}
