<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekSessionUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('level') || (session('level') !== 'inovator' && session('level') !== 'user' && session('level') !== 'admin')) {
            return redirect('user/login');
        }
        return $next($request);
    }
}
