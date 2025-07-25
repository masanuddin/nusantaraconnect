<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lamarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pekerjaan_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');

            // Data PIC (penanggung jawab)
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->integer('umur');
            $table->string('nomor_telpon');
            $table->string('email');
            $table->string('cv')->nullable();

            // Step 2: Data tambahan
            $table->string('pengalaman_kerja');
            $table->text('keterangan_tambahan')->nullable();
            $table->string('video')->nullable();
            $table->enum('status', ['pending', 'on_review', 'accepted'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lamarans');
    }
};
