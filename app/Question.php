<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = [
        'qid', 'tid', 'question', 'instruction', 'option1','option2', 'option3','option4', 'choice', 'status'
    ];
    
    //protected $hidden = ['choice'];


    public function choice()
    {
        return $this->belongsTo('App\Choice', 'qid', 'qid');
    }

}
