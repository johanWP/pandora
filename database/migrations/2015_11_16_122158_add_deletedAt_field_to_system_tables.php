<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedAtFieldToSystemTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function ($table) {
            $table->softDeletes();
        });

        Schema::table('articles', function ($table) {
            $table->softDeletes();
        });

        Schema::table('companies', function ($table) {
            $table->softDeletes();
        });

        Schema::table('movements', function ($table) {
            $table->softDeletes();
        });

        Schema::table('statuses', function ($table) {
            $table->softDeletes();
        });

        Schema::table('types', function ($table) {
            $table->softDeletes();
        });

        Schema::table('users', function ($table) {
            $table->softDeletes();
        });

        Schema::table('warehouses', function ($table) {
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function ($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('articles', function ($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('companies', function ($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('movements', function ($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('statuses', function ($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('types', function ($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('users', function ($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('warehouses', function ($table) {
            $table->dropColumn('deleted_at');
        });

    }
}
