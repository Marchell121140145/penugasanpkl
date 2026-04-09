<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Divisi extends Model
{
    protected $table = 'divisi';

    protected $fillable = [
        'nama',
    ];

    /**
     * Tugas-tugas yang ada di divisi ini
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
