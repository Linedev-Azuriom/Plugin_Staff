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

        Setting::updateSettings('staff.settings', DB::table('staff_settings')?->first()?->settings ?? []);

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
