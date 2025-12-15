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
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id');
            $table->string('title');
            $table->string('body');
            $table->string('creator');
            $table->dateTime('create_date');
            $table->boolean('is_document_admin_signed')->default(false);
            $table->boolean('is_document_manager_signed')->default(false);
            $table->boolean('is_boss_signed')->default(false);
            $table->string('response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
