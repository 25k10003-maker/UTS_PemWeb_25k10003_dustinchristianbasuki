<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ApiToken extends Model
{
    // Tentutkan nama tabel secara eksplisit (sesuai nama tabel migrasi Anda)
    protected $table = 'api_tokens'; 

    protected $fillable = ['user_id', 'token', 'expires_at'];

    protected function casts(): array
    {
        return ['expires_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Buat token baru untuk user. Yang disimpan di DB hanya hash-nya,
     * token asli (plain) hanya dikembalikan sekali ke client.
     *
     * @return array{0: string, 1: self}
     */
    public static function issueFor(User $user): array
    {
        $plain = Str::random(64);

        $token = static::create([
            'user_id'    => $user->id,
            'token'      => hash('sha256', $plain),
            'expires_at' => now()->addMinutes((int) config('api.token_ttl', 60)), // Diset 60 menit agar token tidak langsung expired
        ]);

        return [$plain, $token];
    }

    public static function findByPlain(?string $plain): ?self
    {
        if (! $plain) {
            return null;
        }

        return static::with('user')->where('token', hash('sha256', $plain))->first();
    }
}
