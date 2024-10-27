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
            $table->enum('service_status', ['Not Yet', 'Process', 'Rejected', 'Completed'])->default('Not Yet'); 
            $table->enum('working_status', ['Not Yet', 'Process', 'Late', 'Done'])->default('Not Yet'); 
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
