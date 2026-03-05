<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();   // reviewer (client)
            $table->foreignId('wedding_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('rating');          // 1–5
            $table->string('title', 150)->nullable();
            $table->text('review');
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->unique(['vendor_id', 'user_id']); // one review per client per vendor
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_reviews');
    }
};
