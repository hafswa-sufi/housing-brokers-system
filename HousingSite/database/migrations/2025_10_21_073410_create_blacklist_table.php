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
    Schema::create('blacklists', function (Blueprint $table) {

        $table->bigIncrements('blacklist_id'); // defines PK + auto increment
        $table->unsignedBigInteger('agent_id');
        $table->text('reason');
        $table->timestamp('created_at')->useCurrent();

        $table->foreign('agent_id')
              ->references('agent_id')
              ->on('agents')
              ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blacklist');
    }
};
