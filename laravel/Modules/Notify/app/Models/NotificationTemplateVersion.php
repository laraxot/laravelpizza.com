<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Override;
use RuntimeException;
use Modules\User\Models\Profile;
use Modules\Media\Models\Media;
use Modules\Notify\Database\Factories\NotificationTemplateVersionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Xot\Traits\Updater;

// BaseModel in same namespace provides common behaviors
/**
 * @property-read Profile|null $creator
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read NotificationTemplate|null $template
 * @property-read Profile|null $updater
 * @method static NotificationTemplateVersionFactory factory($count = null, $state = [])
 * @method static Builder<static>|NotificationTemplateVersion newModelQuery()
 * @method static Builder<static>|NotificationTemplateVersion newQuery()
 * @method static Builder<static>|NotificationTemplateVersion query()
 * @mixin IdeHelperNotificationTemplateVersion
<<<<<<< HEAD
 * @property-read \Modules\Xot\Contracts\ProfileContract|null $deleter
=======
 * @property-read \Modules\TechPlanner\Models\Profile|null $deleter
>>>>>>> c8903a55c (.)
 * @mixin \Eloquent
 */
class NotificationTemplateVersion extends BaseModel
{
    use Updater;

    protected $fillable = [
        'template_id',
        'subject',
        'body_html',
        'body_text',
        'channels',
        'variables',
        'conditions',
        'version',
        'created_by',
        'change_notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[Override]
    protected function casts(): array
    {
        return [
            'channels' => 'array',
            'variables' => 'array',
            'conditions' => 'array',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplate::class, 'template_id');
    }

    public function restore(): NotificationTemplate
    {
        $template = $this->template;

        if (!$template) {
            throw new RuntimeException('Template not found for version ' . $this->id);
        }

        $template->update([
            'subject' => $this->subject ?? null,
            'body_html' => $this->body_html ?? null,
            'body_text' => $this->body_text ?? null,
            'channels' => $this->channels ?? null,
            'variables' => $this->variables ?? null,
            'conditions' => $this->conditions ?? null,
        ]);

        return $template;
    }
}
