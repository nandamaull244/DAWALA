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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('service_list_id')->constrained('service_list')->onUpdate('cascade')->onDelete('cascade');
            $table->string('reason')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('service_type');
            $table->string('service_category');
            $table->enum('service_status', ['Process', 'Rejected', 'Completed'])->default('Process'); 
            $table->enum('working_status', ['Process', 'Late', 'Done'])->default('Process'); 
            $table->timestamps();
            $table->string('deleted_reason')->nullable();
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
        Schema::dropIfExists('services');
    }
};
