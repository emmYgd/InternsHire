<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\PaymentInterface;
use App\Services\Traits\PaymentAbstractionService;
use Illuminate\Http\Request;

class PaymentController extends Controller //implements InternInterface
{
    use InternAbstractionService;
}
