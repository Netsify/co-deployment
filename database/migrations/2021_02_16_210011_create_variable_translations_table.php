<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariableTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variable_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('variable_id')->unsigned();
            $table->string('locale')->index();
            $table->string('description');
            $table->string('unit');

            $table->unique(['variable_id', 'locale']);
            $table->foreign('variable_id')->references('id')->on('variables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variable_translations');
    }
}
