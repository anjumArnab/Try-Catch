<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Support\Str;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;

class Project extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = ['user_id', 'name', 'slug', 'endpoint_slug', 'api_key'];

    protected $casts = [
        'api_key' => 'encrypted',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);

        static::creating(function (Project $project): void {
            $project->slug = Str::slug($project->name);
            $project->endpoint_slug = static::uniqueEndpointSlug($project->slug);

            if (empty($project->api_key)) {
                $project->api_key = static::generateApiKey();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function errorLogs(): HasMany
    {
        return $this->hasMany(ErrorLog::class);
    }

    public static function generateApiKey(): string
    {
        return Str::random(24);
    }

    protected static function uniqueEndpointSlug(string $slug): string
    {
        do {
            $candidate = $slug.'-'.static::randomAlpha5();
        } while (static::withoutGlobalScopes()->where('endpoint_slug', $candidate)->exists());

        return $candidate;
    }

    protected static function randomAlpha5(): string
    {
        return substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', 5)), 0, 5);
    }
}
