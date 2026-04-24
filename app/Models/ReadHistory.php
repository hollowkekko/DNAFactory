<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadHistory extends Model
{
    protected $table = 'read_history';

    protected $fillable = [
        'user_id',
        'manga_id',
        'last_chapter_read',
        'total_chapters',
        'progress_percentage',
        'read_date',
    ];

    protected $casts = [
        'read_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manga(): BelongsTo
    {
        return $this->belongsTo(Manga::class, 'manga_id', 'mal_id');
    }
}
