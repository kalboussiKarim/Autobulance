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
        Schema::create('transaction_reparateurs', function (Blueprint $table) {
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('autobulance_id');
            $table->timestamp('affected_at');
            $table->timestamp('detached_at')->nullable()->default(null);
            $table->primary(['staff_id', 'autobulance_id', 'affected_at']);
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->foreign('autobulance_id')->references('id')->on('autobulances');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_reparateurs');
    }
};
