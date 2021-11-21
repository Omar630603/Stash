<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\User;
use App\Models\Unit;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    //user Main Page
    public function index()
    {
        $user = Auth::user();
        return view('user.home', ['user' => $user]);
    }
    public function editUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'address',
            'phone',
        ]);
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $user->save();
        return redirect()->back();
        $message = 'User data has been Edited Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function editUserImage(Request $request, User $user)
    {
        if ($user->user_img == "User_images/userDefault.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
            $user->user_img = $image_name;
        } else {
            Storage::delete('public/' . $user->user_img);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
        }
        $user->user_img = $image_name;
        $user->save();
        $message = 'Branch Image has changed Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function editUserImageDefult(User $user)
    {
        if ($user->user_img != "User_images/userDefault.png") {
            Storage::delete('public/' . $user->user_img);
        }
        $user->user_img = 'User_images/userDefault.png';
        $user->save();
        $message = 'Branch Default Image Returend Successfully';
        return redirect()->back()->with('success', $message);
    }

    //user Categories
    public function showCategories()
    {
        $categories = Category::all();
        $branch = Branch::all();
        $units = Unit::all();
        return view('user.categories', ['categories' => $categories, 'units' => $units, 'branch' => $branch]);
    
    }
    
}
