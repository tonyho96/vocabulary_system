<?php

namespace App\Http\Middleware;

use App\Services\TimerService;
use Closure;

class Timer
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
	    TimerService::startOnlineTimer();
	    TimerService::updateOnlineTimer();
	    return $next($request);
    }
}
