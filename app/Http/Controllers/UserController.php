<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Category;
use App\Models\User;
use App\Models\Unit;
use App\Models\DeliverySchedule;
use App\Models\DeliveryVehicle;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    //user Main Page
    public function index()
    {
        $user = Auth::user();
        return view('user.home', ['user' => $user]);
    }
    
}
