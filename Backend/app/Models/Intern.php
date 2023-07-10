<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory;
    public $hidden = ['intern_id', 'password', 'created_at', 'updated_at'];
    //public $visible = [];

    protected $guarded = ['id', 'intern_id', 'password'];
    //protected $fillable = [];

    //relationship: hasMany CommentsRates
    
}
