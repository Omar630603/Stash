<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\DeliverySchedule;
use App\Models\DeliveryVehicle;
use App\Models\Order;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\PseudoTypes\False_;

use function PHPUnit\Framework\isEmpty;

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
    public function adminDelivery(Request $request){
        
        $branch = Admin::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $vehicles = DeliveryVehicle::where('ID_Admin', 'like', '%' . $branch->ID_Admin . '%')->get();
        $orders = Order::Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
        ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
        ->where('units.ID_Admin', 'like', '%' . $branch->ID_Admin . '%')->get();
        $active = false;
        $noDriver = false;
        $activeV = 0;
        $vehicleDriver = 0;
        $searchName = '';
        if($request->get('driver')){
            $schedules = DeliverySchedule::select('*', 'delivery_vehicles.name', 'delivery_schedules.totalPrice', 'delivery_schedules.status')
        ->Join('orders', 'delivery_schedules.ID_Order', '=', 'orders.ID_Order')
        ->Join('delivery_vehicles', 'delivery_schedules.ID_DeliveryVehicle', '=', 'delivery_vehicles.ID_DeliveryVehicle')
        ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
        ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
        ->where('delivery_vehicles.ID_Admin', 'like', '%' . $branch->ID_Admin . '%')
        ->where('delivery_schedules.ID_DeliveryVehicle', 'like', '%' . $request->get('driver') . '%')
        ->get();
        $active = true;
        $activeV = $request->get('driver');
        $vehicleDriver = DeliveryVehicle::where('ID_DeliveryVehicle', $request->get('driver'))->first();


        }elseif($request->get('search')){
            $schedules = DeliverySchedule::select('*', 'delivery_vehicles.name', 'delivery_schedules.totalPrice', 'delivery_schedules.status')
            ->Join('orders', 'delivery_schedules.ID_Order', '=', 'orders.ID_Order')
            ->Join('delivery_vehicles', 'delivery_schedules.ID_DeliveryVehicle', '=', 'delivery_vehicles.ID_DeliveryVehicle')
            ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
            ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
            ->where('delivery_vehicles.ID_Admin', 'like', '%' . $branch->ID_Admin . '%')            
            ->Where('delivery_vehicles.name', 'like', '%' . $request->get('search') . '%')
            ->orWhere('delivery_vehicles.phone', 'like', '%' . $request->get('search') . '%')
            ->orWhere('delivery_vehicles.model', 'like', '%' . $request->get('search') . '%')
            ->orWhere('delivery_vehicles.plateNumber', 'like', '%' . $request->get('search') . '%')
            ->get();
        $active = true;
        $activeV = DeliveryVehicle::Where('delivery_vehicles.name', 'like', '%' . $request->get('search') . '%')
        ->orWhere('delivery_vehicles.phone', 'like', '%' . $request->get('search') . '%')
        ->orWhere('delivery_vehicles.model', 'like', '%' . $request->get('search') . '%')
        ->orWhere('delivery_vehicles.plateNumber', 'like', '%' . $request->get('search') . '%')
        ->first();
            if (!isEmpty($activeV)) {
                $vehicleDriver = DeliveryVehicle::where('ID_DeliveryVehicle', $activeV->ID_DeliveryVehicle)->first();
                $activeV = $activeV->ID_DeliveryVehicle;
            }else{
                $noDriver = true;
                $searchName =$request->get('search');
            }
        }else{
        
        $schedules = DeliverySchedule::select('*', 'delivery_vehicles.name', 'delivery_schedules.totalPrice', 'delivery_schedules.status')
        ->Join('orders', 'delivery_schedules.ID_Order', '=', 'orders.ID_Order')
        ->Join('delivery_vehicles', 'delivery_schedules.ID_DeliveryVehicle', '=', 'delivery_vehicles.ID_DeliveryVehicle')
        ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
        ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
        ->where('delivery_vehicles.ID_Admin', 'like', '%' . $branch->ID_Admin . '%')->get();
        }
        return view('admin.delivery', ['vehicles' => $vehicles, 'schedules' => $schedules,
         'active' => $active, 'activeV' => $activeV, 'branch' => $branch, 'vehicleDriver' => $vehicleDriver
         , 'noDriver' => $noDriver, 'searchName' => $searchName, 'orders' => $orders]);
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
    public function editDriver(Request $request, DeliveryVehicle $driver)
    {
        $request->validate([
            'name' => 'required',
            'model' => 'required',
            'plateNumber' => 'required',
            'phone' => 'required',
            'pricePerK' => 'required',
        ]);
        $driver->name = $request->get('name');
        $driver->model = $request->get('model');
        $driver->plateNumber = $request->get('plateNumber');
        $driver->phone = $request->get('phone');
        $driver->pricePerK = $request->get('pricePerK');
        $driver->save();
        return redirect()->back();
    }
    public function editDriverImage(Request $request, DeliveryVehicle $driver)
    {
        if ($driver->img == "DeliveryVehicle_images/deliveryVehicleDefault.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('DeliveryVehicle_images', 'public');
            }
            $driver->img = $image_name;
        } else {
            Storage::delete('public/' . $driver->img);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('DeliveryVehicle_images', 'public');
            }
            $driver->img = $image_name;
        }
        $driver->save();
        return redirect()->back();
    }
    public function editDriverImageDefult(DeliveryVehicle $driver)
    {
        if ($driver->img == "DeliveryVehicle_images/deliveryVehicleDefault.png") {
            $driver->img = 'DeliveryVehicle_images/deliveryVehicleDefault.png';
        } else {
            Storage::delete('public/' . $driver->img);
            $driver->img = 'DeliveryVehicle_images/deliveryVehicleDefault.png';
        }
        $driver->save();
        return redirect()->back();
    }
    public function addDriver(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'model' => 'required',
            'plateNumber' => 'required',
            'phone' => 'required',
            'pricePerK' => 'required',
        ]);
        $driver = new DeliveryVehicle;
        $driver->ID_Admin = $request->get('ID_Admin');
        $driver->name = $request->get('name');
        $driver->model = $request->get('model');
        $driver->plateNumber = $request->get('plateNumber');
        $driver->phone = $request->get('phone');
        $driver->pricePerK = $request->get('pricePerK');
        $driver->save();
        return redirect()->back();
    }
    public function deleteDriver(DeliveryVehicle $driver)
    {
       $schedules = DeliverySchedule::where('ID_DeliveryVehicle', $driver->ID_DeliveryVehicle)->get();
       foreach ($schedules as $key) {
        $key->delete();
       }
       if ($driver->img != "DeliveryVehicle_images/deliveryVehicleDefault.png") {
        Storage::delete('public/' . $driver->img);
        } 
       $driver->delete();
       return redirect()->route('admin.delivery');
    }

    public function changeScheduleStatus(DeliverySchedule $schedule)
    {
        if ($schedule->status) {
            $schedule->status = false;
        }else{
            $schedule->status = true;
        }
       $schedule->save();
       
       return redirect()->back();
    }
    public function deleteSchedule(DeliverySchedule $schedule)
    {
       $driver = DeliveryVehicle::where('ID_DeliveryVehicle', $schedule->ID_DeliveryVehicle)->first();
       $driver->deliver--;
       $driver->save();
       $schedule->delete();
       return redirect()->back();
    }
    public function addSchedule(Request $request)
    {
        $request->validate([
            'ID_Order' => 'required',
            'ID_DeliveryVehicle' => 'required',
            'pickedUpFrom' => 'required',
            'deliveredTo' => 'required',
            'pickedUp' => 'required',
            'delivered' => 'required',
            'totalPrice' => 'required',
        ]);
        $schedule = new DeliverySchedule();
        $schedule->ID_Order = $request->get('ID_Order');
        $schedule->ID_DeliveryVehicle = $request->get('ID_DeliveryVehicle');
        $schedule->pickedUpFrom = $request->get('pickedUpFrom');
        $schedule->deliveredTo = $request->get('deliveredTo');
        $schedule->pickedUp = $request->get('pickedUp');
        $schedule->delivered = $request->get('delivered');
        $schedule->totalPrice = $request->get('totalPrice');

        if ($request->get('status') == "on") {
            $schedule->status = true;
        }else{
            $schedule->status = false;
        }
        $schedule->save();
        $driver = DeliveryVehicle::where('ID_DeliveryVehicle', $request->get('ID_DeliveryVehicle'))->first();
        $driver->deliver++;
        $driver->save();
        return redirect()->back();
    }
}
