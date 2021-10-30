<?php

use Azuriom\Plugin\Staff\Controllers\Admin\AdminController;
use Azuriom\Plugin\Staff\Controllers\Admin\LinkController;
use Azuriom\Plugin\Staff\Controllers\Admin\SettingController;
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
    Route::post('staff/update-order', [AdminController::class, 'updateOrder'])->name('staff.update-order');

    Route::resource('tags', TagController::class);
    Route::post('tags/update-order', [TagController::class, 'updateOrder'])->name('tags.update-order');

    Route::resource('settings', SettingController::class)->only('update');

    Route::resource('links', LinkController::class)->only('destroy');
    Route::post('links/update-order', [LinkController::class, 'updateOrder'])->name('links.update-order');
});
