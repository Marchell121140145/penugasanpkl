<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'jenis_tugas',
        'prioritas',
        'divisi_id',
        'deadline_date',
        'deadline_time',
        'catatan',
        'created_by',
        'status',
    ];

    protected $casts = [
        'deadline_date' => 'date',
    ];

    /**
     * Pembimbing/Admin yang membuat tugas
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Divisi tempat tugas ditugaskan
     */
    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }

    /**
     * File pendukung dari admin
     */
    public function files(): HasMany
    {
        return $this->hasMany(TaskFile::class);
    }

    /**
     * Mahasiswa yang ditugaskan ke task ini
     */
    public function assignees(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_assignees')->withTimestamps();
    }

    /**
     * Pengumpulan tugas dari mahasiswa
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(TaskSubmission::class);
    }
}
