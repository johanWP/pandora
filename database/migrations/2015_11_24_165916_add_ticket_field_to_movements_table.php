<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTicketFieldToMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movements', function ($table) {
            $table->integer('ticket');
            $table->integer('approved_by');
            $table->integer('deleted_by');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movements', function ($table) {
            $table->dropColumn('ticket');
            $table->dropColumn('approved_by');
            $table->dropColumn('deleted_by');
        });
    }
}
