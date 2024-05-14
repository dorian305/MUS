<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "user_id",
        "type",
        "size",
        "path",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
