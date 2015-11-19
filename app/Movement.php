<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movement extends Model
{
    use SoftDeletes;
    //
    protected $fillable=[
        'remito',
        'article_id',
        'origin_id',
        'serial',
        'destination_id',
        'user_id',
        'status_id',
        'quantity',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    public function getArticleCountAttribute()
    {
        $dummy = 100;
        return $dummy;
    }
}
