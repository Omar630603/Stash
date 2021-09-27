<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccess
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
        $admin = Admin::all();
        $isAdmin = False;
        if (Auth::check()) {
            for ($i = 0; $i < count($admin); $i++) {
                if (auth()->user()->ID_User == $admin[$i]->ID_User) {
                    $isAdmin = True;
                    break;
                }
            }
            if ($isAdmin) {
                return $next($request);
            } else {
                return redirect('home')->with('error', "You don't have admin access.");
            }
        } else {
            return redirect()->back();
        }
    }
}
