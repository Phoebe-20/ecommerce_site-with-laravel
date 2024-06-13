<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    /*-----check the authentication-----*/
    public function handle(Request $request, Closure $next): Response
    {
        if(!empty(Auth::check()))
        {
            /** @var App\Models\User */
            $user = Auth::user();
            if($user->hasRole(['Admin', 'Commercial', 'Staff'])){
                return $next($request); 
            }

            abort(403, "User does not have correct ROLE");
            
            /*if admin is auth, redirect to dashboard*/
            /*if(Auth::user()->is_admin == 1 )
            {
                return $next($request); 
            }*/
            /*if commercial is auth, redirect to com_dashboard*/
            /*elseif(Auth::user()->is_admin == 2 )
            {
                return $next($request);
            }*/
            /*else, redirect to login_admin screen*/
            /*else 
            {
                Auth::logout();
                return redirect('admin');
            }*/
               
        }
        else
        {
            Auth::logout();
            return redirect('admin');       
        }
    }
}
