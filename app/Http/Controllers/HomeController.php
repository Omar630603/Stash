<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;

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
    public function index()
    {
        if ($this->checkAdmin()) {
            return redirect()->route('admin.home');
        }else {
            return redirect()->route('user.home');
        }
    }
    public function welcome()
    {
        $categories = Category::all();
        return view('welcome', ['categories' => $categories]);
    }
}
