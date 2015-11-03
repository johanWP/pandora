<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('movements', function ($table) {
            $table->dropForeign('movements_article_id_foreign');
            $table->dropForeign('movements_origin_id_foreign');
            $table->dropForeign('movements_destination_id_foreign');
            $table->dropForeign('movements_user_id_foreign');
            $table->dropForeign('movements_status_id_foreign');
        });

    }
}
