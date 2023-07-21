<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

//MY custom auth middleware

class MyAuthMiddleware
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
        //check if request is of admin and if session has role and role is admin
        if($request->path()==='admin_home'  ){
       if($request->session()->has('role') && session('role')==='admin'){
        return $next($request);
       }

       // if not redirect admin to Login page
       return redirect('/admin');
        }

                //check if request is of user and if session has role and role is user
        if($request->path()==='home'  ){
            if($request->session()->has('role') && session('role')==='user'){
             return $next($request);
            }
            return redirect('/');
             }
      
    }
}
