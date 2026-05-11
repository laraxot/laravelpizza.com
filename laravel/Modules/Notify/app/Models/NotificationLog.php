<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Modules\Media\Models\Media;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * @property string|null $template_id
 * @property string|null $notifiable_type
 * @property string|null $notifiable_id
 * @property string|null $channel
 * @property string|null $status
 * @property string|null $status_message
 * @property array<string, mixed>|null $data
 * @property array<string, mixed>|null $metadata
 *
 * @method static Builder<static> where(string $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static static|null find(mixed $id, array|string $columns = ['*'])
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $channels
 * @property Carbon $sent_at
 * @property string|null $error
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Model|\Eloquent $notifiable
 * @property-read NotificationTemplate|null $template
 * @property-read ProfileContract|null $updater
 *
 * @method static \Modules\Notify\Database\Factories\NotificationLogFactory factory($count = null, $state = [])
 * @method static Builder<static>|NotificationLog forChannel(string $channel)
 * @method static Builder<static>|NotificationLog forNotifiable(\Illuminate\Database\Eloquent\Model $notifiable)
 * @method static Builder<static>|NotificationLog newModelQuery()
 * @method static Builder<static>|NotificationLog newQuery()
 * @method static Builder<static>|NotificationLog query()
 * @method static Builder<static>|NotificationLog whereChannels($value)
 * @method static Builder<static>|NotificationLog whereContent($value)
 * @method static Builder<static>|NotificationLog whereCreatedAt($value)
 * @method static Builder<static>|NotificationLog whereData($value)
 * @method static Builder<static>|NotificationLog whereError($value)
 * @method static Builder<static>|NotificationLog whereId($value)
 * @method static Builder<static>|NotificationLog whereNotifiableId($value)
 * @method static Builder<static>|NotificationLog whereNotifiableType($value)
 * @method static Builder<static>|NotificationLog whereSentAt($value)
 * @method static Builder<static>|NotificationLog whereStatus($value)
 * @method static Builder<static>|NotificationLog whereTitle($value)
 * @method static Builder<static>|NotificationLog whereUpdatedAt($value)
 * @method static Builder<static>|NotificationLog withStatus(string $status)
 *
 * @mixin \Eloquent
 */
class NotificationLog extends BaseModel
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_SENT = 'sent';

    public const STATUS_DELIVERED = 'delivered';

    public const STATUS_FAILED = 'failed';

    public const STATUS_OPENED = 'opened';

    public const STATUS_CLICKED = 'clicked';

    protected $table = 'notification_logs';

    protected $fillable = [
        'template_id',
        'notifiable_type',
        'notifiable_id',
        'channel',
        'status',
        'status_message',
        'data',
        'metadata',
        'sent_at',
        'delivered_at',
        'failed_at',
        'opened_at',
        'clicked_at',
        'tenant_id',
    ];

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplate::class, 'template_id');
    }

    public function scopeWithStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeForChannel(Builder $query, string $channel): Builder
    {
        return $query->where('channel', $channel);
    }

    public function scopeForNotifiable(Builder $query, Model $notifiable): Builder
    {
        return $query
            ->where('notifiable_type', $notifiable::class)
            ->where('notifiable_id', $notifiable->getKey());
    }

    public function markAsOpened(): self
    {
        $this->update([
            'status' => self::STATUS_OPENED,
            'opened_at' => now(),
        ]);

        return $this;
    }

    public function markAsClicked(): self
    {
        $this->update([
            'status' => self::STATUS_CLICKED,
            'clicked_at' => now(),
        ]);

        return $this;
    }

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'data' => 'array',
            'metadata' => 'array',
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
            'failed_at' => 'datetime',
            'opened_at' => 'datetime',
            'clicked_at' => 'datetime',
        ]);
    }
}
