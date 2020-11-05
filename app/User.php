<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_SUB_ADMIN = 'sub_admin';
    const ROLE_GIVE_CLOTH_PEOPLE = 'give_cloth_people';

    const ROLE_STUDENT = 'student';

    const DEPARTMENT_BACHELOR = '學士';
    const DEPARTMENT_MASTER = '碩士';
    const DEPARTMENT_DOCTOR = '博士';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password','name', 'role', 'base64Img','remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'base64Img', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

}
