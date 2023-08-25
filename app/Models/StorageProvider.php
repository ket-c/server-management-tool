<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property string $profile
 * @property string $provider
 * @property array $credentials
 * @property User $user
 */
class StorageProvider extends AbstractModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile',
        'provider',
        'credentials',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'credentials' => 'encrypted:array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function provider(): \App\Contracts\StorageProvider
    {
        $providerClass = config('core.storage_providers_class')[$this->provider];

        return new $providerClass($this);
    }
}
