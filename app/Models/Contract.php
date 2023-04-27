<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'contracts';
    protected $guarded = ['id'];

    protected $fillable = [
        'code',
        'start_date',
        'end_date',
        'status',
        'amount_payment',
        'customer_id',
        'coupon_id',
        'membership_id',
    ];
    const STATUS_ACTIVE = 'Activo';
    const STATUS_FINALIZED = 'Finalizado';
    const STATUS_ANNULLED = 'Anulado';
}
