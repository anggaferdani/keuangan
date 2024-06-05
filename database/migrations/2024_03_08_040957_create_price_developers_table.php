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
        Schema::create('price_developers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('jobdesk')->nullable();
            $table->string('price_satuan')->nullable();
            $table->string('qty')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('discount_percent')->nullable();
            $table->string('discount_price')->nullable();
            $table->string('final_price')->nullable();
            $table->string('paid')->nullable();
            $table->string('remnant')->nullable();
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
        Schema::dropIfExists('price_developers');
    }
};
