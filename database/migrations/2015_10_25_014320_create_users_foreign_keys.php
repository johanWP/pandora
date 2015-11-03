<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function ($table) {
            $table->foreign('activity_id')
                            ->references('id')->on('activities')
                            ->onUpdate('cascade');
            $table->foreign('company_id')
                            ->references('id')->on('companies')
                            ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function ($table) {
            $table->dropForeign('users_activity_id_foreign');
            $table->dropForeign('users_company_id_foreign');
        });

    }}
