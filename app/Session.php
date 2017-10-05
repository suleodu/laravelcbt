<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
       'sesname', 'passmark','status',
    ];
    
    protected $primaryKey = 'sesid';
    
    
    public function assessments() {
        return $this->hasMany('App\Assessment', 'sesid', 'sesid');
    }

}
