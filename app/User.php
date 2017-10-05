<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'fname', 'lname','mname','userid', 'email', 'password','access'
    ];
    public $incrementing = false;
    protected $primaryKey = 'userid';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    


    public function isAdmin()
    { 
        
        if(in_array($this->access, array("super", "admin1", "admin2"))){
           return 'true' ;
        }
        else
        {
           return 'false';
        }  
    }
    
    
    
    public function attendants() {
        return $this->hasMany('App\Attendant', 'useid', 'userid');
    }
}
