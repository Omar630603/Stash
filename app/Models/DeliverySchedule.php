<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySchedule extends Model
{
    use HasFactory;
    protected $table = 'delivery_schedules';
    protected $primaryKey = 'ID_DeliverySchedule';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'ID_Order',
        'ID_DeliveryVehicle',
        'status',
        'pickedUp',
        'delivered',
        'pickedUpFrom',
        'deliveredTo',
        'totalPrice',
    ];
}
