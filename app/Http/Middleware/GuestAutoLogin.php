<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;

class GuestAutoLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!Auth::check()) {
                // Find our demo user
                $demoUser = DB::table('users')->where('email', 'demo@fitportal.com')->first();
                
                // Self-healing check: if database is empty/unseeded, seed it automatically!
                if (!$demoUser) {
                    Artisan::call('db:seed');
                    $demoUser = DB::table('users')->where('email', 'demo@fitportal.com')->first();
                }

                if ($demoUser) {
                    // Authenticate the user model
                    $userModel = \App\Models\User::where('email', 'demo@fitportal.com')->first();
                    if ($userModel) {
                        Auth::login($userModel, true); // remember the user
                    }
                }
            }
        } catch (\Exception $e) {
            // Gracefully ignore database connection errors so the app doesn't crash on boot when connection string is missing
        }

        return $next($request);
    }
}
