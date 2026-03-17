<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->bigIncrements('agent_id'); // Primary Key
            $table->unsignedBigInteger('user_id'); // Foreign Key
            
            // ✅ These are the columns you were missing:
            $table->string('id_number', 20)->unique()->nullable();
            $table->string('kra_pin', 20)->unique()->nullable();
            $table->string('company_name')->nullable();
            $table->string('business_reg_number')->nullable();
            $table->text('business_address')->nullable();
            $table->string('experience')->nullable();
            
            // Standard fields
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->string('id_document_url', 255)->nullable();
            $table->string('selfie_id_path', 500)->nullable();
            $table->string('license_number', 50)->nullable();
            $table->text('bio')->nullable();
            $table->decimal('rating_avg', 2, 1)->default(0.0);
            $table->timestamps();

            // Foreign Key Constraint (Assuming your users table uses 'user_id')
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};