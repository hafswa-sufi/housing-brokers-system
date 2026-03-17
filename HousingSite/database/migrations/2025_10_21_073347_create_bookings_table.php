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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
             $table->foreignId('tenant_id')->constrained('users', 'user_id')->onDelete('cascade');
        $table->foreignId('listing_id')->constrained('listings', 'listing_id')->onDelete('cascade');
        $table->enum('status', ['pending', 'accepted', 'rejected', 'completed', 'canceled'])->default('pending');
        $table->dateTime('scheduled_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
