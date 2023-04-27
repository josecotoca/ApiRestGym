<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'memberships';
    protected $guarded = ['id'];

    protected $fillable = [
        'code',
        'type',
        'price',
        'duration',
        'contract_id'
    ];

    const MEMBERSHIP_TYPE_MONTH = 'Mensual';
    const MEMBERSHIP_TYPE_SEMI = 'Semestral';
    const MEMBERSHIP_TYPE_YEAR = 'Anual';
}
