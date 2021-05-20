<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedByUserIdToProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('deleted_at_by_receiver');
            $table->integer('deleted_by_user_id')->unsigned()->nullable()->after('deleted_at');
            $table->foreign('deleted_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('deleted_by_user_id');
            $table->timestamp('deleted_at_by_receiver')->nullable()->after('deleted_at');
        });
    }
}
