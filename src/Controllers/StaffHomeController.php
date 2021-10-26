<?php

namespace Azuriom\Plugin\Staff\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Staff\Models\Setting;
use Azuriom\Plugin\Staff\Models\Staff;

class StaffHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::first();
        $staffs = Staff::all();
        return view('staff::index', compact('staffs', 'settings'));

    }
}
