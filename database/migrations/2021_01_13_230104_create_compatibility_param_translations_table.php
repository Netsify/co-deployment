<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompatibilityParamTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compatibility_param_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('param_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->string('description_road', 500)->nullable();
            $table->string('description_railway', 500)->nullable();
            $table->string('description_energy', 500)->nullable();
            $table->string('description_other', 500)->nullable();
            $table->string('description_ict', 500)->nullable();

            $table->unique(['param_id', 'locale']);
            $table->foreign('param_id')->references('id')->on('compatibility_params')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compatibility_param_translations');
    }
}
