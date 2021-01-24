<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompatibilityParamFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compatibility_param_facility', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('facility_id')->unsigned();
            $table->integer('compatibility_param_id')->unsigned();
            $table->integer('value');

            $table->foreign('facility_id')->references('id')->on('facilities')->cascadeOnDelete();
            $table->foreign('compatibility_param_id', 'c_param_id')->references('id')->on('compatibility_params');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compatibility_param_facility');
    }
}
