<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Message;
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
    public function sendMessage(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'isUser' => 'required',
        ]);
        $message = new Message;
        $message->name = $request->get('name');
        $message->email = $request->get('email');
        $message->subject = $request->get('subject');
        $message->message = $request->get('message');
        $message->is_user = $request->get('isUser');
        $message->save();
        $message = 'Your meesage have been sent successfuly';
        return redirect()->back()->with('success', $message);
    }
    public function aboutUs()
    {
        return view('aboutUs');
    }
}
