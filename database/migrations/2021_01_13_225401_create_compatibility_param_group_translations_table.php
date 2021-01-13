<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompatibilityParamGroupTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compatibility_param_group_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('param_group_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['param_group_id', 'locale'], 'gid_loc');
            $table->foreign('param_group_id')->references('id')->on('compatibility_param_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compatibility_param_group_translations');
    }
}
