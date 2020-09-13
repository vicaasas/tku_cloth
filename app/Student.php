<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;
    public $table = "students";
    const ROLE_STUDENT = 'student';
    protected $appends = ['role','m_or_b'];
    protected $primaryKey = 'student_id';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'student_id', 'class_id', 'class_name', 'student_name',
    ];
    protected $hidden = [
        'passwd'
    ];
    public function orders()
    {
        return $this->hasMany('App\Order', 'stu_id', 'student_id');
    }
    public function getRoleAttribute()
    {
        return 'student';
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
