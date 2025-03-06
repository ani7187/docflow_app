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
        Schema::create('partner_organizations', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name');
            $table->string('organization_legal_type')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('company_code')->nullable();

            $table->boolean('delete_status')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();


            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_organizations');
    }
};
