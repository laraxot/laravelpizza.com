<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

/**
 * @property string|null $name
 * @property string|null $driver
 * @property array<string, mixed>|null $config
 * @property bool|null $is_enabled
 * @property int|null $priority
 */
class NotificationChannel extends BaseModel
{
    protected $table = 'notification_channels';

    protected $fillable = [
        'name',
        'driver',
        'config',
        'is_enabled',
        'priority',
    ];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'config' => 'array',
            'is_enabled' => 'boolean',
            'priority' => 'integer',
        ]);
    }
}
