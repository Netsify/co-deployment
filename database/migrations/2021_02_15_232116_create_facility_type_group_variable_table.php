<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityTypeGroupVariableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_type_group_variable', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('facility_type_id')->unsigned();
            $table->integer('group_variable_id')->unsigned();

            $table->foreign('facility_type_id', 'f_type_id')->references('id')->on('facility_types');
            $table->foreign('group_variable_id', 'group_id')->references('id')->on('groups_of_variables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_type_group_variable');
    }
}
