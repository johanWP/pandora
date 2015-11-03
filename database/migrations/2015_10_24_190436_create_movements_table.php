<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('movements', function (Blueprint $table) {
            // Columns
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('remito',50);
            $table->integer('article_id')->unsigned();
            $table->string('serial', 50)->nullable();
            $table->integer('origin_id')->unsigned();
            $table->integer('destination_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->timestamps();

            // Indexes
            $table->index('status_id');
            $table->index('article_id');
            $table->index('serial');
            $table->index('origin_id');
            $table->index('destination_id');
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
        Schema::drop('movements');
    }
}
