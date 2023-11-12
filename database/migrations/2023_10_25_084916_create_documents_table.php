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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users');
            $table->string('document_number');
            $table->string('document');
            $table->foreignId('jenis_id')->constraint('jenis');
            $table->string('file');
            $table->enum('status', ['belum_upload', 'sudah_upload', 'verifikasi_berkas', 'disposisi', 'selesai']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
