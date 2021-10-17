<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    //User Orders Page
    public function userOrders(Request $request){
        $branch = User::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $users = User::pluck('ID_user')->all();
        $users = User::whereNotIn('ID_user', $users)->get();
        $categories = Category::all();
        $vehicles = DeliveryVehicle::where('ID_User', 'like', '%' . $branch->ID_User . '%')->get();
        $active = false;
        $noUser = false;
        $activeU = 0;
        $userProfile = 0;
        $searchName = '';
        $units = Unit::where('ID_User', 'like', '%' . $branch->ID_User . '%')->where('status', 'like', '%' . 0 . '%')->orderBy('IdName', 'desc')->get();
        $categories = Category::all();

        if($request->get('user')){
            $orders = Order::select('*', 'orders.status')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->where('units.ID_User', 'like', '%' . $branch->ID_User . '%')
                ->where('orders.ID_User', 'like', '%' . $request->get('user') . '%')
                ->get();
            $active = true;
            $activeU = $request->get('user');
            $userProfile = User::where('ID_User', $request->get('user'))
                ->whereNotIn('ID_user', $users)
                ->first();
            if ($userProfile) {
                $userProfile = User::where('ID_User', $activeU)->whereNotIn('ID_user', $users)->first();
            }else{
                $noUser = true;
                $searchName ='NO ACCESS';
            }
        }
        elseif($request->get('search')){
            $orders = Order::select('*', 'orders.status')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->where('users.username', 'like', '%' . $request->get('search') . '%')
                ->where('units.ID_User', 'like', '%' . $branch->ID_User . '%')
                ->get();
            $active = true;
            $activeU = User::Where('users.name', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.phone', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.username', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.email', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.address', 'like', '%' . $request->get('search') . '%')
                ->whereNotIn('ID_user', $users)
                ->first();
                if ($activeU) {
                    if (in_array($activeU->ID_User, $users)) {
                        $noUser = true;
                        $searchName =$request->get('search');
                    }else{
                    $userProfile = User::where('ID_User', $activeU->ID_User)->whereNotIn('ID_user', $users)->first();
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
                ->where('units.ID_User', 'like', '%' . $branch->ID_User . '%')
                ->get();
        }
        return view('user.orders', ['users' => $users, 'orders' => $orders,
        'active' => $active, 'activeU' => $activeU, 'branch' => $branch, 'userProfile' => $userProfile
        , 'noUser' => $noUser, 'searchName' => $searchName, 'units' => $units,
         'categories' => $categories, 'vehicles' => $vehicles]);
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
       return redirect()->route('user.orders');
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
            $order->madeByUser = 1;
            $order->status = $request->get('status');
            $order->delivery = $request->get('delivery');
            $date1 = new DateTime($request->get('startsFrom'));
            $date2 = new DateTime($request->get('endsAt'));
            $interval = $date1->diff($date2);
            $unit = Unit::where('ID_Unit', $request->get('Idunit'))->first();
            $unit->status = 1;
            $unit->save();
            $category = Category::find($unit->ID_Category)->first();
                if ($interval->d = 0 && $interval->m = 0 && $interval->y = 0) {
                    $order->totalPrice = $category->pricePerDay;
                }else{
                $order->totalPrice = $category->pricePerDay * $interval->days;
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
    public function userOrderDetailsU(Unit $unit)
    {
        $order = Order::where('ID_Unit', $unit->ID_Unit)->first();
        return redirect()->route('user.orderDetails', ['order' => $order]);
    }
    public function userOrderDetails(Order $order)
    {
        $customer = User::where('ID_User', $order->ID_User)->first();
        $branch = User::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $vehicles = DeliveryVehicle::where('ID_User', 'like', '%' . $branch->ID_User . '%')->get();
        $schedules = DeliverySchedule::Join('delivery_vehicles', 'delivery_schedules.ID_DeliveryVehicle', '=', 'delivery_vehicles.ID_DeliveryVehicle')
                ->where('delivery_vehicles.ID_User', 'like', '%' . $branch->ID_User . '%')
                ->where('delivery_schedules.ID_Order', 'like', '%' . $order->ID_Order . '%')
                ->get();
        $unit = Unit::where('ID_Unit', $order->ID_Unit)->first();
        $category = Category::where('ID_Category', $unit->ID_Category)->first();
        return view('user.handelOrder.orderDetails', ['order' => $order, 'unit' => $unit,
         'category' => $category, 'customer' => $customer, 'branch' => $branch, 'schedules' => $schedules, 'vehicles' => $vehicles]);
    }
    public function extendOrder(Request $request, Order $order)
    {
        $date1 = new DateTime($order->endsAt);
        $date2 = new DateTime($request->get('extendEndsAt'));
        $interval = $date1->diff($date2);

        $unit = Unit::where('ID_Unit', $order->ID_Unit)->first();
        $category = Category::find($unit->ID_Category)->first();
        $extentionPrice = 0;
        if ($interval->d <= 0 && $interval->m <= 0 && $interval->y <= 0 && $interval->h > 0) {
            $order->totalPrice += $category->pricePerDay;
            $extentionPrice= $category->pricePerDay;
        }else{
            $order->totalPrice += $category->pricePerDay * $interval->days;
            $extentionPrice= $category->pricePerDay * $interval->days;;
        }
        $order->endsAt= $request->get('extendEndsAt');
        $order->expandPrice = $extentionPrice;
        $order->save();
        return redirect()->back();
    }
    public function changeOrderStatus(Request $request, Order $order)
    {
       $order->status = $request->get('status');
       $order->save();
       return redirect()->back();
    }
}
