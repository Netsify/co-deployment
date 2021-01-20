<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompatibilityParamDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compatibility_param_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 500);
            $table->integer('param_translation_id')->unsigned();
            $table->integer('type_id')->unsigned();

            $table->unique(['param_translation_id', 'type_id'], 'pt_type_unique');

            $table->foreign('param_translation_id')->references('id')->on('compatibility_param_translations');
            $table->foreign('type_id')->references('id')->on('facility_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compatibility_param_descriptions');
    }
}
