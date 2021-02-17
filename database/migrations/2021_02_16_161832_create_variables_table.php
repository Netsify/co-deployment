<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->float('min_val', 11, 2);
            $table->float('max_val', 11, 2);
            $table->float('default_val', 11, 2);
            $table->string('type')->index();
            $table->integer('group_id')->unsigned();
            $table->integer('category_of_variable_id')->unsigned();
            $table->timestamps();

            $table->foreign('category_of_variable_id', 'category_id')
                ->references('id')
                ->on('categories_of_variables');
            $table->foreign('group_id')->references('id')->on('groups_of_variables');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variables');
    }
}
