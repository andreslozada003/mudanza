<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->unique()->after('email');
        });

        Schema::create('user_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('document_type', 30);
            $table->string('document_number')->unique();
            $table->date('document_issued_at');
            $table->date('birth_date');
            $table->string('gender', 30);
            $table->string('city');
            $table->string('address');
            $table->string('document_front_path');
            $table->string('document_back_path');
            $table->string('selfie_path');
            $table->enum('status', ['pendiente', 'en_revision', 'aprobado', 'rechazado', 'suspendido'])->default('en_revision');
            $table->text('observations')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_verifications');

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['phone']);
            $table->dropColumn('phone');
        });
    }
};
