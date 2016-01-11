<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Auth;
use DB;
use App\Warehouse;
use Illuminate\Database\Eloquent\Collection;
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
                            'company_id',
                            'securityLevel',
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
     * Obtener un arreglo de las actividades asociadas con el usuario actual
     * @return array
     */
    public function getActivityListAttribute()
    {
        return $this->activities->lists('id')->all();
    }

    /**
     * Obtiene los almacenes sobre los que el usuario logueado puede hacer operaciones
     * basado en las actividades y la compañía a la que ambos pertenecen
     * @return Collection
     */
    public function getWarehouseListAttribute()
    {
        $result='';
        $activities = $this->activities()->lists('id')->toArray();
        $warehouses = DB::table('warehouses')
            ->whereIn('activity_id', $activities)
            ->where('active', '=', '1')
            ->where('company_id', '=', $this->company_id)
            ->orderBy('name')
            ->get();

        foreach ($warehouses as $w)
        {
            $result[$w->id] = [
                'id' => $w->id,
                'name' => $w->name,
                'type_id' => $w->type_id,
                'activity_id' => $w->activity_id,
                'active' => $w->active
            ];
        }

        return $result;



    }

    public function movements()
    {
        return $this->hasMany('App\Movement')->withTimestamps();
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


}
