<?php

namespace App\Models;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_name',
        'user_id',
        'sales_value',
        'items_amount'
    ];
}
