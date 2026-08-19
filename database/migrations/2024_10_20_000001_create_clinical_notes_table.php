<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clinical_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counselor_id');
            $table->string('patient_name');
            $table->date('patient_birthdate');
            $table->text('diagnosis');
            $table->text('treatment');
            $table->string('counselor_name');
            $table->string('counselor_license');
            $table->date('date');
            $table->timestamps();

            $table->foreign('counselor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_notes');
    }
};
