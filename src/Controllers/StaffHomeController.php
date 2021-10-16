<?php

namespace Azuriom\Plugin\Satff\Controllers;

use Azuriom\Http\Controllers\Controller;
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
        $staffs = Staff::all();
        return view('staff.index', compact('staffs'));

    }
}
