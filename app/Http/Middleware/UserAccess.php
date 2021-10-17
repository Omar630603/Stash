<?php

namespace App\Http\Middleware;

use App\Models\User;
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
        $user = User::all();
        $isUser = False;
        if (Auth::check()) {
            for ($i = 0; $i < count($user); $i++) {
                if (auth()->user()->ID_User == $user[$i]->ID_User) {
                    $isUser = True;
                    break;
                }
            }
            if ($isUser) {
                return $next($request);
            } else {
                return redirect('home')->with('error', "You don't have user access.");
            }
        } else {
            return redirect()->back();
        }
    }
}
