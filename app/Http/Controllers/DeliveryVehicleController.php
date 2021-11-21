<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\DeliveryVehicle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DeliveryVehicleController extends Controller
{
    public function index()
    {
        $vehicleDriver = DeliveryVehicle::where('users.ID_User', Auth::user()->ID_User)
            ->join('users', 'delivery_vehicles.ID_User', '=', 'users.ID_User')
            ->first();
        $branch = Branch::where('ID_Branch', $vehicleDriver->ID_Branch)->first();
        return view('driver.home', ['vehicleDriver' => $vehicleDriver, 'branch' => $branch]);
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
}
