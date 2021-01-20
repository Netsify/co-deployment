<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDescriptionEnergyColumnInCompatibilityParamTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compatibility_param_translations', function (Blueprint $table) {
            $table->renameColumn('description_energy', 'description_electricity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compatibility_param_translations', function (Blueprint $table) {
            $table->renameColumn('description_electricity', 'description_energy');
        });
    }
}
