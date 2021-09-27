<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAccess
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
        if (Auth::check()) {
            if ($this->checkAdmin()) {
                return redirect()->back();
            }
            else {
                return $next($request);
            }
        } else {
            return redirect()->back();
        }
    }
    public function checkAdmin()
    {
        $admin = Admin::all();
        $isAdmin = False;
        for ($i = 0; $i < count($admin); $i++) {
            if (auth()->user()->ID_User == $admin[$i]->ID_User) {
                $isAdmin = True;
                break;
            }
        }
        return $isAdmin;
    }
}
