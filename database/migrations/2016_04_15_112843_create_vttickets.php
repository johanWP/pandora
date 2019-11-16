<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVttickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vttickets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
			$table->integer('order_number');
			$table->string('order_type');
			$table->string('order_subtype');
			$table->date('date');
			$table->string('status');
			$table->string('name');
			$table->string('address');
			$table->string('location')->nullable();
			$table->string('node');
			$table->string('city');
			$table->string('region');
			$table->string('postalcode');
			$table->string('phone');
			$table->string('cellular')->nullable();
			$table->string('email')->nullable();
			$table->string('timeframe');
			$table->string('service_window');
			$table->string('window')->nullable();
			$table->time('time_start')->nullable();
			$table->time('time_end')->nullable();
			$table->string('time_startend')->nullable();
			$table->string('sla_start')->nullable();
			$table->string('sla_end')->nullable();
			$table->time('duration')->nullable();
			$table->time('traveling_time')->nullable();
			$table->string('activity_type')->nullable();
			$table->string('activity_notes')->nullable();
			$table->integer('customer_id');
			$table->string('services')->nullable();
			$table->string('cod')->nullable();
			$table->string('notes')->nullable();
			$table->string('order_coments')->nullable();
			$table->string('dispatch_coments')->nullable();
			$table->string('reason_cancellation')->nullable();
			$table->string('notes_close')->nullable();
			$table->string('work')->nullable();
			$table->string('zone')->nullable();
			$table->string('reason_close')->nullable();
			$table->string('reason_notdone')->nullable();
			$table->string('reason_suspended')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vttickets');
    }
}
