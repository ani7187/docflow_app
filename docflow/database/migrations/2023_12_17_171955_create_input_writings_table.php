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
        Schema::create('input_writings', function (Blueprint $table) {
            $table->id();
            $table->string("unique_number");
            $table->string("external_unique_number");
            $table->string("title");
//            $table->string("type");//todo dictionary
            $table->unsignedBigInteger("type_id")->nullable();//todo dictionary
            $table->text("description");
            $table->dateTime('creation_date');
            $table->dateTime('deadline');
            $table->boolean('is_response')->default(0);
            $table->boolean('is_addition')->default(0);
            $table->softDeletes();
            $table->timestamps();

//            $table->index("type_id", );
            $table->foreign('type_id')->references('id')->on('input_writing_types')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_writings');
    }
};
