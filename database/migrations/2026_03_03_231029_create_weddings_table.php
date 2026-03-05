<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('planner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('package_id')->constrained()->restrictOnDelete();
            $table->string('groom_name');
            $table->string('bride_name');
            $table->date('wedding_date');
            $table->time('wedding_time')->nullable();
            $table->string('venue_name')->nullable();
            $table->text('venue_address')->nullable();
            $table->string('venue_city')->nullable();
            $table->integer('estimated_guests')->default(0);
            $table->enum('status', ['inquired','confirmed','in_progress','completed','cancelled'])->default('inquired');
            $table->decimal('total_price', 15, 2)->default(0);
            $table->text('special_notes')->nullable();
            $table->timestamps();

            $table->index(['client_id', 'status']);
            $table->index('wedding_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weddings');
    }
};
