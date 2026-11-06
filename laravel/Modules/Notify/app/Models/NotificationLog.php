<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Modules\Media\Models\Media;
use Modules\Notify\Enums\NotificationLogStatusEnum;
use Modules\Notify\Models\Traits\NotificationLogRelations;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * @property-read ProfileContract|null $creator
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Model $notifiable
 * @property-read NotificationTemplate|null $template
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static>|NotificationLog forChannel(string $channel)
 * @method static Builder<static>|NotificationLog forNotifiable(\Illuminate\Database\Eloquent\Model $notifiable)
 * @method static Builder<static>|NotificationLog newModelQuery()
 * @method static Builder<static>|NotificationLog newQuery()
 * @method static Builder<static>|NotificationLog query()
 * @method static Builder<static>|NotificationLog withStatus(NotificationLogStatusEnum $status)
 *
 * @property string $id
 * @property string|null $template_id
 * @property string $notifiable_type
 * @property string $notifiable_id
 * @property string $channel
 * @property NotificationLogStatusEnum $status
 * @property string|null $status_message
 * @property array<array-key, mixed>|null $data
 * @property array<array-key, mixed>|null $metadata
 * @property string|null $tenant_id
 * @property Carbon|null $sent_at
 * @property Carbon|null $delivered_at
 * @property Carbon|null $failed_at
 * @property Carbon|null $opened_at
 * @property Carbon|null $clicked_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 *
 * @method static Builder<static>|NotificationLog whereChannel($value)
 * @method static Builder<static>|NotificationLog whereClickedAt($value)
 * @method static Builder<static>|NotificationLog whereCreatedAt($value)
 * @method static Builder<static>|NotificationLog whereCreatedBy($value)
 * @method static Builder<static>|NotificationLog whereData($value)
 * @method static Builder<static>|NotificationLog whereDeliveredAt($value)
 * @method static Builder<static>|NotificationLog whereFailedAt($value)
 * @method static Builder<static>|NotificationLog whereId($value)
 * @method static Builder<static>|NotificationLog whereMetadata($value)
 * @method static Builder<static>|NotificationLog whereNotifiableId($value)
 * @method static Builder<static>|NotificationLog whereNotifiableType($value)
 * @method static Builder<static>|NotificationLog whereOpenedAt($value)
 * @method static Builder<static>|NotificationLog whereSentAt($value)
 * @method static Builder<static>|NotificationLog whereStatus($value)
 * @method static Builder<static>|NotificationLog whereStatusMessage($value)
 * @method static Builder<static>|NotificationLog whereTemplateId($value)
 * @method static Builder<static>|NotificationLog whereTenantId($value)
 * @method static Builder<static>|NotificationLog whereUpdatedAt($value)
 * @method static Builder<static>|NotificationLog whereUpdatedBy($value)
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class NotificationLog extends BaseModel
{
    use NotificationLogRelations;

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
        'tenant_id'];

    /** @return MorphTo<Model, $this> */

    /** @return BelongsTo<NotificationTemplate, $this> */

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeWithStatus(Builder $query, NotificationLogStatusEnum $status): Builder
    {
        return $query->where('status', $status->value);
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeForChannel(Builder $query, string $channel): Builder
    {
        return $query->where('channel', $channel);
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeForNotifiable(Builder $query, Model $notifiable): Builder
    {
        return $query
            ->where('notifiable_type', $notifiable::class)
            ->where('notifiable_id', $notifiable->getKey());
    }

    public function markAsOpened(): self
    {
        $this->update([
            'status' => NotificationLogStatusEnum::OPENED->value,
            'opened_at' => now()]);

        return $this;
    }

    public function markAsClicked(): self
    {
        $this->update([
            'status' => NotificationLogStatusEnum::CLICKED->value,
            'clicked_at' => now()]);

        return $this;
    }

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'status' => NotificationLogStatusEnum::class,
            'data' => 'array',
            'metadata' => 'array',
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
            'failed_at' => 'datetime',
            'opened_at' => 'datetime',
            'clicked_at' => 'datetime']);
    }
}
