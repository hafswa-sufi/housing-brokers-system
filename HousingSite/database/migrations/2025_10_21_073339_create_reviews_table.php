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
        Schema::create('review', function (Blueprint $table) {
            $table->id();
             $table->foreignId('listing_id')->constrained('listings', 'listing_id')->onDelete('cascade');
        $table->foreignId('tenant_id')->constrained('users', 'user_id')->onDelete('cascade');
        $table->integer('rating');
        $table->text('comment')->nullable();
        $table->timestamp('created_atU')->useCurrent();
        $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};
