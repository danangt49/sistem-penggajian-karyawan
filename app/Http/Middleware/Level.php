<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Level
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (($request->user()->level == 'admin' && $request->user()->status == 'AKTIF') || 
            ($request->user()->level == 'pegawai' && $request->user()->status == 'AKTIF') ||
            ($request->user()->level == 'direktur' && $request->user()->status == 'AKTIF')) {
            return $next($request);
        }
 
        return redirect()
            ->to(route('login'));
    }
}
