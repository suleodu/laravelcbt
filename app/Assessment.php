<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Assessment extends Model
{
    protected $fillable = [
        'assid', 'csid', 'status', 'ca_score', 'ex_score', 'sesid',
    ];
    
    protected $primaryKey = 'assid';
    
    public $incrementing = false;
    
    protected $table = 'assessments';
    
    
    /**
     * Get the phone record associated with the Assessments.
     */
    public function session() {
        return $this->belongsTo('App\Session', 'sesid', 'sesid');
    }
    
    public function course() {
        return $this->belongsTo('App\Course', 'csid', 'csid');
    }

    public function tests()
    {
        return $this->hasMany('App\Test', 'assid', 'assid');
    }
    
    
}
