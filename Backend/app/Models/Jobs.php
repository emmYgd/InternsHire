<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;

    public $hidden = ['id', 'jobs_id', 'employer_id', 'created_at', 'updated_at'];
    //public $visible = [];

    protected $guarded = ['id', /*'jobs_id',*/ 'employer_id'];
    //protected $fillable = [];

    //relationship: hasMany Applications
    public function applications()
    {
        //A Job can have many applications from many users:
        //employer will need this:
        return $this->hasMany(Application::class, 'jobs_id', 'jobs_id');//local and foreign Keys
    }



}
