<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchAccess
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
        $branch = Branch::all();
        $isBranch = False;
        if (Auth::check()) {
            for ($i = 0; $i < count($branch); $i++) {
                if (auth()->user()->ID_User == $branch[$i]->ID_User) {
                    $isBranch = True;
                    break;
                }
            }
            if ($isBranch) {
                return $next($request);
            } else {
                return redirect('home')->with('error', "You don't have branch access.");
            }
        } else {
            return redirect()->route('login');
        }
    }
}
