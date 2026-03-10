<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

/**
 * @property string|null $name
 * @property string|null $driver
 * @property array<string, mixed>|null $config
 * @property bool|null $is_enabled
 * @property int|null $priority
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $deleter
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\Notify\Database\Factories\NotificationChannelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationChannel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationChannel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationChannel query()
 * @mixin \Eloquent
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
