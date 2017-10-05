<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_centers extends Model
{
    protected $fillable = [
       'centerid', 'center_name','status','ip'
    ];
    
    protected $primaryKey = 'centerid';
    public $incrementing = false;
    protected $table = 'exam_centers';
}
