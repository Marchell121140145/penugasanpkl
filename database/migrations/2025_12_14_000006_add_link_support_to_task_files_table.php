<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom untuk mendukung link pendukung selain file upload.
     */
    public function up(): void
    {
        Schema::table('task_files', function (Blueprint $table) {
            $table->enum('jenis', ['file', 'link'])->default('file')->after('task_id');
            $table->string('url')->nullable()->after('tipe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_files', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'url']);
        });
    }
};
