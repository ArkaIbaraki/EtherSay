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
        Schema::create('online_users', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('username');
            $table->timestamp('last_seen');
            $table->timestamps();
            
            $table->index('last_seen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_users');
    }
};
