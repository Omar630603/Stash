<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\DeliverySchedule;
use App\Models\DeliveryVehicle;
use App\Models\Order;
use App\Models\Unit;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    //admin Main Page
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

    //admin Category Page
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
    public function changeUnitStatus(Unit $unit)
    {
        if ($unit->status) {
            $unit->status = false;
        }else{
            $unit->status = true;
        }
       $unit->save();
       $this->changePrivateKeyUnit($unit);
       return redirect()->back();
    }

    //admin Delivery Page
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
            if ($vehicleDriver->ID_Admin != $branch->ID_Admin) {
                $noDriver = true;
                $searchName ='NO ACCESS';
            }
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
                ->where('delivery_vehicles.ID_Admin', 'like', '%' . $branch->ID_Admin . '%')
                ->orWhere('delivery_vehicles.phone', 'like', '%' . $request->get('search') . '%')
                ->orWhere('delivery_vehicles.model', 'like', '%' . $request->get('search') . '%')
                ->orWhere('delivery_vehicles.plateNumber', 'like', '%' . $request->get('search') . '%')
                ->first();
                if ($activeV) {
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
       if ($driver->img != "DeliveryVehicle_images/deliveryVehicleDefault.png") {
        Storage::delete('public/' . $driver->img);
        } 
       $driver->delete();
       return redirect()->route('admin.delivery');
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

    //admin Orders Page
    public function adminOrders(Request $request){
        $branch = Admin::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $admins = Admin::pluck('ID_user')->all();
        $users = User::whereNotIn('ID_user', $admins)->get();
        $categories = Category::all();
        $vehicles = DeliveryVehicle::where('ID_Admin', 'like', '%' . $branch->ID_Admin . '%')->get();
        $active = false;
        $noUser = false;
        $activeU = 0;
        $userProfile = 0;
        $searchName = '';        
        $units = Unit::where('ID_Admin', 'like', '%' . $branch->ID_Admin . '%')->where('status', 'like', '%' . 0 . '%')->orderBy('IdName', 'desc')->get();
        $categories = Category::all();
        
        if($request->get('user')){
            $orders = Order::select('*', 'orders.status')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->where('units.ID_Admin', 'like', '%' . $branch->ID_Admin . '%')
                ->where('orders.ID_User', 'like', '%' . $request->get('user') . '%')
                ->get();
            $active = true;
            $activeU = $request->get('user');
            $userProfile = User::where('ID_User', $request->get('user'))
                ->whereNotIn('ID_user', $admins)
                ->first();
            if ($userProfile) {
                $userProfile = User::where('ID_User', $activeU)->whereNotIn('ID_user', $admins)->first();
            }else{
                $noUser = true;
                $searchName ='NO ACCESS';
            }
            
        }
        elseif($request->get('search')){
            $orders = Order::select('*', 'orders.status')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->where('users.name', 'like', '%' . $request->get('search') . '%')
                ->where('units.ID_Admin', 'like', '%' . $branch->ID_Admin . '%')
                ->get();
            $active = true;
            $activeU = User::Where('users.name', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.phone', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.username', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.email', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.address', 'like', '%' . $request->get('search') . '%')
                ->whereNotIn('ID_user', $admins)
                ->first();
                if ($activeU) {
                    if (in_array($activeU->ID_User, $admins)) {
                        $noUser = true;
                        $searchName =$request->get('search');
                    }else{
                    $userProfile = User::where('ID_User', $activeU->ID_User)->whereNotIn('ID_user', $admins)->first();
                    $activeU = $activeU->ID_User;
                    }
                }else{
                    $noUser = true;
                    $searchName =$request->get('search');
                }
        }
        else{
            $orders = Order::select('*', 'orders.status')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->where('units.ID_Admin', 'like', '%' . $branch->ID_Admin . '%')
                ->get();
        }
        
        return view('admin.orders', ['users' => $users, 'orders' => $orders,
        'active' => $active, 'activeU' => $activeU, 'branch' => $branch, 'userProfile' => $userProfile
        , 'noUser' => $noUser, 'searchName' => $searchName, 'units' => $units,
         'categories' => $categories, 'vehicles' => $vehicles]);
    }
    public function addUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required',
        ]);
        $user = new User;
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');
        $user->password = Hash::make($request->get('password')); 
        $user->save();
        return redirect()->back();
    }
    public function editUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');
        $user->save();
        return redirect()->back();
    }
    public function editUserImage(Request $request, User $user)
    {
        if ($user->img == "User_images/userDefault.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
            $user->img = $image_name;
        } else {
            Storage::delete('public/' . $user->img);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
            $user->img = $image_name;
        }
        $user->save();
        return redirect()->back();
    }
    public function editUserImageDefultCustomer(User $user)
    {
        if ($user->img == "User_images/userDefault.png") {
            $user->img = 'User_images/userDefault.png';
        } else {
            Storage::delete('public/' . $user->img);
            $user->img = 'User_images/userDefault.png';
        }
        $user->save();
        return redirect()->back();
    }
    public function deleteUser(User $user)
    {
       if ($user->img != "User_images/userDefault.png") {
        Storage::delete('public/' . $user->img);
        } 
       $user->delete();
       return redirect()->route('admin.orders');
    }
    
    public function deleteOrder(Order $order)
    {
       $user = User::where('ID_User', $order->ID_User)->first();
       $user->order--;
       $user->save();
       $schedules = DeliverySchedule::where('ID_Order', $order->ID_Order)->get();
       foreach ($schedules as $key) {
            $driver = DeliveryVehicle::where('ID_DeliveryVehicle', $key->ID_DeliveryVehicle)->first();
            $driver->deliver--;
            $driver->save();
            $key->delete();
       }
       $unit = Unit::where('ID_Unit', $order->ID_Unit)->first();
       $unit->status = false;
       $unit->save();
       $this->changePrivateKeyUnit($unit);
       $order->delete();
       return redirect()->back();
    }
    public function addOrder(Request $request)
    {
        $user = null;
        $order = new Order;
        if ($request->get('userNew') == "on") {
            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'password' => 'required',
            ]);
            $user = new User;
            $user->name = $request->get('name');
            $user->username = $request->get('username');
            $user->email = $request->get('email');
            $user->phone = $request->get('phone');
            $user->address = $request->get('address');
            $user->password = Hash::make($request->get('password')); 
            $user->save();
            $ID_User =  $user->ID_User;
            
        }else{
            $ID_User =  $request->get('userOld');
        }
        if ($request->get('userOld') == 0 && !$request->get('userNew')) {
            $message = 'No User Selected';
            return redirect()->back()->with('fail', $message);
        }else{
            if ($user != null) {
                $ID_User =  $user->ID_User;
            }else{
                $ID_User = $request->get('userOld');
            }
        }
        if (!$request->get('Idunit')) {
            $message = 'No Category Selected';
            return redirect()->back()->with('fail', $message);
        }
        $order->ID_User = $ID_User;
        $order->ID_Unit = $request->get('Idunit');
        if ($request->get('startsFrom') == null || $request->get('endsAt') == null) {
            $message = 'Order dates are empty';
            return redirect()->back()->with('fail', $message);
        }else{
            $order->startsFrom = $request->get('startsFrom');
            $order->endsAt = $request->get('endsAt');
            $order->madeByAdmin = 1;
            $order->status = $request->get('status');
            $order->delivery = $request->get('delivery');
            $date1 = new DateTime($request->get('startsFrom'));
            $date2 = new DateTime($request->get('endsAt'));
            $interval = $date1->diff($date2);
            $unit = Unit::where('ID_Unit', $request->get('Idunit'))->first();
            $unit->status = 1;
            $unit->save();
            $category = Category::find($unit->ID_Category)->first();
                if ($interval->d >= 0) {
                    $order->totalPrice = $category->pricePerDay;
                }else{
                $order->totalPrice = $category->pricePerDay * $interval->d;
                }
            $order->save();
            $userOrder = User::where('ID_User', $ID_User)->first();;
            $userOrder->order++;
            $userOrder->save();
            if ($request->get('delivery') == 1) {
                $request->validate([
                    'ID_DeliveryVehicle' => 'required',
                    'pickedUpFrom' => 'required',
                    'deliveredTo' => 'required',
                    'pickedUp' => 'required',
                    'delivered' => 'required',
                    'totalPrice' => 'required',
                ]);
                $schedule = new DeliverySchedule();
                $schedule->ID_Order = $order->ID_Order;
                $schedule->ID_DeliveryVehicle = $request->get('ID_DeliveryVehicle');
                $schedule->pickedUpFrom = $request->get('pickedUpFrom');
                $schedule->deliveredTo = $request->get('deliveredTo');
                $schedule->pickedUp = $request->get('pickedUp');
                $schedule->delivered = $request->get('delivered');
                $schedule->totalPrice = $request->get('totalPrice');
        
                if ($request->get('statusDelivery') == "on") {
                    $schedule->status = true;
                }else{
                    $schedule->status = false;
                }
                $schedule->save();
                $driver = DeliveryVehicle::where('ID_DeliveryVehicle', $request->get('ID_DeliveryVehicle'))->first();
                $driver->deliver++;
                $driver->save();
                $order->totalPrice += $request->get('totalPrice');
                $order->save();
                $message ='Order has been made successfuly';
                return redirect()->back()->with('success', $message);
            }
            $message ='Order has been made successfuly';
            return redirect()->back()->with('success', $message);
        }
    }
}
