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
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->string('number')->nullable();
            $table->string('name')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('uploaded_by');
            $table->date('creation_date');
            $table->date('due_date');
            $table->string('unique_id')->unique();
            $table->string('document_signature_status');
            $table->string('document_execution_status');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
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
