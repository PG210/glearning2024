<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Auth;

class RedirectIfSessionExpired
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
        //return $next($request);
        /*if (auth()->guest() || auth()->user()->last_activity < Carbon::now()->subMinutes(config('session.lifetime'))->timestamp) {
           return redirect('/home');
       }*/
       if(Auth::check()){
          return $next($request);
       }else{
         return redirect('http://glearning.com.co/login');
       }

    }
}
