<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batch';
    
    protected $primaryKey = 'batchid';
    
    protected $fillable = [
        'batch_name'
    ];
}
