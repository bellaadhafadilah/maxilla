<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE reservasis MODIFY COLUMN status ENUM('Menunggu','Hadir','Menunggu Antrian','Diperiksa','Menunggu Obat','Menunggu Pembayaran','Selesai','Dibatalkan','Kadaluarsa') DEFAULT 'Menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE reservasis MODIFY COLUMN status ENUM('Menunggu','Hadir','Menunggu Antrian','Diperiksa','Menunggu Obat','Menunggu Pembayaran','Selesai','Dibatalkan') DEFAULT 'Menunggu'");
    }
};
