<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class ErrorLog extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'project_id',
        'project_name',
        'message',
        'stack_trace',
        'error_type',
        'severity_level',
        'device_model',
        'os_version',
        'flutter_version',
        'app_version',
        'custom_payload',
        'client_timestamp',
    ];

    protected $casts = [
        'custom_payload' => 'array',
        'client_timestamp' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
