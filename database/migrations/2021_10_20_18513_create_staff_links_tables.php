<?php

use Azuriom\Plugin\Staff\Models\Staff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffLinksTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('icon');
            $table->timestamps();
        });


        Schema::create('staff_linkables', function (Blueprint $table) {
            $table->integer('link_id');
            $table->integer('linkable_id');
            $table->string('linkable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_links');
        Schema::dropIfExists('staff_linkables');
    }
}
