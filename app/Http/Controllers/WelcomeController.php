<?php

namespace App\Http\Controllers;

use App\Models\Category;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $categories = Category::all();
        return view('welcome', ['categories' => $categories]);
    }
    public function redirectLogin()
    {
        $message = "You have to login first";
        return redirect()->route('login')->with('success', $message);;
    }
    public function services()
    {
        return view('services');
    }
    public function contactUs()
    {
        return view('contactUs');
    }
    public function aboutUs()
    {
        return view('aboutUs');
    }
}
