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
        return redirect()->route('welcome.home')->with('success', $message);
    }
}
