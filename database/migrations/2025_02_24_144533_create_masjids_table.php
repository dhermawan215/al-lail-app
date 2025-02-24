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
        Schema::create('masjids', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('masjid_code')->unique();
            $table->string('slug', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('phone_masjid')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('verification_status')->default(0);
            $table->timestamp('registered_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masjids');
    }
};
