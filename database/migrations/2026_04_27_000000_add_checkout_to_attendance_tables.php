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
        // Add checkout_start to attendances table
        Schema::table('attendances', function (Blueprint $table) {
            $table->dateTime('checkout_start')->nullable()->after('deadline');
        });

        // Add checkout fields to attendance_assignees table
        Schema::table('attendance_assignees', function (Blueprint $table) {
            $table->dateTime('check_out_time')->nullable()->after('check_in_time');
            $table->string('checkout_photo_path')->nullable()->after('photo_path');
            $table->string('checkout_lokasi')->nullable()->after('lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('checkout_start');
        });

        Schema::table('attendance_assignees', function (Blueprint $table) {
            $table->dropColumn(['check_out_time', 'checkout_photo_path', 'checkout_lokasi']);
        });
    }
};
