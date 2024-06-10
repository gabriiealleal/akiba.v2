<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*', // substitua 'api/*' pela URI da sua rota de geração de token
        'api/login', // substitua 'api/login' pela URI da sua rota de geração de token
    ];
}
