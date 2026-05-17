<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menghapus kolom lokasi dan checkout_lokasi dari tabel attendance_assignees
     * karena pencatatan lokasi tidak termasuk dalam kebutuhan fungsional sistem.
     */
    public function up(): void
    {
        Schema::table('attendance_assignees', function (Blueprint $table) {
            $table->dropColumn(['lokasi', 'checkout_lokasi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_assignees', function (Blueprint $table) {
            $table->string('lokasi')->nullable()->after('check_out_time');
            $table->string('checkout_lokasi')->nullable()->after('lokasi');
        });
    }
};
