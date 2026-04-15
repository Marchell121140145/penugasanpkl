<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'user_id',
        'pesan',
    ];

    /**
     * Submission tempat komentar ini diberikan
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(TaskSubmission::class, 'submission_id');
    }

    /**
     * User (Admin/Pelaksana) yang memberikan komentar
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
