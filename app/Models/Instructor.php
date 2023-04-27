<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'instructors';
    protected $guarded = ['id'];

    protected $fillable = [
        'code',
        'speciality',
        'people_id'
    ];

    const SPECIALITY_PERSONAL = 'Instructor personal';
    const SPECIALITY_ZUMBA = 'Zumba';
    const SPECIALITY_BODYATACK = 'Body Atack';
    const SPECIALITY_BODYPUMP = 'Body Pump';
    const SPECIALITY_BODYJUMP = 'Body Jump';

    public function person(){
        return $this->belongsTo('App\Models\Person','people_id');
    }

}
