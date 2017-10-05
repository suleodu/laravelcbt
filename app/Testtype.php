<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testtype extends Model
{
    protected $primaryKey = 'ttypid';
    protected $fillable = ['ttypname','status'];
    protected $table = 'test_types';
    
    public function test(){
        return $this->hasMany('App/Test','ttypid', 'ttypid');
    }
}
