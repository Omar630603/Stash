<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'ID_Order';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'ID_User',
        'ID_Unit',
        'order_status',
        'startsFrom',
        'endsAt',
        'order_description',
        'order_deliveries',
        'order_totalPrice',
        'expandPrice',
        'madeBy',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'startsFrom' => 'datetime',
        'endsAt' => 'datetime',
    ];
}
