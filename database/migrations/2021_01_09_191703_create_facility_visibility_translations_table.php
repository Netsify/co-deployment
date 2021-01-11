<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityVisibilityTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_visibility_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visibility_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['visibility_id', 'locale']);
            $table->foreign('visibility_id')->references('id')->on('facility_visibilities')->onDelete('cascade');
        });

        /**
         * Заполнение таблицы начальными данными
         */
        (new \Database\Seeders\FacilityVisibilitySeeder())->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_visibility_translations');
    }
}
