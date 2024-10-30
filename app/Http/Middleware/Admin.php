<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->role_id==1){
            return $next($request);
        }else{

            // Log out the user
        Auth::logout();

        // Optionally, you can flash a message before redirection
        // $request->session()->flash('error', 'You do not have permission to access this resource.');

        // Redirect to the login page or any other page as needed
        return redirect()->route('login');


        }

    }
}
