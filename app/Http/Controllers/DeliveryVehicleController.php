<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\DeliverySchedule;
use App\Models\DeliveryVehicle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DeliveryVehicleController extends Controller
{
    public function index(Request $request)
    {
        $vehicleDriver = DeliveryVehicle::where('users.ID_User', Auth::user()->ID_User)
            ->join('users', 'delivery_vehicles.ID_User', '=', 'users.ID_User')
            ->first();
        $branch = Branch::where('ID_Branch', $vehicleDriver->ID_Branch)->first();
        if ($request->get('status') != null) {
            $schedules = DeliverySchedule::select('*')
                ->Join('orders', 'delivery_schedules.ID_Order', '=', 'orders.ID_Order')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->where('delivery_schedules.ID_DeliveryVehicle', $vehicleDriver->ID_DeliveryVehicle)
                ->where('delivery_schedules.schedule_status', $request->get('status'))
                ->orderBy('delivery_schedules.created_at', 'desc')->get();
            if ($request->get('status') == 0) {
                $type = 'Waiting';
            } else if ($request->get('status') == 1) {
                $type = 'On-Going';
            } else if ($request->get('status') == 2) {
                $type = 'Done';
            } else if ($request->get('status') == 3) {
                $schedules = DeliverySchedule::select('*')
                    ->Join('orders', 'delivery_schedules.ID_Order', '=', 'orders.ID_Order')
                    ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                    ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                    ->where('delivery_schedules.ID_DeliveryVehicle', $vehicleDriver->ID_DeliveryVehicle)
                    ->whereDate('delivery_schedules.pickedUp', Carbon::today())
                    ->orderBy('delivery_schedules.created_at', 'desc')->get();
                $type = 'Today';
            }
        } else {
            $schedules = DeliverySchedule::select('*')
                ->Join('orders', 'delivery_schedules.ID_Order', '=', 'orders.ID_Order')
                ->Join('users', 'orders.ID_User', '=', 'users.ID_User')
                ->Join('units', 'orders.ID_Unit', '=', 'units.ID_Unit')
                ->where('delivery_schedules.ID_DeliveryVehicle', $vehicleDriver->ID_DeliveryVehicle)
                ->orderBy('delivery_schedules.created_at', 'desc')->get();
            $type = 'All';
        }
        return view('driver.home', [
            'vehicleDriver' => $vehicleDriver,
            'branch' => $branch,
            'schedules' => $schedules,
            'type' => $type
        ]);
    }
    public function editDriver(Request $request, DeliveryVehicle $driver)
    {
        $user = User::where('ID_User', $driver->ID_User)->first();
        $request->validate([
            'name' => 'required',
            'model' => 'required',
            'plateNumber' => 'required',
            'phone' => 'required',
            'pricePerK' => 'required',
            'address' => 'required',
            'email' => 'required'
        ]);
        $user->name = $request->get('name');
        $user->username = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('plateNumber'));
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');
        $driver->vehicle_name = $request->get('name');
        $driver->model = $request->get('model');
        $driver->plateNumber = $request->get('plateNumber');
        $driver->vehicle_phone = $request->get('phone');
        $driver->pricePerK = $request->get('pricePerK');
        $user->save();
        $driver->save();
        $message = 'Driver Data Has been Edited';
        return redirect()->back()->with('success', $message);
    }
    public function editDriverImage(Request $request, DeliveryVehicle $driver)
    {
        $user = User::where('ID_User', $driver->ID_User)->first();
        if ($driver->vehicle_img == "DeliveryVehicle_images/deliveryVehicleDefault.png") {
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('DeliveryVehicle_images', 'public');
            }
            $driver->vehicle_img = $image_name;
            $user->user_img = $image_name;
        } else {
            Storage::delete('public/' . $driver->vehicle_img);
            if ($request->file('image')) {
                $image_name = $request->file('image')->store('DeliveryVehicle_images', 'public');
            }
            $driver->vehicle_img = $image_name;
            $user->user_img = $image_name;
        }
        $driver->save();
        $user->save();
        $message = 'Driver Image Has been Changed';
        return redirect()->back()->with('success', $message);
    }
    public function editDriverImageDefult(DeliveryVehicle $driver)
    {
        $user = User::where('ID_User', $driver->ID_User)->first();
        if ($driver->vehicle_img == "DeliveryVehicle_images/deliveryVehicleDefault.png") {
            $driver->vehicle_img = 'DeliveryVehicle_images/deliveryVehicleDefault.png';
            $user->user_img = 'DeliveryVehicle_images/deliveryVehicleDefault.png';
        } else {
            Storage::delete('public/' . $driver->vehicle_img);
            $driver->vehicle_img = 'DeliveryVehicle_images/deliveryVehicleDefault.png';
            $user->user_img = 'DeliveryVehicle_images/deliveryVehicleDefault.png';
        }
        $user->save();
        $driver->save();
        $message = 'Driver Image Has been Restored';
        return redirect()->back()->with('success', $message);
    }
    public function deleteDriver(DeliveryVehicle $driver)
    {
        if ($driver->vehicle_img != "DeliveryVehicle_images/deliveryVehicleDefault.png") {
            Storage::delete('public/' . $driver->vehicle_img);
        }
        $user = User::where('ID_User', $driver->ID_User)->first();
        $user->delete();
        $driver->delete();
        return redirect()->route('branch.delivery');
    }
    public function changeStatus(DeliverySchedule $schedule, Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);
        $schedule->schedule_status = $request->get('status');
        $schedule->save();
        $message = 'Status has Changed';
        return redirect()->back()->with('success', $message);
    }
}
