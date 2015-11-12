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

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
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

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function setCompanyIdAttribute()
    {
        $this->attributes['company_id'] = Auth::user()->company_id;
    }
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
