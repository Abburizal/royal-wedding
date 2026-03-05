<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('category')->default('umum'); // keluarga, sahabat, kolega, umum
            $table->string('side')->default('both');     // groom, bride, both
            $table->unsignedSmallInteger('pax')->default(1); // jumlah tamu (1 undangan bisa bawa +1)
            $table->string('table_no', 20)->nullable();
            $table->enum('rsvp_status', ['pending', 'confirmed', 'declined', 'attended'])->default('pending');
            $table->string('invitation_token', 64)->unique()->nullable();
            $table->timestamp('rsvp_responded_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
