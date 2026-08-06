<?php

use Azuriom\Plugin\Staff\Controllers\Admin\AdminController;
use Azuriom\Plugin\Staff\Controllers\Admin\LinkController;
use Azuriom\Plugin\Staff\Controllers\Admin\SettingController;
use Azuriom\Plugin\Staff\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

Route::middleware('can:staff.admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Staff : pas de page create/show dédiée (formulaire intégré dans index)
    Route::resource('staff', AdminController::class)->except(['index', 'create', 'show']);
    Route::post('staff/update-order', [AdminController::class, 'updateOrder'])->name('staff.update-order');

    // Tags : pas de page index/create dédiée (intégrées dans les tabs de index)
    Route::resource('tags', TagController::class)->only(['store', 'edit', 'update', 'destroy']);
    Route::post('tags/update-order', [TagController::class, 'updateOrder'])->name('tags.update-order');

    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::resource('links', LinkController::class)->only('destroy');
    Route::post('links/update-order', [LinkController::class, 'updateOrder'])->name('links.update-order');
});
