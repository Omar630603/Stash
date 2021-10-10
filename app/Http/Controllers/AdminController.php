<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\DeliveryVehicle;
use App\Models\Order;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        $branch = Admin::where('ID_User', 'like', '%' . $admin->ID_User . '%')->first();
        return view('admin.home', ['admin' => $admin, 'branch' => $branch]);
    }
    public function editAdmin(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        $admin->name = $request->get('name');
        $admin->username = $request->get('username');
        $admin->email = $request->get('email');
        $admin->address = $request->get('address');
        $admin->phone = $request->get('phone');
        $admin->save();
        return redirect()->back();
    }
    public function editAdminImage(Request $request, User $admin)
    {
        if ($admin->img == "User_images/userDefault.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
            $admin->img = $image_name;
        } else {
            Storage::delete('public/' . $admin->img);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
            $admin->img = $image_name;
        }
        $admin->save();
        return redirect()->back();
    }
    public function editUserImageDefult(User $admin)
    {
        if ($admin->img == "User_images/userDefault.png") {
            $admin->img = 'User_images/userDefault.png';
        } else {
            Storage::delete('public/' . $admin->img);
            $admin->img = 'User_images/userDefault.png';
        }
        $admin->save();
        return redirect()->back();
    }
    public function editBranch(Request $request, Admin $branch)
    {
        $request->validate([
            'branch' => 'required',
            'city' => 'required',
            'location' => 'required',
        ]);
        $branch->branch = $request->get('branch');
        $branch->city = $request->get('city');
        $branch->location = $request->get('location');
        $branch->save();
        return redirect()->back();
    }
    public function showCategories(){
        $categories = Category::all();
        $branch = Admin::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $units = Unit::where('ID_Admin', 'like', '%' . $branch->ID_Admin . '%')->get();
        return view('admin.categories', ['categories' => $categories, 'units' => $units, 'branch' => $branch]);
    }
    public function addUnit(Request $request){
        
        $unit = new Unit;
        $unit->ID_Category = $request->ID_Category;
        $unit->ID_Admin = $request->ID_Admin;
        $unit->IdName = '0'.$request->ID_Admin.'-0'.$request->ID_Category.'-'.$request->categoryName.'/'.$request->ind;
        $unit->privateKey = $this->generatePrivateKey($request->categoryName, $request->ID_Admin);
        $unit->status = 0;
        
        $unit->save();
        return redirect()->back();
    }
    public function generatePrivateKey($categoryName, $ID_Admin)
    {
        $units = Unit::where('ID_Admin', 'like', '%' . $ID_Admin . '%')->get();
        $privateKey = "S-" . $categoryName[0] ."-" . $this->random_strings(6);
        $isAva = True;
        for ($i = 0; $i < count($units); $i++) {
            if ($units[$i]->privateKey === $privateKey) {
                $isAva = False;
            } else {
                $isAva = True;
            }
        }
        if ($isAva) {
            return $privateKey;
        } else {
            $this->checkIfAva();
        }
        return $privateKey;
    }
    public function random_strings($length_of_string)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(
            str_shuffle($str_result),
            0,
            $length_of_string
        );
    }
    public function deleteUnit(Unit $unit){
        
        $unit->delete();
        return redirect()->back();
    }
    public function changePrivateKeyUnit(Unit $unit){
        $categoryName = Category::where('ID_Category', 'like', '%' . $unit->ID_Category . '%')->first();
        $unit->privateKey = $this->generatePrivateKey($categoryName->name, $unit->ID_Admin);
        $unit->save();
        return redirect()->back();
    }
    public function adminDelivery(){
        $branch = Admin::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $deliveryVehicles = DeliveryVehicle::where('ID_Admin', 'like', '%' . $branch->ID_Admin . '%')->get();
        return view('admin.delivery', ['deliveryVehicles' => $deliveryVehicles]);
    }
    public function adminOrders(){
        $branch = Admin::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $orders = Order::Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
        ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
        ->where('units.ID_Admin', 'like', '%' . $branch->ID_Admin . '%')->get();
        $admins = Admin::pluck('ID_user')->all();
        $users = User::whereNotIn('ID_user', $admins)->get();
        return view('admin.orders', ['orders' => $orders, 'branch' => $branch, 'users' => $users]);
    }
    public function adminMakeOrder(){
        $admins = Admin::pluck('ID_user')->all();
        $users = User::whereNotIn('ID_user', $admins)->get();
        $categories = Category::all();
        $branch = Admin::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $units = Unit::where('ID_Admin', 'like', '%' . $branch->ID_Admin . '%')->where('status', 'like', '%' . 0 . '%')->orderBy('IdName', 'desc')->get();
        return view('admin.handleOrders.makeOrder', ['users' => $users, 'categories' => $categories,
        'branch' => $branch, 'units' => $units]);
    }
    public function adminMakeRent(Request $request)
    {
        dd($request);
    }
}
