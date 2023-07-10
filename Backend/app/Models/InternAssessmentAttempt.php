<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternAssessmentAttempt extends Model
{
    use HasFactory;

    protected $casts = [ 'options' => 'array' ]; 

    public $hidden = ['answer'];
    //public $visible = [];

    //protected $guarded = [];
    //protected $fillable = [];

    public function setAttemptTimesAttributes($attempt_times)
    {
        $old_attempt_times = $this->attempt_times;
        $new_attempt_times = $old_attempt_times + $attempt_times;

        //set the new value on the table attribute:
        $this->attribute['attempt_times'] = $new_attempt_times 
    }


    public function setPercentageScoreAttribute($test_score)
    {
        $all_test_number = $this->all_test_number;
        $percentage_score = ($testscore/$all_test_number) * 100; 
        
        //set the new value on the table attribute:
        $this->attribute['percentage_score'] = $percentage_score;
    }

    //protected $appends = ['percentage_score'];//return this together with instances of Assessment models

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
