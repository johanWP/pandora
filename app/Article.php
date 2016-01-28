<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class Article extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'name',
        'serializable',
        'barcode',
        'active',
        'fav',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movements()
    {
        return $this->hasMany('App\Movement');
    }


}
