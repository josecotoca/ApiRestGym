<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'customers';
    protected $guarded = ['id'];

    protected $fillable = [
        'code',
        'access_code',
        'people_id',
        'status'
    ];

    const STATUS_ACTIVE = 'Activo';
    const STATUS_INACTIVE = 'Inactivo';

    public function person(){
        return $this->belongsTo('App\Models\Person','people_id');
    }

}
