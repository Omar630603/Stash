<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use App\Models\Category;
use App\Models\Unit;
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
    //User Categories
    public function showCategories()
    {
        $categories = Category::all();
        $branches = Branch::all();
        $units = Unit::all();
        return view('user.categories', ['categories' => $categories, 'units' => $units, 'branches' => $branches]);
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
    public function chooseCity()
    {
        $cities = Branch::select('city')->groupby('city')->get();
        return view('user.makeOrder.chooseCity', ['cities' => $cities]);
    }
}
