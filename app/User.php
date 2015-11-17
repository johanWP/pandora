<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use SoftDeletes;
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'username',
                            'firstName',
                            'lastName',
                            'email',
                            'password',
                            'employee_id',
                            'active'
                            ];

    protected $dates = ['deleted_at'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     *  Setea el atributo company_id igual al que tiene el usuario logueado en ese momento
     */
    public function setCompanyIdAttribute()
    {
        $this->attributes['company_id'] = Auth::user()->company_id;
    }

    /**
     * Retorna la compan˜a a la que pertenece el usuario
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');

    }

    /**
     * Obtener las actividades que realiza un usuario
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activities()
    {

        return $this->belongsToMany('App\Activity')->withTimestamps();
    }

    /**
     * Obtener un arreglo de las actividades asociadas con el usuario actual
     * @return array
     */
    public function getActivityListAttribute()
    {

        return $this->activities->lists('id')->all();
    }
}
