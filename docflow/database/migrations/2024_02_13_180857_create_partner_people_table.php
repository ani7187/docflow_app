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
        Schema::create('partner_people', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('patronymic_name')->nullable();
            $table->string('position')->nullable();

            $table->string('company_code')->nullable();

            $table->boolean('delete_status')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();


            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('partner_organizations_id');
            $table->foreign('partner_organizations_id')->references('id')->on('partner_organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_people');
    }
};
