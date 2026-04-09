<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskFile extends Model
{
    protected $fillable = [
        'task_id',
        'jenis',
        'nama_file',
        'path',
        'ukuran',
        'tipe',
        'url',
    ];

    /**
     * Tugas yang memiliki file ini
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
