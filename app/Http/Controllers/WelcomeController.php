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
    public function rent()
    {
        return view('user.home');
    }
}
