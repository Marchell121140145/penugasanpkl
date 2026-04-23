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
        // Alter the ENUM to include 'returned' and 'working' statuses
        DB::statement("ALTER TABLE task_submissions MODIFY COLUMN status ENUM('pending', 'submitted', 'graded', 'late', 'returned', 'working') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE task_submissions MODIFY COLUMN status ENUM('pending', 'submitted', 'graded', 'late') DEFAULT 'pending'");
    }
};
