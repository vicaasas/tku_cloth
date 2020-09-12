<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Represent extends Authenticatable
{
    use Notifiable;
    const ROLE_REPRESENT = 'represent';
    protected $appends = ['role','m_or_b'];
    //protected $rememberTokenName = 'remember_token';
    protected $guard='class';
    protected $primaryKey = 'class_id';
    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';
    
    //public $table = "class";
    protected $fillable = [
        'class_id', 'class_name','printreceipt','receivereceipt'
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
        return 'represent';
    }
    public function getMOrBAttribute()
    {
        $degree=preg_split('//', $this->class_id, -1, PREG_SPLIT_NO_EMPTY);
        if($degree[4]=='B' || $degree[4]=='E'){
            return '學士';
        }
        else{
            return '碩士';
        }
        
    }
}
