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
        Schema::create('section_additional_columns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->boolean('number')->default(false);
            $table->boolean('name')->default(true);
            $table->boolean('notes')->default(false);
            $table->boolean('uploaded_by')->default(false);
            $table->boolean('created_by')->default(false);
            $table->boolean('signed_by')->default(false);
            $table->boolean('creation_date')->default(true);
            $table->boolean('due_date')->default(false);

//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_additional_columns');
    }
};
