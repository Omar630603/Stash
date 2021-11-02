<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $table = 'banks';
    protected $primaryKey = 'ID_Bank';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'bank_name',
        'ID_Branch',
        'accountNo',
    ];
}
