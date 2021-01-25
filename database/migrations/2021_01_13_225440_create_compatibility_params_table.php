<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompatibilityParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compatibility_params', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->integer('group_id')->unsigned();
            $table->integer('min_val');
            $table->integer('max_val');
            $table->integer('default_val');
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('compatibility_param_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compatibility_params');
    }
}
