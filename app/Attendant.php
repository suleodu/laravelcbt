<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendant extends Model
{
    protected $table = 'attendants';
    
    protected $primaryKey = 'attndid';
    
    public $incrementing = false;
    
    protected $fillable = [
        'attndid','userid', 'tid', 'status', 'batchid', 'used_time'
    ];
    
    
    public function user() {
        return $this->belongsTo('App\User', 'userid', 'userid');
    }
    
    public function test() {
        return $this->belongsTo('App\Test', 'tid', 'tid');
    }
    
    public function batch() {
        return $this->belongsTo('App\Batch', 'batchid', 'batchid');
    }
    
}
