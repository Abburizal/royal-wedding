<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['catering', 'decoration', 'mua', 'documentation', 'entertainment', 'venue', 'other']);
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->text('description')->nullable();
            $table->decimal('base_price', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
