<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('city');
            $table->string('department')->default('Putumayo');
            $table->string('vehicle_type');
            $table->string('vehicle_brand')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_year')->nullable();
            $table->string('plate_mask')->nullable();
            $table->unsignedInteger('capacity_kg');
            $table->decimal('rating', 3, 1)->default(5);
            $table->unsignedInteger('trips')->default(0);
            $table->unsignedInteger('cancelled_trips')->default(0);
            $table->unsignedInteger('completed_percent')->default(100);
            $table->unsignedInteger('response_minutes')->default(5);
            $table->decimal('distance_km', 8, 1)->default(0);
            $table->unsignedInteger('base_price')->default(0);
            $table->unsignedInteger('price_per_km')->default(0);
            $table->string('availability')->default('Disponible ahora');
            $table->boolean('verified_identity')->default(true);
            $table->boolean('verified_license')->default(true);
            $table->boolean('verified_vehicle')->default(true);
            $table->boolean('soat_active')->default(true);
            $table->boolean('technical_review_active')->default(true);
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });

        Schema::create('driver_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'driver_id']);
        });

        Schema::create('driver_service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained()->cascadeOnDelete();
            $table->string('request_number');
            $table->string('origin');
            $table->string('destination');
            $table->unsignedInteger('weight_kg');
            $table->string('vehicle_type');
            $table->unsignedInteger('offered_price');
            $table->enum('status', ['enviada', 'aceptada', 'rechazada', 'cancelada'])->default('enviada');
            $table->text('message')->nullable();
            $table->timestamps();
        });

        Schema::create('driver_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained()->cascadeOnDelete();
            $table->string('reason');
            $table->text('description')->nullable();
            $table->enum('status', ['pendiente', 'en_revision', 'resuelto'])->default('pendiente');
            $table->timestamps();
        });

        Schema::create('driver_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained()->cascadeOnDelete();
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_messages');
        Schema::dropIfExists('driver_reports');
        Schema::dropIfExists('driver_service_requests');
        Schema::dropIfExists('driver_favorites');
        Schema::dropIfExists('drivers');
    }
};
