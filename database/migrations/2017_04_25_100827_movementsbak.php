<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Movementsbak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('movementsbak', function (Blueprint $table) {
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
        
        // Crear Foreign Keys
        Schema::table('movementsbak', function ($table) {
            $table->foreign('article_id')
                ->references('id')->on('articles')
                ->onUpdate('cascade');
            $table->foreign('origin_id')
                ->references('id')->on('warehouses')
                ->onUpdate('cascade');
            $table->foreign('destination_id')
                ->references('id')->on('warehouses')
                ->onUpdate('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade');
            $table->foreign('status_id')
                ->references('id')->on('statuses')
                ->onUpdate('cascade');
        });
        
        Schema::table('movementsbak', function ($table) {
            $table->softDeletes();
        });       
        
        Schema::table('movementsbak', function ($table) {
            $table->integer('quantity');
        });
        
        Schema::table('movementsbak', function ($table) {
            $table->integer('ticket');
            $table->integer('approved_by');
            $table->integer('deleted_by');

        });
        
        Schema::table('movementsbak', function ($table) {
            $table->string('note');
        });
        
        Schema::table('movementsbak', function ($table) {
            $table->string('ticket', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('movementsbak');
    }
}
