<?php

use App\Models\Contract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 25)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', [Contract::STATUS_ACTIVE, Contract::STATUS_FINALIZED, Contract::STATUS_ANNULLED])->default(Contract::STATUS_ACTIVE);
            $table->decimal('amount_payment');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->unsignedBigInteger('membership_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->foreign('membership_id')->references('id')->on('memberships');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
};
