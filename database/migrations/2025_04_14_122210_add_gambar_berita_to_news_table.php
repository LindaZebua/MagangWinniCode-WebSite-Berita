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
        Schema::table('news', function (Blueprint $table) {
            $table->string('gambar_berita')->nullable(); // Menambahkan kolom gambar_berita (boleh null)
            // Anda bisa menambahkan opsi lain seperti ->default('nama_default.jpg') jika perlu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('gambar_berita'); // Menghapus kolom gambar_berita jika migration di-rollback
        });
    }
};