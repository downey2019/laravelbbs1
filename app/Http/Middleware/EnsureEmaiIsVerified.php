<?php

namespace App\Http\Middleware;

use Closure;

class EnsureEmaiIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   

        if($request->user() &&
            ! $request->user()->hasVerifiedEmail() &&
            ! $request->is('email/*','logout'))
            {
                return $request->expectsJson()
                                ? abort(403,'你的邮箱还未验证，请前往邮箱验证')
                                : redirect()->route('verification.notice');
            }

        return $next($request);
    }
}
