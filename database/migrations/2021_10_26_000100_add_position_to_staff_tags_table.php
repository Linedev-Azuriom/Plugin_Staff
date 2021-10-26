<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionToStaffTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_tags', function (Blueprint $table) {
            $table->unsignedInteger('position')->default(0)->after('color');
        });


        Schema::table('staff_taggables', function (Blueprint $table) {
            $table->unsignedInteger('position')->default(0)->after('taggable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_tags', function (Blueprint $table) {
            $table->dropColumn('position');
        });
        Schema::table('staff_taggables', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
}
