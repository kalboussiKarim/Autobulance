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
        Schema::create('breakdown_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('breakdown_id');
            $table->foreign('breakdown_id')->references('id')->on('breakdowns')->onDelete('cascade'); //ondelte ya kerimos
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade'); //same 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breakdown_requests');
    }
};
