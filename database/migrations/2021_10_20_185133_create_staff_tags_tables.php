<?php

use Azuriom\Plugin\Staff\Models\Staff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTagsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');
            $table->timestamps();
        });

        Schema::create('staff_taggables', function (Blueprint $table) {
            $table->integer('tag_id');
            $table->integer('taggable_id');
            $table->string('taggable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_tags');
        Schema::dropIfExists('staff_taggables');
    }
}
