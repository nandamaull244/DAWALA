<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('username')->nullable()->unique();
            $table->string('password');
            $table->string('full_name');
            $table->string('birth_date');
            $table->enum('gender', ['Laki-Laki', 'Perempuan']);
            $table->string('no_kk');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->integer('district_id')->nullable();
            $table->integer('village_id')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->text('address')->nullable();
            $table->enum('role', ['admin', 'operator', 'instantiation', 'user']); 
            $table->string('registration_type');
            $table->enum('registration_status', ['Process', 'Rejected', 'Completed']); 
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
        Schema::dropIfExists('users');
    }
};
