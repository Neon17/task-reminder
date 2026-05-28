<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->foreignId('created_by')->constrained('users');
            $table->string("assigned_date"); //assigned date for completion
            // $table->string('status'); //pending, in progress, completed, told not required by Sanil sir
            $table->string('completed_date')->nullable();
            $table->string('notification_start_date');
            $table->string("notification_interval"); //in days
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
