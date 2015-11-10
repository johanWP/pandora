<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
        // Columns
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('username')->unique();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email');
            $table->string('password', 60);
            $table->boolean('active')->default(1);
            $table->integer('company_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('securityLevel')->unsigned();
            $table->rememberToken();
            $table->timestamps();

        // Indexes
            $table->index('activity_id');
            $table->index('company_id');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
