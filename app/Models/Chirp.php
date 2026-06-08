<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Reply;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chirp extends Model
{
    protected $fillable = [
        'message'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class)->latest();
    }
}
