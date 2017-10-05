<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
       'centid', 'centname','ip','logo','cordinator'
    ];
    
    protected $primaryKey = 'centid';
    public $incrementing = false;
    protected $table = 'config';
}
