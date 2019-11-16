<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VtticketsIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vttickets', function (Blueprint $table) {
            //
			$table->index('date');
			$table->index('status');
			$table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vttickets', function (Blueprint $table) {
            //
			$table->dropindex('date');
			$table->dropindex('status');
			$table->dropindex('customer_id');
        });
    }
}
