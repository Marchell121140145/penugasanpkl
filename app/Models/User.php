<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'role_id',
        'divisi_id',
        'pembimbing_id',
        'pkl_start',
        'pkl_end',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'pkl_start' => 'date',
            'pkl_end' => 'date',
        ];
    }

    /**
     * Get the role that owns the user.
     */
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Divisi tempat user ini ditempatkan.
     */
    public function divisi(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }

    /**
     * Pembimbing dari user pelaksana ini.
     */
    public function pembimbing(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'pembimbing_id');
    }

    /**
     * Pelaksana yang dibimbing oleh user pembimbing ini.
     */
    public function bimbingan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'pembimbing_id');
    }

    /**
     * Tugas yang dibuat oleh user ini (sebagai pembimbing/admin)
     */
    public function createdTasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     * Tugas yang ditugaskan ke user ini (sebagai pelaksana/mahasiswa)
     */
    public function assignedTasks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_assignees')->withTimestamps();
    }

    /**
     * Pengumpulan tugas oleh user ini (sebagai mahasiswa)
     */
    public function submissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TaskSubmission::class);
    }

    /**
     * Absensi yang dibuat oleh user ini (sebagai admin/pembimbing)
     */
    public function createdAttendances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attendance::class, 'created_by');
    }

    /**
     * Absensi yang ditugaskan ke user ini (sebagai pelaksana)
     */
    public function assignedAttendances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AttendanceAssignee::class, 'user_id');
    }
}
