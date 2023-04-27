<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'courses';
    protected $guarded = ['id'];

    protected $fillable = [
        'code',
        'name',
        'number_places',
        'start_hour',
        'end_hour',
        'start_date'
    ];
}
