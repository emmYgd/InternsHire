<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;
    public $hidden = ['employer_id', 'password', 'created_at', 'updated_at'];
    //public $visible = [];
    
    protected $guarded = ['id', /*'employer_id',*/ 'password'];
    //protected $fillable = [];
}
