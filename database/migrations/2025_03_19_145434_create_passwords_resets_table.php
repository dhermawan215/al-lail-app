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
        Schema::create('passwords_resets', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('token');
            $table->timestamp('expired_at');
            $table->boolean('is_used')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passwords_resets');
    }
};
