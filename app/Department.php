<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Department extends Authenticatable
{
    use Notifiable;
    const ROLE_DEPARTMENT = 'department';
    protected $appends = ['role'];
    protected $guard='department';
    protected $primaryKey = 'department_id';
    public $incrementing = false;

    protected $keyType = 'string';
    
    protected $fillable = [
        'department_id', 'department_name',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'passwd'
    ];
    public function getRoleAttribute()
    {
        return 'department';
    }
}
