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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
             $table->foreignId('reported_by')->constrained('users', 'user_id')->onDelete('cascade');
        $table->foreignId('listing_id')->constrained('listings', 'listing_id')->onDelete('cascade');
        $table->text('reason');
        $table->enum('status', ['pending', 'reviewed', 'resolved'])->default('pending');
        $table->timestamp('created_atU')->useCurrent();
        $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
