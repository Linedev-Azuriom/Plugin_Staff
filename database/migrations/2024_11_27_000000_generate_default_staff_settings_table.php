<?php

use Azuriom\Models\Setting;
use Illuminate\Database\Migrations\Migration;

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

        if (! Setting::where('name', 'staff.settings')?->first()?->value) {
            Setting::updateSettings('staff.settings', json_encode($default));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
