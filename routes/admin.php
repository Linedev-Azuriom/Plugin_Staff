<?php

use Azuriom\Plugin\Staff\Controllers\Admin\AdminController;
use Azuriom\Plugin\Staff\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::middleware('can:staff.admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('staff', AdminController::class)->except('index');
    Route::resource('tags', TagController::class);
});
