<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id')->nullable();
            $table->string('request_number')->nullable();
            $table->foreignId('cliente_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('conductor_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->string('status')->default('activa');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('sender_role')->default('cliente');
            $table->text('message')->nullable();
            $table->enum('type', ['text', 'image', 'file', 'location', 'system'])->default('text');
            $table->string('file')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
    }
};
