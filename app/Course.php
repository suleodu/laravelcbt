<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
       'csid', 'csname','status',
    ];
    
    protected $primaryKey = 'csid';
    public $incrementing = false;
    protected $table = 'courses';
    
    
    public function assessments()
    {
        return $this->hasMany('App\Assessment', 'csid', 'csid');
    }

}
