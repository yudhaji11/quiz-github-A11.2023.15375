<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('periksa', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable()->after('biaya_periksa');
            $table->enum('status_pembayaran', ['belum_bayar', 'menunggu_verifikasi', 'lunas'])
                  ->default('belum_bayar')
                  ->after('bukti_pembayaran');
            $table->timestamp('tgl_bayar')->nullable()->after('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('periksa', function (Blueprint $table) {
            $table->dropColumn(['bukti_pembayaran', 'status_pembayaran', 'tgl_bayar']);
        });
    }
};