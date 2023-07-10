<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    //relationship: Belongs to Jobs:
    public function job()
    {
        //a user can only apply for a job once.//interns will need this
        return $this->hasOne(Jobs::class, 'application_id', 'application_id');
    }

}
