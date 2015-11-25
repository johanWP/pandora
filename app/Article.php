<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Article extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'name',
        'serializable',
        'barcode',
        'active',
        'company_id',
        'product_code'
    ];

    protected $dates = ['deleted_at'];
    /**
     * Un Articulo pertenece a una (y solo una) empresa
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function movements()
    {
        return $this->hasMany('App\Movement');
    }
}
