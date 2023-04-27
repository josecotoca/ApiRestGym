<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'coupons';
    protected $guarded = ['id'];

    protected $fillable = [
        'code',
        'type',
        'number_of_uses',
        'start_date',
        'end_date'
    ];

    const COUPON_TYPE_PROMO = 'Promocional';
    const COUPON_TYPE_DISCOUNT = 'Descuento';
}
