<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * 设置不需要csrf校验的路由
     *
     * @var array
     */
    protected $except = [
        'oauth/access_token'
    ];
}
