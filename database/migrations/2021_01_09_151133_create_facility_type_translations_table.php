<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_type_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('facility_type_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['facility_type_id', 'locale']);
            $table->foreign('facility_type_id')->references('id')->on('facility_types')->onDelete('cascade');
        });

        /**
         * Запускаем сидер начальных типов объектов
         */
        (new \Database\Seeders\FacilityTypesSeeder())->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_type_translations');
    }
}
