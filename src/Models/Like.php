<?php

namespace stevecreekmore\LaravelLike\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = [
        'user_id',
        'liking_id',
    ];

    public function liking(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'liking_id');
    }

    public function likers(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }
}
