<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\User\Models\Traits\HasTenants;
use Modules\Xot\Traits\Updater;

/**
 * NotificationLog model for logging sent notifications.
 *
 * @property int $id
 * @property int|null $template_id
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $channel
 * @property string $status
 * @property string|null $status_message
 * @property array<string, mixed>|null $data
 * @property array<string, mixed>|null $metadata
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property \Illuminate\Support\Carbon|null $delivered_at
 * @property \Illuminate\Support\Carbon|null $failed_at
 * @property \Illuminate\Support\Carbon|null $opened_at
 * @property \Illuminate\Support\Carbon|null $clicked_at
 * @property int|null $tenant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Notify\Models\NotificationTemplate|null $template
 * @property-read \Illuminate\Database\Eloquent\Model $notifiable
 */
class NotificationLog extends Model
{
    use HasFactory;
    use HasTenants;
    use Updater;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SENT = 'sent';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_FAILED = 'failed';
    public const STATUS_SKIPPED = 'skipped';
    public const STATUS_OPENED = 'opened';
    public const STATUS_CLICKED = 'clicked';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notification_logs';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
            'metadata' => 'array',
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
            'failed_at' => 'datetime',
            'opened_at' => 'datetime',
            'clicked_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    
    /**
     * Get the notifiable entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Get the notification template.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Modules\Notify\Models\NotificationTemplate, \Modules\Notify\Models\NotificationLog>
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplate::class, 'template_id');
    }
    
    /**
     * Scope to filter by status.
     *
     * @param \Illuminate\Database\Eloquent\Builder<static> $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder<static>
     */
    public function scopeWithStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
    
    /**
     * Scope to filter by channel.
     *
     * @param \Illuminate\Database\Eloquent\Builder<static> $query
     * @param string $channel
     * @return \Illuminate\Database\Eloquent\Builder<static>
     */
    public function scopeForChannel($query, string $channel)
    {
        return $query->where('channel', $channel);
    }
    
    /**
     * Scope to filter by notifiable entity.
     *
     * @param \Illuminate\Database\Eloquent\Builder<static> $query
     * @param \Illuminate\Database\Eloquent\Model $notifiable
     * @return \Illuminate\Database\Eloquent\Builder<static>
     */
    public function scopeForNotifiable($query, Model $notifiable)
    {
        return $query->where('notifiable_type', get_class($notifiable))
            ->where('notifiable_id', $notifiable->getKey());
    }

    /**
     * Mark the notification as sent.
     *
     * @return self
     */
    public function markAsSent(): self
    {
        $this->update([
            'status' => self::STATUS_SENT,
            'sent_at' => now(),
        ]);

        return $this;
    }

    /**
     * Mark the notification as delivered.
     *
     * @return self
     */
    public function markAsDelivered(): self
    {
        $this->update([
            'status' => self::STATUS_DELIVERED,
            'delivered_at' => now(),
        ]);

        return $this;
    }

    /**
     * Mark the notification as failed.
     *
     * @param string|null $message
     * @return self
     */
    public function markAsFailed(?string $message = null): self
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'status_message' => $message,
            'failed_at' => now(),
        ]);

        return $this;
    }

    /**
     * Mark the notification as opened.
     *
     * @return self
     */
    public function markAsOpened(): self
    {
        $this->update([
            'status' => self::STATUS_OPENED,
            'opened_at' => now(),
        ]);

        return $this;
    }

    /**
     * Mark the notification as clicked.
     *
     * @return self
     */
    public function markAsClicked(): self
    {
        $this->update([
            'status' => self::STATUS_CLICKED,
            'clicked_at' => now(),
        ]);

        return $this;
    }

    /**
     * Get the status label attribute.
     *
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        return __('notify::notification.fields.status.' . $this->status);
    }

    /**
     * Get the channel label attribute.
     *
     * @return string
     */
    public function getChannelLabelAttribute(): string
    {
        return __('notify::notification.fields.channel.options.' . $this->channel . '.label');
    }
}
