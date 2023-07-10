<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AdminInterface;
use App\Services\Traits\AdminAbstractionService;
use Illuminate\Http\Request;

class AdminEmployersExtrasController extends Controller //implements AdminInterface
{
    use AdminAbstractionService;
    
}
