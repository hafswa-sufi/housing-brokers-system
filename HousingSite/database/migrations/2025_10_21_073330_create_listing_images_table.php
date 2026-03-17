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
        Schema::create('listing_images', function (Blueprint $table) {
        $table->bigIncrements('image_id');
        $table->unsignedBigInteger('listing_id');
        $table->string('image_url', 255);
        $table->boolean('is_primary')->default(false);
        $table->timestamps();
        $table->foreign('listing_id')->references('listing_id')->on('listings')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_images');
    }
};
