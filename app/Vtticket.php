<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vtticket extends Model
{
    //
	
    protected $fillable = [
		'order_number',
		'order_type',
		'order_subtype',
		'date',
		'status',
		'name',
		'address',
		'location',
		'node',
		'city',
		'region',
		'postalcode',
		'phone',
		'cellular',
		'email',
		'timeframe',
		'service_window',
		'window',
		'time_start',
		'time_end',
		'time_startend',
		'sla_start',
		'sla_end',
		'duration',
		'traveling_time',
		'activity_type',
		'activity_notes',
		'customer_id',
		'services',
		'cod',
		'notes',
		'order_coments',
		'dispatch_coments',
		'reason_cancellation',
		'notes_close',
		'work',
		'zone',
		'reason_close',
		'reason_notdone',
		'reason_suspended'
    ];
	
}
