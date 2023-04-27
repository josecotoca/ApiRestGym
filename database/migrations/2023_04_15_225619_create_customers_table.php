<?php

use App\Models\Customer;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 25)->nullable();
            $table->unsignedBigInteger('people_id')->unique();
            $table->foreign('people_id')->references('id')->on('people');
            $table->string('access_code', 25);
            $table->enum('status', [Customer::STATUS_ACTIVE, Customer::STATUS_INACTIVE])->default(Customer::STATUS_ACTIVE);
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
        Schema::dropIfExists('customers');
    }
};
