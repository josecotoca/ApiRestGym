<?php

use App\Models\Person;
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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('code', 25)->nullable();
            $table->string('dni', 25)->unique();
            $table->string('iban', 28)->nullable();
            $table->enum('gender', [Person::GENDER_MALE, Person::GENDER_FEMALE])->default(Person::GENDER_MALE);
            $table->string('name', 75);
            $table->string('last_name', 100)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('address', 250)->nullable();
            $table->string('country', 50)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('image', 250)->default(Person::NO_IMAGE);
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
        Schema::dropIfExists('people');
    }
};
