<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Category;
use App\Models\DeliverySchedule;
use App\Models\DeliveryVehicle;
use App\Models\Order;
use App\Models\Transactions;
use App\Models\Unit;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class BranchController extends Controller
{
    //Branch Main Page
    public function index()
    {
        $branchEmployee = Auth::user();
        $branch = Branch::where('ID_User', 'like', '%' . $branchEmployee->ID_User . '%')->first();
        $banks = Bank::where('ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->get();
        return view('branch.home', ['branchEmployee' => $branchEmployee, 'branch' => $branch, 'banks' => $banks]);
    }
    public function editBranchEmployee(Request $request, User $branchEmployee)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        $branchEmployee->name = $request->get('name');
        $branchEmployee->username = $request->get('username');
        $branchEmployee->email = $request->get('email');
        $branchEmployee->address = $request->get('address');
        $branchEmployee->phone = $request->get('phone');
        $branchEmployee->save();
        return redirect()->back();
        $message = 'Branch Employee data has been Edited Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function editBranchEmployeeImage(Request $request, User $branchEmployee)
    {
        if ($branchEmployee->user_img == "User_images/userDefault.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
            $branchEmployee->user_img = $image_name;
        } else {
            Storage::delete('public/' . $branchEmployee->user_img);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('User_images', 'public');
            }
        }
        $branchEmployee->user_img = $image_name;
        $branchEmployee->save();
        $message = 'Branch Image has changed Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function editBranchEmployeeImageDefult(User $branchEmployee)
    {
        if ($branchEmployee->user_img != "User_images/userDefault.png") {
            Storage::delete('public/' . $branchEmployee->user_img);
        }
        $branchEmployee->user_img = 'User_images/userDefault.png';
        $branchEmployee->save();
        $message = 'Branch Default Image Returend Successfully';
        return redirect()->back()->with('success', $message);
    }
    public function editBranch(Request $request, Branch $branch)
    {
        $request->validate([
            'branch_name' => 'required',
            'city' => 'required',
            'branch_address' => 'required',
        ]);
        $branch->branch_name = $request->get('branch_name');
        $branch->city = $request->get('city');
        $branch->branch_address = $request->get('branch_address');
        $message = 'Branch Data has been edited';
        return redirect()->back()->with('success', $message);
    }

    //Branch Category Page
    public function showCategories()
    {
        $categories = Category::all();
        $branch = Branch::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $units = Unit::where('ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->get();
        return view('branch.categories', ['categories' => $categories, 'units' => $units, 'branch' => $branch]);
    }
    public function addUnit(Request $request)
    {
        if ($request->amount <= 0) {
            $message = 'Amount is equal to 0, No Unit added';
            return redirect()->back()->with('fail', $message);
        } else {
            for ($i = 0; $i < $request->amount; $i++) {
                $unit = new Unit;
                $unit->ID_Category = $request->ID_Category;
                $unit->ID_Branch = $request->ID_Branch;
                $unit->unit_name = '0' . $request->ID_Branch . '-0' . $request->ID_Category . '-' . $request->categoryName . '/' . $request->ind;
                $unit->privateKey = $this->generatePrivateKey($request->categoryName, $request->ID_Branch);
                $unit->unit_status = 0;
                $unit->save();
                $request->ind++;
            }
        }
        $message = $request->amount . ' New Unit/s added';
        return redirect()->back()->with('success', $message);
    }
    public function generatePrivateKey($categoryName, $ID_Branch)
    {
        $units = Unit::where('ID_Branch', 'like', '%' . $ID_Branch . '%')->get();
        $privateKey = "S-" . $categoryName[0] . "-" . $this->random_strings(6);
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
    public function deleteUnit(Unit $unit)
    {
        if ($unit->unit_status) {
            $order = Order::where('ID_Unit', $unit->ID_Unit)->first();
            $user = User::where('ID_User', $order->ID_User)->first();
            $user->ordered--;
            $user->save();
        }

        $unit->delete();
        return redirect()->back();
    }
    public function changePrivateKeyUnit(Unit $unit)
    {
        $categoryName = Category::where('ID_Category', 'like', '%' . $unit->ID_Category . '%')->first();
        $unit->privateKey = $this->generatePrivateKey($categoryName->category_name, $unit->ID_Branch);
        $unit->save();
        $message = $unit->unit_name . ' Unit Private Key Has Changed';
        return redirect()->back()->with('success', $message);
    }

    public function branchOrderDetailsU(Unit $unit)
    {
        $order = Order::where('ID_Unit', $unit->ID_Unit)->first();
        return redirect()->route('branch.orderDetails', ['order' => $order]);
    }
    //Branch Delivery Page
    public function branchDelivery(Request $request)
    {
        $branch = Branch::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $vehicles = DeliveryVehicle::where('ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->get();
        $orders = Order::Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
            ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
            ->where('units.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->get();
        $active = false;
        $noDriver = false;
        $activeV = 0;
        $vehicleDriver = 0;
        $searchName = '';
        $banks = Bank::where('ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->get();
        if ($request->get('driver')) {
            $schedules = DeliverySchedule::select('*')
                ->Join('orders', 'delivery_schedules.ID_Order', '=', 'orders.ID_Order')
                ->Join('delivery_vehicles', 'delivery_schedules.ID_DeliveryVehicle', '=', 'delivery_vehicles.ID_DeliveryVehicle')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->where('delivery_vehicles.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')
                ->where('delivery_schedules.ID_DeliveryVehicle', 'like', '%' . $request->get('driver') . '%')
                ->orderBy('delivery_schedules.created_at', 'desc')->get();
            $active = true;
            $activeV = $request->get('driver');
            $vehicleDriver = DeliveryVehicle::where('ID_DeliveryVehicle', $request->get('driver'))->first();

            if (!$vehicleDriver || $vehicleDriver->ID_Branch != $branch->ID_Branch) {
                $noDriver = true;
                $searchName = 'NO ACCESS';
            }
        } elseif ($request->get('search')) {
            $schedules = DeliverySchedule::select('*',)
                ->Join('orders', 'delivery_schedules.ID_Order', '=', 'orders.ID_Order')
                ->Join('delivery_vehicles', 'delivery_schedules.ID_DeliveryVehicle', '=', 'delivery_vehicles.ID_DeliveryVehicle')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->where('delivery_vehicles.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')
                ->Where('delivery_vehicles.vehicle_name', 'like', '%' . $request->get('search') . '%')
                ->orWhere('delivery_vehicles.vehicle_phone', 'like', '%' . $request->get('search') . '%')
                ->orWhere('delivery_vehicles.model', 'like', '%' . $request->get('search') . '%')
                ->orWhere('delivery_vehicles.plateNumber', 'like', '%' . $request->get('search') . '%')
                ->orderBy('delivery_schedules.created_at', 'desc')->get();
            $active = true;
            $activeV = DeliveryVehicle::Where('delivery_vehicles.vehicle_name', 'like', '%' . $request->get('search') . '%')
                ->where('delivery_vehicles.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')
                ->orWhere('delivery_vehicles.vehicle_phone', 'like', '%' . $request->get('search') . '%')
                ->orWhere('delivery_vehicles.model', 'like', '%' . $request->get('search') . '%')
                ->orWhere('delivery_vehicles.plateNumber', 'like', '%' . $request->get('search') . '%')
                ->first();
            if ($activeV) {
                $vehicleDriver = DeliveryVehicle::where('ID_DeliveryVehicle', $activeV->ID_DeliveryVehicle)->first();
                $activeV = $activeV->ID_DeliveryVehicle;
            } else {
                $noDriver = true;
                $searchName = $request->get('search');
            }
        } else {
            $schedules = DeliverySchedule::select('*')
                ->Join('orders', 'delivery_schedules.ID_Order', '=', 'orders.ID_Order')
                ->Join('delivery_vehicles', 'delivery_schedules.ID_DeliveryVehicle', '=', 'delivery_vehicles.ID_DeliveryVehicle')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->where('delivery_vehicles.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')
                ->orderBy('delivery_schedules.created_at', 'desc')->get();
        }
        return view('branch.delivery', [
            'vehicles' => $vehicles, 'schedules' => $schedules,
            'active' => $active, 'activeV' => $activeV, 'branch' => $branch, 'vehicleDriver' => $vehicleDriver, 'noDriver' => $noDriver, 'searchName' => $searchName, 'orders' => $orders, 'banks' => $banks
        ]);
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
        $driver->vehicle_name = $request->get('name');
        $driver->model = $request->get('model');
        $driver->plateNumber = $request->get('plateNumber');
        $driver->vehicle_phone = $request->get('phone');
        $driver->pricePerK = $request->get('pricePerK');
        $driver->save();
        $message = 'Driver Data Has been Edited';
        return redirect()->back()->with('success', $message);
    }
    public function editDriverImage(Request $request, DeliveryVehicle $driver)
    {
        if ($driver->vehicle_img == "DeliveryVehicle_images/deliveryVehicleDefault.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('DeliveryVehicle_images', 'public');
            }
            $driver->vehicle_img = $image_name;
        } else {
            Storage::delete('public/' . $driver->vehicle_img);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('DeliveryVehicle_images', 'public');
            }
            $driver->vehicle_img = $image_name;
        }
        $driver->save();
        $message = 'Driver Image Has been Changed';
        return redirect()->back()->with('success', $message);
    }
    public function editDriverImageDefult(DeliveryVehicle $driver)
    {
        if ($driver->vehicle_img == "DeliveryVehicle_images/deliveryVehicleDefault.png") {
            $driver->vehicle_img = 'DeliveryVehicle_images/deliveryVehicleDefault.png';
        } else {
            Storage::delete('public/' . $driver->vehicle_img);
            $driver->vehicle_img = 'DeliveryVehicle_images/deliveryVehicleDefault.png';
        }
        $driver->save();
        $message = 'Driver Image Has been Restored';
        return redirect()->back()->with('success', $message);
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
        $driver->ID_Branch = $request->get('ID_Branch');
        $driver->vehicle_name = $request->get('name');
        $driver->model = $request->get('model');
        $driver->plateNumber = $request->get('plateNumber');
        $driver->vehicle_phone = $request->get('phone');
        $driver->pricePerK = $request->get('pricePerK');
        $driver->save();
        $message = 'New Driver Has been Added';
        return redirect()->back()->with('success', $message);
    }
    public function deleteDriver(DeliveryVehicle $driver)
    {
        if ($driver->vehicle_img != "DeliveryVehicle_images/deliveryVehicleDefault.png") {
            Storage::delete('public/' . $driver->vehicle_img);
        }
        $driver->delete();
        return redirect()->route('branch.delivery');
    }
    public function addSchedule(Request $request)
    {
        $schedule = new DeliverySchedule();
        if (!$request->get('ID_Order')) {
            $message = 'Add Order';
            return redirect()->back()->with('fail', $message);
        }
        $schedule->ID_Order = $request->get('ID_Order');
        if (!$request->get('ID_DeliveryVehicle')) {
            $message = 'Add Vehicle';
            return redirect()->back()->with('fail', $message);
        }
        $schedule->ID_DeliveryVehicle = $request->get('ID_DeliveryVehicle');
        $schedule->schedule_status = $request->get('status');
        $schedule->schedule_description = $request->get('description_type') . ': ' . $request->get('description_note');
        if (!$request->get('pickedUpFrom') || !$request->get('deliveredTo')) {
            $message = 'Add Trip Detials';
            return redirect()->back()->with('fail', $message);
        }
        $schedule->pickedUpFrom = $request->get('pickedUpFrom');
        $schedule->deliveredTo = $request->get('deliveredTo');
        if (!$request->get('pickedUp') || !$request->get('delivered')) {
            $message = 'Add Trip Date Detials';
            return redirect()->back()->with('fail', $message);
        }
        $schedule->pickedUp = $request->get('pickedUp');
        $schedule->delivered = $request->get('delivered');
        if (!$request->get('totalPrice')) {
            $message = 'Add Price';
            return redirect()->back()->with('fail', $message);
        }
        $schedule->schedule_totalPrice = $request->get('totalPrice');
        $schedule->save();

        $order = Order::where('ID_Order', $request->get('ID_Order'))->first();
        $order->order_totalPrice += $request->get('totalPrice');
        $order->order_deliveries++;
        $order->save();

        $transaction = new Transactions;
        $transaction->ID_Order = $order->ID_Order;
        $unit = Unit::where('ID_Unit', $order->ID_Unit)->first();
        $transaction->transactions_description = 'Delivery: ' . $request->get('description_type') . '. For Unit (' . $unit->unit_name . ')';
        $transaction->transactions_totalPrice = $request->get('totalPrice');
        if ($request->get('transaction') == 1) {
            if ($request->get('ID_Bank') == 0) {
                $message = 'Select Bank';
                return redirect()->back()->with('fail', $message);
            } else {
                $transaction->ID_Bank = $request->get('ID_Bank');
            }
            $transaction->transactions_status = 1;
            if ($request->file('proof')) {
                $image_name = $request->file('proof')->store('transactions_images', 'public');
                $transaction->proof = $image_name;
            } else {
                $message = 'Add Proof';
                return redirect()->back()->with('fail', $message);
            }
            $transaction->save();
        } else {
            $transaction->transactions_status = 0;
            $transaction->proof = 'Waiting for Payment';
            $transaction->save();
        }
        $driver = DeliveryVehicle::where('ID_DeliveryVehicle', $request->get('ID_DeliveryVehicle'))->first();
        $driver->vehicle_deliveries++;
        $driver->save();
        $message = 'New Schedule Has been Added';
        return redirect()->back()->with('success', $message);
    }
    public function editSchedule(Request $request, DeliverySchedule $schedule)
    {
        $request->validate([
            'ID_DeliveryVehicle' => 'required',
            'pickedUpFrom' => 'required',
            'deliveredTo' => 'required',
            'pickedUp' => 'required',
            'delivered' => 'required',
            'totalPrice' => 'required',
        ]);
        $driver = DeliveryVehicle::where('ID_DeliveryVehicle', $schedule->ID_DeliveryVehicle)->first();
        $driver->vehicle_deliveries--;
        $driver->save();

        $schedule->ID_DeliveryVehicle = $request->get('ID_DeliveryVehicle');
        $schedule->pickedUpFrom = $request->get('pickedUpFrom');
        $schedule->deliveredTo = $request->get('deliveredTo');
        $schedule->pickedUp = $request->get('pickedUp');
        $schedule->delivered = $request->get('delivered');

        $order = Order::where('ID_Order', $schedule->ID_Order)->first();
        $order->order_totalPrice -= $schedule->totalPrice;
        $order->order_totalPrice += $request->get('totalPrice');
        $order->save();

        $schedule->schedule_totalPrice = $request->get('totalPrice');
        $schedule->save();

        $driver = DeliveryVehicle::where('ID_DeliveryVehicle', $request->get('ID_DeliveryVehicle'))->first();
        $driver->vehicle_deliveries++;
        $driver->save();
        $message = 'Schedule Has been Edited';
        return redirect()->back()->with('success', $message);
    }
    public function changeScheduleStatus(Request $request, DeliverySchedule $schedule)
    {
        $schedule->schedule_status = $request->get('status');
        $schedule->save();
        $message = 'Schedule Status Has been Updated';
        return redirect()->back()->with('success', $message);
    }
    public function deleteSchedule(DeliverySchedule $schedule)
    {
        $driver = DeliveryVehicle::where('ID_DeliveryVehicle', $schedule->ID_DeliveryVehicle)->first();
        $driver->vehicle_deliveries--;
        $driver->save();
        $order = Order::where('ID_Order', $schedule->ID_Order)->first();
        $order->order_deliveries--;
        $order->save();
        $schedule->delete();
        $message = 'Schedule Has been Deleted';
        return redirect()->back()->with('success', $message);
    }

    //Branch Orders Page
    public function branchOrders(Request $request)
    {
        $branch = Branch::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $branchess = Branch::pluck('ID_user')->all();
        $users = User::whereNotIn('ID_user', $branchess)->get();
        $categories = Category::all();
        $vehicles = DeliveryVehicle::where('ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->get();
        $active = false;
        $noUser = false;
        $activeU = 0;
        $userProfile = 0;
        $searchName = '';
        $units = Unit::where('ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->where('unit_status', 'like', '%' . 0 . '%')->orderBy('unit_name', 'desc')->get();
        $categories = Category::all();
        $banks = Bank::where('ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->get();
        $schedules = DeliverySchedule::select('ID_Order', 'schedule_status')
            ->Join('delivery_vehicles', 'delivery_schedules.ID_DeliveryVehicle', '=', 'delivery_vehicles.ID_DeliveryVehicle')
            ->where('delivery_vehicles.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->get();
        $transactions = Transactions::select('transactions.ID_Order', 'transactions_status')
            ->Join('orders', 'orders.ID_Order', '=', 'transactions.ID_Order')
            ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
            ->where('units.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->get();
        if ($request->get('user')) {
            $orders = Order::select('*')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->where('units.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')
                ->where('orders.ID_User', 'like', '%' . $request->get('user') . '%')
                ->orderBy('orders.created_at', 'desc')->get();
            $active = true;
            $activeU = $request->get('user');
            $userProfile = User::where('ID_User', $request->get('user'))
                ->whereNotIn('ID_user', $branchess)
                ->first();
            if ($userProfile) {
                $userProfile = User::where('ID_User', $activeU)->whereNotIn('ID_user', $branchess)->first();
            } else {
                $noUser = true;
                $searchName = 'NO ACCESS';
            }
        } elseif ($request->get('search')) {
            $orders = Order::select('*')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->where('users.username', 'like', '%' . $request->get('search') . '%')
                ->where('units.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')
                ->orderBy('orders.created_at', 'desc')->get();
            $active = true;
            $activeU = User::Where('users.name', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.phone', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.username', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.email', 'like', '%' . $request->get('search') . '%')
                ->orWhere('users.address', 'like', '%' . $request->get('search') . '%')
                ->whereNotIn('ID_user', $branchess)
                ->first();
            if ($activeU) {
                if (in_array($activeU->ID_User, $branchess)) {
                    $noUser = true;
                    $searchName = $request->get('search');
                } else {
                    $userProfile = User::where('ID_User', $activeU->ID_User)->whereNotIn('ID_user', $branchess)->first();
                    $activeU = $activeU->ID_User;
                }
            } else {
                $noUser = true;
                $searchName = $request->get('search');
            }
        } else {
            $orders = Order::select('*')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->where('units.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')
                ->orderBy('orders.created_at', 'desc')->get();
        }

        return view('branch.orders', [
            'users' => $users, 'orders' => $orders,
            'active' => $active, 'activeU' => $activeU, 'branch' => $branch, 'userProfile' => $userProfile, 'noUser' => $noUser, 'searchName' => $searchName, 'units' => $units,
            'categories' => $categories, 'vehicles' => $vehicles, 'banks' => $banks, 'schedules' => $schedules,
            'transactions' => $transactions
        ]);
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
        $message = 'New User Has been Added';
        return redirect()->back()->with('success', $message);
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
        $message = 'User Has been Edited';
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
            $user->user_img = $image_name;
        }
        $user->save();
        $message = 'User Image Has been Edited';
        return redirect()->back()->with('success', $message);
    }
    public function editUserImageDefultCustomer(User $user)
    {
        if ($user->user_img == "User_images/userDefault.png") {
            $user->user_img = 'User_images/userDefault.png';
        } else {
            Storage::delete('public/' . $user->user_img);
            $user->user_img = 'User_images/userDefault.png';
        }
        $user->save();
        $message = 'User Image Has been Restored';
        return redirect()->back()->with('success', $message);
    }
    public function deleteUser(User $user)
    {
        if ($user->user_img != "User_images/userDefault.png") {
            Storage::delete('public/' . $user->img);
        }
        $orders = Order::where('ID_User', $user->ID_User)->get();
        foreach ($orders as $order) {
            $schedules = DeliverySchedule::where('ID_Order', $order->ID_Order)->get();
            foreach ($schedules as $key) {
                $driver = DeliveryVehicle::where('ID_DeliveryVehicle', $key->ID_DeliveryVehicle)->first();
                $driver->vehicle_deliveries--;
                $driver->save();
                $key->delete();
            }
            $transactions = Transactions::where('ID_Order', $order->ID_Order)->get();
            foreach ($transactions as $key) {
                if ($key->proof != 'Waiting for Payment') {
                    Storage::delete('public/' . $key->proof);
                }
                $key->delete();
            }
            $unit = Unit::where('ID_Unit', $order->ID_Unit)->first();
            $unit->unit_status = false;
            $unit->capacity = 0;
            $unit->save();
            $this->changePrivateKeyUnit($unit);
            $order->delete();
        }
        $user->delete();
        $message = 'User Has been Deleted';
        return redirect()->route('branch.orders')->with('success', $message);;
    }

    public function deleteOrder(Order $order)
    {
        $user = User::where('ID_User', $order->ID_User)->first();
        $user->ordered--;
        $user->save();
        $schedules = DeliverySchedule::where('ID_Order', $order->ID_Order)->get();
        foreach ($schedules as $key) {
            $driver = DeliveryVehicle::where('ID_DeliveryVehicle', $key->ID_DeliveryVehicle)->first();
            $driver->vehicle_deliveries--;
            $driver->save();
            $key->delete();
        }
        $transactions = Transactions::where('ID_Order', $order->ID_Order)->get();
        foreach ($transactions as $key) {
            if ($key->proof != 'Waiting for Payment') {
                Storage::delete('public/' . $key->proof);
            }
            $key->delete();
        }
        $unit = Unit::where('ID_Unit', $order->ID_Unit)->first();
        $unit->unit_status = false;
        $unit->capacity = 0;
        $unit->save();
        $this->changePrivateKeyUnit($unit);
        $order->delete();
        $message = 'Order Has been Deleted';
        return redirect()->route('branch.orders')->with('success', $message);;
    }
    public function addOrder(Request $request)
    {
        $request->validate([
            'transaction' => 'required',
            'delivery' => 'required',
            'order_status' => 'required',
            'Idunit' => 'required',
        ]);
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
        } else {
            $ID_User =  $request->get('userOld');
        }
        if ($request->get('userOld') == 0 && !$request->get('userNew')) {
            $message = 'No User Selected';
            return redirect()->back()->with('fail', $message);
        } else {
            if ($user != null) {
                $ID_User =  $user->ID_User;
            } else {
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
        } else {
            $order->startsFrom = $request->get('startsFrom');
            $order->endsAt = $request->get('endsAt');
            $order->madeBy = 1;
            $order->order_status = $request->get('order_status');
            $order->order_description = $request->get('order_description');
            $date1 = new DateTime($request->get('startsFrom'));
            $date2 = new DateTime($request->get('endsAt'));
            $interval = $date1->diff($date2);
            $unit = Unit::where('ID_Unit', $request->get('Idunit'))->first();
            $category = Category::where('ID_Category', $unit->ID_Category)->first();
            if ($interval->days == 0) {
                $order->order_totalPrice = $category->pricePerDay;
            } else {
                $order->order_totalPrice = $category->pricePerDay * $interval->days;
            }
            if ($request->get('capacity')) {
                $unit->unit_status = 1;
                $unit->capacity = $request->get('capacity');
            } else {
                $message = 'Insert Capacity';
                return redirect()->back()->with('fail', $message);
            }
            $order->save();
            $unit->save();
            $userOrder = User::where('ID_User', $ID_User)->first();
            $userOrder->ordered++;
            $userOrder->save();
            $transaction = new Transactions;
            if ($request->get('transaction') == 1) {
                $transaction->ID_Order = $order->ID_Order;
                if ($request->get('ID_Bank') == 0) {
                    $message = 'Select Bank';
                    return redirect()->back()->with('fail', $message);
                } else {
                    $transaction->ID_Bank = $request->get('ID_Bank');
                }
                $transaction->transactions_description = 'Entry Transaction For Unit (' . $unit->unit_name . ')';
                $transaction->transactions_totalPrice = $order->order_totalPrice;
                $transaction->transactions_status = 1;
                if ($request->file('proof')) {
                    $image_name = $request->file('proof')->store('transactions_images', 'public');
                    $transaction->proof = $image_name;
                } else {
                    $message = 'Add Proof';
                    return redirect()->back()->with('fail', $message);
                }
                $transaction->save();
            } else if ($request->get('transaction') == 2) {
                $transaction->ID_Order = $order->ID_Order;
                $transaction->transactions_description = 'Entry Transaction For Unit (' . $unit->unit_name . ')';
                $transaction->transactions_totalPrice = $order->order_totalPrice;
                $transaction->transactions_status = 0;
                $transaction->proof = 'Waiting for Payment';
                $transaction->save();
            }

            if ($request->get('delivery') == 1) {
                $schedule = new DeliverySchedule();
                $schedule->ID_Order = $order->ID_Order;
                if (!$request->get('ID_DeliveryVehicle')) {
                    $message = 'Add Vehicle';
                    return redirect()->back()->with('fail', $message);
                }
                $schedule->ID_DeliveryVehicle = $request->get('ID_DeliveryVehicle');
                $schedule->schedule_status = $request->get('status');
                $schedule->schedule_description = $request->get('description_type') . ': ' . $request->get('description_note');
                if (!$request->get('pickedUpFrom') || !$request->get('deliveredTo')) {
                    $message = 'Add Trip Detials';
                    return redirect()->back()->with('fail', $message);
                }
                $schedule->pickedUpFrom = $request->get('pickedUpFrom');
                $schedule->deliveredTo = $request->get('deliveredTo');
                if (!$request->get('pickedUp') || !$request->get('delivered')) {
                    $message = 'Add Trip Date Detials';
                    return redirect()->back()->with('fail', $message);
                }
                $schedule->pickedUp = $request->get('pickedUp');
                $schedule->delivered = $request->get('delivered');
                if (!$request->get('totalPrice')) {
                    $message = 'Add Price';
                    return redirect()->back()->with('fail', $message);
                }
                $schedule->schedule_totalPrice = $request->get('totalPrice');
                $schedule->save();
                $driver = DeliveryVehicle::where('ID_DeliveryVehicle', $request->get('ID_DeliveryVehicle'))->first();
                $driver->vehicle_deliveries++;
                $driver->save();
                $order->order_deliveries++;
                $order->order_totalPrice += $request->get('totalPrice');
                $order->save();
                $transaction->transactions_totalPrice = $order->order_totalPrice;
                $transaction->transactions_description = 'Entry Transaction + Delivery: ' . $request->get('description_type') . '. For Unit (' . $unit->unit_name . ')';
                $transaction->save();
                $message = 'Order has been made successfuly';
                return redirect()->back()->with('success', $message);
            }
            $message = 'Order has been made successfuly';
            return redirect()->back()->with('success', $message);
        }
    }
    public function branchOrderDetails(Order $order)
    {
        $customer = User::where('ID_User', $order->ID_User)->first();
        $branch = Branch::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $vehicles = DeliveryVehicle::where('ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->get();
        $schedules = DeliverySchedule::Join('delivery_vehicles', 'delivery_schedules.ID_DeliveryVehicle', '=', 'delivery_vehicles.ID_DeliveryVehicle')
            ->where('delivery_vehicles.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')
            ->where('delivery_schedules.ID_Order', 'like', '%' . $order->ID_Order . '%')
            ->get();
        $unit = Unit::where('ID_Unit', $order->ID_Unit)->first();
        $transactions = Transactions::where('ID_Order', $order->ID_Order)->get();
        $category = Category::where('ID_Category', $unit->ID_Category)->first();
        $banks = Bank::where('ID_Branch', $branch->ID_Branch)->get();
        $units = Unit::where('ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->where('unit_status', 'like', '%' . 0 . '%')->orderBy('unit_name', 'desc')->get();
        $categories = Category::all();
        return view('branch.handelOrder.orderDetails', [
            'order' => $order, 'unit' => $unit,
            'category' => $category, 'customer' => $customer, 'branch' => $branch,
            'schedules' => $schedules, 'vehicles' => $vehicles, 'transactions' => $transactions,
            'banks' => $banks, 'units' => $units, 'categories' => $categories
        ]);
    }
    public function extendOrder(Request $request, Order $order)
    {
        $request->validate([
            'expandPrice' => 'required',
            'extendEndsAt' => 'required',
        ]);
        $order->order_totalPrice += $request->get('expandPrice');
        $order->expandPrice += $request->get('expandPrice');
        $order->endsAt = $request->get('extendEndsAt');
        $transaction = new Transactions;
        $unit = Unit::where('ID_Unit', $order->ID_Unit)->first();
        $transaction->ID_Order = $order->ID_Order;
        $transaction->transactions_totalPrice = $request->get('expandPrice');
        $transaction->transactions_description = 'Extension Fees For Unit (' . $unit->unit_name . ')';
        if ($request->get('transaction') == 1) {
            if ($request->get('ID_Bank') == 0) {
                $message = 'Select Bank';
                return redirect()->back()->with('fail', $message);
            } else {
                $transaction->ID_Bank = $request->get('ID_Bank');
            }
            $transaction->transactions_status = 1;
            if ($request->file('proof')) {
                $image_name = $request->file('proof')->store('transactions_images', 'public');
                $transaction->proof = $image_name;
            } else {
                $message = 'Add Proof';
                return redirect()->back()->with('fail', $message);
            }
        } else {
            $transaction->transactions_status = 0;
            $transaction->proof = 'Waiting for Payment';
        }
        $transaction->save();
        $order->save();
        $message = 'Order has been extended successfuly';
        return redirect()->back()->with('success', $message);
    }
    public function changeOrderStatus(Request $request, Order $order)
    {
        $order->order_status = $request->get('status');
        $order->save();
        $message = 'Order status has been changed successfuly';
        return redirect()->back()->with('success', $message);
    }
    public function changeOrderDescription(Request $request, Order $order)
    {
        $request->validate([
            'order_description' => 'required',
        ]);
        $order->order_description = $request->get('order_description');
        $order->save();
        $message = 'Order description has been changed successfuly';
        return redirect()->back()->with('success', $message);
    }
    public function changeUnitCapacity(Request $request, Unit $unit)
    {
        $request->validate([
            'capacity' => 'required|integer|max:100'
        ]);
        $unit->capacity = $request->get('capacity');
        $unit->save();
        $message = 'Unit Capacity has been changed successfully';
        return redirect()->back()->with('success', $message);
    }
    public function changeOrderUnit(Request $request, Unit $unit, Order $order)
    {
        $transaction = new Transactions;
        $newUnit = Unit::where('ID_Unit', $request->get('new_ID_Unit'))->first();
        $transaction->ID_Order = $order->ID_Order;
        if ($request->get('change_status') == 0) {
            $message = 'Selected Unit Category is The Same';
            return redirect()->back()->with('success', $message);
        } else if ($request->get('change_status') == 1) {
            $transaction->transactions_totalPrice = $request->get('changePrice');
            $transaction->transactions_description = 'Change Unit Fees: Step Down To Unit (' . $newUnit->unit_name . ')';
        } else if ($request->get('change_status') == 2) {
            $transaction->transactions_totalPrice = $request->get('changePrice');
            $transaction->transactions_description = 'Change Unit Fees: Step Up To Unit (' . $newUnit->unit_name . ')';
            $order->order_totalPrice += $request->get('changePrice');
        } else {
            $message = 'There is Something Wrong!';
            return redirect()->back()->with('Fail', $message);
        }
        if ($request->get('transaction') == 1) {
            if ($request->get('ID_Bank') == 0) {
                $message = 'Select Bank';
                return redirect()->back()->with('fail', $message);
            } else {
                $transaction->ID_Bank = $request->get('ID_Bank');
            }
            $transaction->transactions_status = 1;
            if ($request->file('proof')) {
                $image_name = $request->file('proof')->store('transactions_images', 'public');
                $transaction->proof = $image_name;
            } else {
                $message = 'Add Proof';
                return redirect()->back()->with('fail', $message);
            }
        } else {
            $transaction->transactions_status = 0;
            $transaction->proof = 'Waiting for Payment';
        }
        $order->ID_Unit = $request->get('new_ID_Unit');
        $newUnit->capacity = $unit->capacity;
        $newUnit->unit_status = 1;
        $unit->capacity = 0;
        $unit->unit_status = 0;
        $newUnit->save();
        $unit->save();
        $transaction->save();
        $order->save();
        $message = 'Order has changed Unit successfuly';
        return redirect()->back()->with('success', $message);
    }

    //Banks & Transactions
    public function addBank(Request $request)
    {
        $branch = Branch::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $request->validate([
            'bank_name' => 'required',
            'accountNo' => 'required',
        ]);
        $bank = new Bank;
        $bank->ID_Branch = $branch->ID_Branch;
        $bank->bank_name = $request->get('bank_name');
        $bank->accountNo = $request->get('accountNo');
        $bank->save();
        $message = 'Bank ' . $request->get('bank_name') . ' has been added to you branch successfuly';
        return redirect()->back()->with('success', $message);
    }
    public function editBranchBank(Request $request, Bank $bank)
    {
        $request->validate([
            'bank_name' => 'required',
            'accountNo' => 'required',
        ]);
        $bank->bank_name = $request->get('bank_name');
        $bank->accountNo = $request->get('accountNo');
        $bank->save();
        $message = 'Bank ' . $request->get('bank_name') . ' has been edited successfuly';
        return redirect()->back()->with('success', $message);
    }
    public function deleteBank(Bank $bank = null)
    {
        $oldBnankName = $bank->bank_name;
        $bank->delete();
        $message = 'Bank ' . $oldBnankName . ' has been deleted from you branch successfuly';
        return redirect()->back()->with('success', $message);
    }
    public function branchTransactions(Request $request)
    {
        $branch = Branch::where('ID_User', 'like', '%' . Auth::user()->ID_User . '%')->first();
        $banks = Bank::where('ID_Branch', 'like', '%' . $branch->ID_Branch . '%')->get();
        $msg = 'All';
        if ($request->get('status') != null) {
            $transactions = Transactions::select('*')
                ->Join('orders', 'transactions.ID_Order', '=', 'orders.ID_Order')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->where('units.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')
                ->where('transactions.transactions_status', $request->get('status'))
                ->orderBy('transactions.created_at', 'desc')->get();

            if ($request->get('status') == 0) {
                $msg = 'Unpaid';
            } else if ($request->get('status') == 1) {
                $msg = 'Paid';
            } else if ($request->get('status') == 2) {
                $msg = 'Disapproved';
            } else if ($request->get('status') == 3) {
                $msg = 'Approved';
            }
        } else {
            $transactions = Transactions::select('*')
                ->Join('orders', 'transactions.ID_Order', '=', 'orders.ID_Order')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->where('units.ID_Branch', 'like', '%' . $branch->ID_Branch . '%')
                ->orderBy('transactions.created_at', 'desc')->get();
        }
        return view('branch.transactions', ['transactions' => $transactions, 'branch' => $branch, 'banks' => $banks, 'msg' => $msg]);
    }
}
