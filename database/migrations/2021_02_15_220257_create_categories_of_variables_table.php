<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesOfVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_of_variables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('name_ru');
            $table->string('name_en');
            $table->timestamps();
        });

        (new \Database\Seeders\CategoriesOfVacilitiesSeeder())->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_of_variables');
    }
}
