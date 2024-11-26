<?php

use Azuriom\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $default = [
            'description' => true,
            'effect' => true,
            'style' => '1',
            'column' => '1',
            'alignment' => 'start',
        ];

        Setting::updateSettings('staff.settings', Schema::hasTable('staff_settings') ? DB::table('staff_settings')?->first()?->settings : $default);

        Schema::dropIfExists('staff_settings');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('staff_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('settings')->nullable();
            $table->timestamps();
        });
    }
};
