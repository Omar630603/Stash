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
}
