<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Valoration extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'valorations';
    protected $guarded = ['id'];

    protected $fillable = [
        'value',
        'course_id',
        'customer_id'
    ];
}
