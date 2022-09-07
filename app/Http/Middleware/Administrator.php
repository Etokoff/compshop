<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Administrator
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
        // если это не администратор — показываем 404 Not Found
        if ( ! auth()->user()->admin) {
            abort(404);
        }
        return $next($request);
    }
}
