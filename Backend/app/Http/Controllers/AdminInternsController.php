<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AdminInterface;
use App\Services\Traits\AdminAbstractionService;
use Illuminate\Http\Request;

class AdminInternsController extends Controller //implements AdminInterface
{
    use AdminAbstractionService;
}
