<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskSubmission extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'file_nama',
        'file_path',
        'file_ukuran',
        'status',
        'nilai',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    /**
     * Tugas yang dikumpulkan
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Mahasiswa yang mengumpulkan
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
