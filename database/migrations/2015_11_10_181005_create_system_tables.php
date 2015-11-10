<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSystemTables
 */
class CreateSystemTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('companies', function (Blueprint $table) {
            // Columns
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->boolean('parent')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('name');
        });
        Schema::create('activities', function (Blueprint $table) {
            // Columns
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->timestamps();

        });
        Schema::create('articles', function (Blueprint $table) {
            // Columns
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('barcode',12)->nullable();
            $table->boolean('serializable')->default(0);
            $table->boolean('active')->default(1);
            $table->integer('company_id')->unsigned();
            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('active');
            $table->index('company_id');
        });
        Schema::create('warehouses', function (Blueprint $table) {
            // Columns
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('company_id')->unsigned();
            $table->integer('activity_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->timestamps();

            // Indexes
            $table->index('company_id');
            $table->index('activity_id');
            $table->index('type_id');
        });
        Schema::create('types', function (Blueprint $table) {
            // Columns
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->timestamps();
        });
        Schema::create('statuses', function (Blueprint $table) {
            // Columns
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
        });
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

        // Crear Foreign Keys
        Schema::table('movements', function ($table) {
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

        Schema::table('warehouses', function ($table) {
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onUpdate('cascade');
            $table->foreign('activity_id')
                ->references('id')->on('activities')
                ->onUpdate('cascade');
            $table->foreign('type_id')
                ->references('id')->on('types')
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
        Schema::drop('companies');
        Schema::drop('activities');
        Schema::drop('articles');
        Schema::drop('warehouses');
        Schema::drop('types');
        Schema::drop('statuses');
        Schema::drop('movements');

        Schema::table('movements', function ($table) {

            $table->dropForeign('movements_article_id_foreign');
            $table->dropForeign('movements_origin_id_foreign');
            $table->dropForeign('movements_destination_id_foreign');
            $table->dropForeign('movements_user_id_foreign');
            $table->dropForeign('movements_status_id_foreign');
        });


        Schema::table('users', function ($table) {

            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onUpdate('cascade');
        });

        Schema::table('warehouses', function ($table) {
            $table->dropForeign('warehouses_company_id_foreign');
            $table->dropForeign('warehouses_activity_id_foreign');
            $table->dropForeign('warehouses_type_id_foreign');
        });
    }
}
