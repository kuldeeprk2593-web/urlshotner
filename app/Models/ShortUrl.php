<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ShortUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'original_url',
        'user_id',
        'company_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (ShortUrl $shortUrl) {
            if (empty($shortUrl->code)) {
                $shortUrl->code = static::generateUniqueCode();
            }
        });
    }

    public static function generateUniqueCode(int $length = 7): string
    {
        do {
            $code = Str::random($length);
        } while (static::where('code', $code)->exists());

        return $code;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
