<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $table = 'choices';
    
    protected $fillable = [
        'qid', 'attndid', 'choice', 'status'
    ];
    
    
    public function question()
    {
        return $this->hasOne('App\Question', 'qid', 'qid');
    }
    
    public function attendant()
    {
        return $this->hasOne('App\Attendant', 'attndid', 'attndid');
    }
    
}
