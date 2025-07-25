<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggota_lamarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lamaran_id')->constrained()->onDelete('cascade');

            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->integer('umur');
            $table->string('nomor_telpon');
            $table->string('email');
            $table->string('cv')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_lamarans');
    }
};
