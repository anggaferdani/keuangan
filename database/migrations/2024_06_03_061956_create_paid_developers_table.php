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
        Schema::create('paid_developers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('price_developer_id');
            $table->foreign('price_developer_id')->references('id')->on('price_developers')->onDelete('cascade');
            $table->string('keterangan')->nullable();
            $table->string('tanggal_pembayaran')->nullable();
            $table->string('nominal_pembayaran')->nullable();
            $table->unsignedBigInteger('file_id')->nullable();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->integer('status')->default(1);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paid_developers');
    }
};
