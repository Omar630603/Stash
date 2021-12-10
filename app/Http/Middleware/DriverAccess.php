<?php

namespace App\Http\Middleware;

use App\Models\DeliveryVehicle;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverAccess
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
        $driver = DeliveryVehicle::all();
        $isDriver = False;
        if (Auth::check()) {
            for ($i = 0; $i < count($driver); $i++) {
                if (auth()->user()->ID_User == $driver[$i]->ID_User) {
                    $isDriver = True;
                    break;
                }
            }
            if ($isDriver) {
                return $next($request);
            } else {
                return redirect('home')->with('error', "You don't have branch access.");
            }
        } else {
            return redirect()->route('login');
        }
    }
}
