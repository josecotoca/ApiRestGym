<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'receipts';
    protected $guarded = ['id'];

    protected $fillable = [
        'code',
        'date',
        'description',
        'amount',
        'contract_id'
    ];
}
