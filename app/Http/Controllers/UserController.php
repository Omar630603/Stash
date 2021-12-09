<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\User;
use App\Models\Category;
use App\Models\DeliverySchedule;
use App\Models\DeliveryVehicle;
use App\Models\Order;
use App\Models\Transactions;
use App\Models\Unit;
use DateTime;
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
    public function chooseCity(Request $request)
    {
        $cities = Branch::select('city')->groupby('city')->get();
        $unit = Category::where('ID_Category', $request->get('unit'))->first();
        return view('user.makeOrder.chooseCity', ['cities' => $cities, 'unit' => $unit]);
    }
    public function chooseLocation(Request $request)
    {
        if (!$request->get('city')) {
            $message = 'Choose A City';
            return redirect()->back()->with('fail', $message);
        } else {
            $city = $request->get('city');
            $locations =  Branch::where('city', $request->get('city'))->get();
            $unit = Category::where('ID_Category', $request->get('unit'))->first();
            return view('user.makeOrder.chooseLocation', [
                'locations' => $locations, 'unit' => $unit, 'city' => $city
            ]);
        }
    }
    public function showUnits(Request $request)
    {
        if (!$request->get('branch')) {
            $message = 'Choose A Location';
            return redirect()->back()->with('fail', $message);
        } else {
            $branch = Branch::where('ID_Branch', $request->get('branch'))->first();
            $unit = Category::where('ID_Category', $request->get('unit'))->first();
            $availableInBranch = in_array(
                $unit->ID_Category,
                Unit::where('ID_Branch', $request->get('branch'))
                    ->where('unit_status', 0)->groupBy('ID_Category')->pluck('ID_Category')->all()
            );
            $unitsAvaliable = Unit::where('ID_Branch', 'like', '%' . $request->get('branch') . '%')
                ->where('unit_status', 'like', '%' . 0 . '%')->orderBy('unit_name', 'desc')->get();
            $categories = Category::all();
            return view('user.makeOrder.showUnits', [
                'unitsAvaliable' => $unitsAvaliable,
                'unit' => $unit, 'categories' => $categories,
                'branch' => $branch, 'availableInBranch' => $availableInBranch
            ]);
        }
    }
    public function makeOrderDetails(Request $request)
    {
        if (!$request->get('Idunit')) {
            $message = 'Choose A Unit Category';
            return redirect()->back()->with('fail', $message);
        } else {
            $unit = Unit::where('ID_Unit', $request->get('Idunit'))->first();
            $category = Category::where('ID_Category', $unit->ID_Category)->first();
            $branch = Branch::where('ID_Branch', $unit->ID_Branch)->first();
            $vehicles = DeliveryVehicle::where('ID_Branch', $unit->ID_Branch)->get();
            $banks = Bank::where('ID_Branch', $unit->ID_Branch)->get();
            return view('user.makeOrder.orderDetails', [
                'category' => $category,
                'unit' => $unit,
                'branch' => $branch,
                'vehicles' => $vehicles,
                'banks' => $banks
            ]);
        }
    }
    public function addOrder(Request $request)
    {
        $order = new Order;
        $request->validate([
            'transaction' => 'required',
            'delivery' => 'required',
            'order_status' => 'required',
            'Idunit' => 'required',
            'startsFrom' => 'required',
            'endsAt' => 'required',
        ]);
        $ID_User =  $request->get('ID_User');
        $order->ID_User = $ID_User;
        $order->ID_Unit = $request->get('Idunit');
        $order->startsFrom = $request->get('startsFrom');
        $order->endsAt = $request->get('endsAt');
        $order->madeBy = 0;
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
        if ($request->get('transaction') == 1) {
            if ($request->get('ID_Bank') == 0) {
                $message = 'Select Bank';
                return redirect()->back()->with('fail', $message);
            }
            if (!$request->file('proof')) {
                $message = 'Add Proof';
                return redirect()->back()->with('fail', $message);
            }
        }
        if ($request->get('delivery') == 1) {
            if (!$request->get('ID_DeliveryVehicle')) {
                $message = 'Add Vehicle';
                return redirect()->back()->with('fail', $message);
            }
            if (!$request->get('pickedUpFrom') || !$request->get('deliveredTo')) {
                $message = 'Add Trip Detials Place';
                return redirect()->back()->with('fail', $message);
            }
            if (!$request->get('pickedUp') || !$request->get('delivered')) {
                $message = 'Add Trip Date Detials Date';
                return redirect()->back()->with('fail', $message);
            }
            if (!$request->get('totalPrice')) {
                $message = 'Add Price';
                return redirect()->back()->with('fail', $message);
            }
        }
        $order->save();
        $unit->save();
        $userOrder = User::where('ID_User', $ID_User)->first();
        $userOrder->ordered++;
        $userOrder->save();
        $transaction = new Transactions;
        $transaction->ID_Order = $order->ID_Order;
        $transaction->transactions_description = 'Entry Transaction For Unit (' . $unit->unit_name . ')';
        $transaction->transactions_totalPrice = $order->order_totalPrice;
        $transaction->transaction_madeBy = 0;
        if ($request->get('transaction') == 1) {
            $transaction->ID_Bank = $request->get('ID_Bank');
            $transaction->transactions_status = 1;
            $image_name = $request->file('proof')->store('transactions_images', 'public');
            $transaction->proof = $image_name;
            $transaction->save();
        } else if ($request->get('transaction') == 2) {
            $transaction->transactions_status = 0;
            $transaction->proof = 'Waiting for Payment';
            $transaction->save();
        }
        if ($request->get('delivery') == 1) {
            $schedule = new DeliverySchedule;
            $schedule->ID_Order = $order->ID_Order;
            $schedule->ID_DeliveryVehicle = $request->get('ID_DeliveryVehicle');
            $schedule->schedule_status = $request->get('status');
            $schedule->schedule_description = $request->get('description_type') . ': ' . $request->get('description_note');
            $schedule->pickedUpFrom = $request->get('pickedUpFrom');
            $schedule->deliveredTo = $request->get('deliveredTo');
            $schedule->pickedUp = $request->get('pickedUp');
            $schedule->delivered = $request->get('delivered');
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
        }
        $message = 'Order has been made successfuly';
        $branch = Branch::where('ID_Branch', $unit->ID_Branch)->first();
        return view('user.makeOrder.successOrder', [
            'unit' => $unit, 'order' => $order,
            'branch' => $branch
        ])->with('success', $message);
    }
    public function orders()
    {
        $orders = Order::select('*')
            ->join('units', 'units.ID_Unit', '=', 'orders.ID_Unit')
            ->join('branches', 'units.ID_Branch', '=', 'branches.ID_Branch')
            ->join('categories', 'units.ID_Category', '=', 'categories.ID_Category')
            ->where('orders.ID_User', Auth::user()->ID_User)
            ->orderBy('orders.created_at', 'desc')->get();
        return view('user.orders', ['orders' => $orders]);
    }
    public function viewOrderDetails($order)
    {
        $order = Order::where('ID_order', $order)->first();
        if (Auth::user()->ID_User == $order->ID_User) {
            $unit = Unit::where('ID_Unit', $order->ID_Unit)
                ->join('categories', 'categories.ID_Category', '=', 'units.ID_Category')->first();
            $branch = Branch::where('ID_Branch', $unit->ID_Branch)
                ->join('users', 'users.ID_User', '=', 'branches.ID_User')->first();
            $schedules = DeliverySchedule::Join('delivery_vehicles', 'delivery_schedules.ID_DeliveryVehicle', '=', 'delivery_vehicles.ID_DeliveryVehicle')
                ->where('delivery_vehicles.ID_Branch', $branch->ID_Branch)
                ->where('delivery_schedules.ID_Order', $order->ID_Order)
                ->orderBy('delivery_schedules.created_at', 'desc')->get();
            $transactions = Transactions::where('ID_Order', $order->ID_Order)
                ->orderBy('transactions.created_at', 'desc')->get();
            $banks = Bank::where('ID_Branch', $branch->ID_Branch)->get();
            $vehicles = DeliveryVehicle::where('ID_Branch', $unit->ID_Branch)->get();

            return view('user.orderDetails', [
                'order' => $order,
                'unit' => $unit,
                'branch' => $branch,
                'schedules' => $schedules,
                'transactions' => $transactions,
                'banks' => $banks,
                'vehicles' => $vehicles,
            ]);
        } else {
            return redirect()->route('user.orders');
        }
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
        $transaction->transaction_madeBy = 0;
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
        $branchAccess = new BranchController;
        $branchAccess->changePrivateKeyUnit($unit);
        $order->delete();
        $message = 'Order Has been Deleted';
        return redirect()->route('user.orders')->with('success', $message);
    }
    public function addSchedule(Request $request)
    {
        $request->validate([
            'pickedUpFrom' => 'required',
            'deliveredTo' => 'required',
            'ID_DeliveryVehicle' => 'required',
            'description_type' => 'required',
            'pickedUp' => 'required',
            'delivered' => 'required',
        ]);
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
        $transaction->transaction_madeBy = 0;
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
}
