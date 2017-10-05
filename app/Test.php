<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tid','assid','ttypid','noq', 'mark_obtainable','category',
        'rand_question','image_capture','show_score', 
        'show_rank','start_message','end_message','time', 'status'
    ];
    protected $primaryKey = 'tid';
    
    public $incrementing = false;
    
    public function assessment() 
    {
        return $this->belongsTo('App\Assessment', 'assid', 'assid');
    }
    
    public function testtype() 
    {
        return $this->belongsTo('App\Testtype', 'ttypid', 'ttypid');
    }

    public function session()
    {
        return $this->hasOneThrough('App\Session', 'App\Assessment', 'sesid', 'sesid');
    }
    
    public function attendants() 
    {
        return $this->hasMany('App\Attendant', 'tid', 'tid');
    }
    
}
