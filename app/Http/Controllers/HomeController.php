<?php

namespace App\Http\Controllers;

use App\Models\Branch;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function checkBranch()
    {
        $branch = Branch::all();
        $isBranch = False;
        for ($i = 0; $i < count($branch); $i++) {
            if (auth()->user()->ID_User == $branch[$i]->ID_User) {
                $isBranch = True;
                break;
            }
        }
        return $isBranch;
    }
    public function index()
    {
        if ($this->checkBranch()) {
            return redirect()->route('branch.home');
        }else {
            return redirect()->route('user.home');
        }
    }
}
