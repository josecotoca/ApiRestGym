<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            "code" => "CUP-1",
            "number_of_uses" => 1,
            "start_date" => "2023-01-01",
            "end_date" => "2023-05-01",
            "type" => Coupon::COUPON_TYPE_PROMO,
        ]);
    }
}
