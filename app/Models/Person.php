<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'people';
    protected $guarded = ['id'];

    protected $fillable = [
        'code',
        'dni',
        'iban',
        'gender',
        'name',
        'last_name',
        'phone',
        'address',
        'country',
        'birth_date',
        'image'
    ];

    const GENDER_MALE = 'masculino';
    const GENDER_FEMALE = 'femenino';
    const NO_IMAGE = 'no_image.png';
}
