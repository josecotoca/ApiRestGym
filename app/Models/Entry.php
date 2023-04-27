<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'entries';
    protected $guarded = ['id'];

    protected $fillable = [
        'date_input',
        'date_output',
        'customer_id'
    ];
}
