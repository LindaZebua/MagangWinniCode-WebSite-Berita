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
            $table->string('slug')->nullable()->unique(); // Contoh: membuat kolom 'slug' dengan tipe string, boleh kosong (nullable), dan nilainya unik
            // Anda bisa menyesuaikan tipe data dan atribut lain sesuai kebutuhan Anda.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            //
        });
    }
};
