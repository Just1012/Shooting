<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EnsureSessionIsActive
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
        if (Auth::check()) {
            $lastActivity = $request->session()->get('lastActivityTime');

            if ($lastActivity) {
                $inactivityLimit = 30; // Inactivity limit in minutes

                // Calculate the difference in minutes
                $inactiveTime = Carbon::now()->diffInMinutes(Carbon::parse($lastActivity));

                if ($inactiveTime > $inactivityLimit) {
                    Auth::logout();
                    $request->session()->forget('lastActivityTime');
                    if ($request->expectsJson()) {
                        return response()->json(['message' => 'Your session has expired.'], 401);
                    }
                    return redirect()->route('login')->with('message', 'Your session has expired.');
                }
            }

            // Update 'lastActivityTime' to the current time
            $request->session()->put('lastActivityTime', Carbon::now());
        } else {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login')->with('message', 'Please log in to continue.');
        }

        return $next($request);
    }
}