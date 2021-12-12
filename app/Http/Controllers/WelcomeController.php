<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $categories = Category::all();
        return view('welcome', ['categories' => $categories]);
    }
    public function redirectLogin(Request $request)
    {
        $message = $request->get('unit') . "You have to login first";
        return redirect()->route('login')->with('success', $message);;
    }
    public function services()
    {
        $categories = Category::all();
        return view('services', ['categories' => $categories]);
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
