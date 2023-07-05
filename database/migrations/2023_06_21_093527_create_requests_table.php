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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('car_type');
            $table->string('matricule');
            $table->string('latitude');
            $table->string('longitude');
            $table->enum('request_type', ['EMERGENCY', 'PLANNED']);
            $table->date('date');
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')->onDelete('cascade');;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
