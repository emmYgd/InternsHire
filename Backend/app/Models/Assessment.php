<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    public $hidden = ['admin_id', 'answer']; //'password', 'created_at', 'updated_at'];
    //public $visible = [];

    //protected $guarded = ['id', 'intern_id', 'password'];
    //protected $fillable = [];

    //cast json type into array on access automatically:
    /*protected $casts = [
        'options' => 'array'
    ];*/

    public function intern_assessment_attempts()
    {
        return $this->hasMany(InternAssessmentAttempt::class);
    }

}
