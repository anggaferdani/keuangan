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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('end_user_id');
            $table->foreign('end_user_id')->references('id')->on('end_users')->onDelete('cascade');
            $table->string('nama_project')->nullable();
            $table->string('nomor_penawaran')->nullable();
            $table->string('jenis_pekerjaan')->nullable();
            $table->string('programming_language')->nullable();
            $table->date('project_entry_date')->nullable();
            $table->date('project_start_date')->nullable();
            $table->date('project_completion_date')->nullable();
            $table->string('paid')->nullable();
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
        Schema::dropIfExists('projects');
    }
};
