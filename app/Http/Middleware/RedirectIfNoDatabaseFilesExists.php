<?php

namespace App\Http\Middleware;

use App\Models\DatabaseFile;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class RedirectIfNoDatabaseFilesExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (currentTenantDBFile() == null && $request->route()->getName() != ltrim(RouteServiceProvider::HOME, '/')) {
            $request->session()->flash('error', 'No sqlite database file uploaded yet!');
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
