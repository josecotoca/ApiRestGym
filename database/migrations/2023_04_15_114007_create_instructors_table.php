<?php

use App\Models\Instructor;
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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('code', 25)->nullable();
            $table->enum('speciality', [Instructor::SPECIALITY_PERSONAL, Instructor::SPECIALITY_BODYATACK,Instructor::SPECIALITY_BODYPUMP,Instructor::SPECIALITY_BODYJUMP,Instructor::SPECIALITY_ZUMBA])->default(Instructor::SPECIALITY_PERSONAL);
            $table->unsignedBigInteger('people_id');
            $table->foreign('people_id')->references('id')->on('people');
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
        Schema::dropIfExists('instructors');
    }
};
