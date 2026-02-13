<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_type_id')->constrained()->onDelete('cascade');

            // Translatable fields (JSON for i18n)
            $table->json('title');
            $table->string('slug')->unique();
            $table->json('description');

            // Pricing
            $table->decimal('price', 12, 2);
            $table->string('currency', 3)->default('EUR');
            $table->enum('listing_type', ['sale', 'rent'])->default('sale');
            $table->enum('status', ['active', 'pending', 'sold', 'rented'])->default('active');

            // Location
            $table->string('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->default('Albania');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Property Details
            $table->unsignedTinyInteger('bedrooms')->default(0);
            $table->unsignedTinyInteger('bathrooms')->default(0);
            $table->decimal('area_sqm', 10, 2)->nullable();
            $table->decimal('lot_size_sqm', 10, 2)->nullable();
            $table->unsignedSmallInteger('year_built')->nullable();
            $table->unsignedTinyInteger('floors')->default(1);
            $table->unsignedTinyInteger('garage_spaces')->default(0);

            // Features & Amenities
            $table->json('features')->nullable();

            // Flags
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('views')->default(0);

            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['listing_type', 'status']);
            $table->index('city');
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
