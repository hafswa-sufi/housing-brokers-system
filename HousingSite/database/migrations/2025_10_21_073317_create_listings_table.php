<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->bigIncrements('listing_id');

            // Foreign key to agents table
            $table->unsignedBigInteger('agent_id');
            $table->foreign('agent_id')->references('agent_id')->on('agents')->onDelete('cascade');

            $table->string('title', 150);
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('location', 150);

            // new fields
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('property_type', 100)->nullable(); // apartment, bungalow, bedsitter etc.
            $table->integer('size')->nullable();              // in sq ft/m²
            $table->boolean('garage')->default(false);        // true or false

            $table->enum('status', ['available', 'rented', 'removed', 'flagged'])
                ->default('available');

            $table->enum('verification_status', ['pending', 'verified', 'rejected'])
                ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
