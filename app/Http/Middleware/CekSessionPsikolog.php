<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekSessionPsikolog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow if user is logged in and their level is either 'psikolog' or 'admin'
        if (!session()->has('level') || (session('level') !== 'psikolog' && session('level') !== 'admin')) {
            return redirect('user/login');
        }
        
        return $next($request);
    }
}
