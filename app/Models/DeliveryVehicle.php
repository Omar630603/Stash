<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryVehicle extends Model
{
    use HasFactory;
    protected $table = 'delivery_vehicles';
    protected $primaryKey = 'ID_DeliveryVehicle';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'ID_Admin',
        'vehicle_name',
        'vehicle_phone',
        'model',
        'plateNumber',
        'vehicle_img',
        'pricePerK',
        'vehicle_deliveries',
    ];
}
