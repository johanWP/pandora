<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehousesForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
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
        //
        Schema::table('warehouses', function ($table) {
            $table->dropForeign('warehouses_company_id_foreign');
            $table->dropForeign('warehouses_activity_id_foreign');
            $table->dropForeign('warehouses_type_id_foreign');
        });

    }}
