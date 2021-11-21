<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\DeliveryVehicle;

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
    public function checkDriver()
    {
        $driver = DeliveryVehicle::all();
        $isDriver = False;
        for ($i = 0; $i < count($driver); $i++) {
            if (auth()->user()->ID_User == $driver[$i]->ID_User) {
                $isDriver = True;
                break;
            }
        }
        return $isDriver;
    }
    public function index()
    {
        if ($this->checkBranch()) {
            return redirect()->route('branch.home');
        } else if ($this->checkDriver()) {
            return redirect()->route('driver.home');
        } else {
            return redirect()->route('customer.home');
        }
    }
}
