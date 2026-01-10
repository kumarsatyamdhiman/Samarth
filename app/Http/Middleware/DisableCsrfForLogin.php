<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class DisableCsrfForLogin extends Middleware
{
    protected $except = [
        'login',
    ];
}
