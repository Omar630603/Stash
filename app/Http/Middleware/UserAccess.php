<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use App\Models\DeliveryVehicle;
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
        $branchess = Branch::pluck('ID_user')->all();
        $drivers = DeliveryVehicle::pluck('ID_user')->all();
        $branchessDrivers = array_merge($branchess, $drivers);
        $isUser = False;
        if (Auth::check()) {
            $user = User::where('ID_User', auth()->user()->ID_User)
                ->whereNotIn('ID_user', $branchessDrivers)->first();
            if ($user) {
                $isUser = True;
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
