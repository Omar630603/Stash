<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\Branch;
use App\Models\Category;
use App\Models\User;
use App\Models\Unit;
use DateTime;
=======
use App\Models\User;
>>>>>>> 92fc941098b055cad93defff323b34e62d7a7004
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //user Main Page
    public function index()
    {
        $customer = Auth::user();
        return view('user.home', ['customer' => $customer]);
    }
    public function editCustomer(Request $request, User $customer)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        $customer->name = $request->get('name');
        $customer->username = $request->get('username');
        $customer->email = $request->get('email');
        $customer->address = $request->get('address');
        $customer->phone = $request->get('phone');
        $customer->save();
        $message = 'Your data has been Edited Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function editCustomerImage(Request $request, User $customer)
    {
        if ($customer->user_img == "User_images/userDefault.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
            $customer->user_img = $image_name;
        } else {
            Storage::delete('public/' . $customer->user_img);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
        }
        $customer->user_img = $image_name;
        $customer->save();
        $message = 'Your Image has changed Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function editCustomerImageDefult(User $customer)
    {
        if ($customer->user_img != "User_images/userDefault.png") {
            Storage::delete('public/' . $customer->user_img);
        }
        $customer->user_img = 'User_images/userDefault.png';
        $customer->save();
        $message = 'Your Default Image Returend Successfully';
        return redirect()->back()->with('success', $message);
    }
<<<<<<< HEAD
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
    
=======
>>>>>>> 92fc941098b055cad93defff323b34e62d7a7004
}
