<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Models\Media;
use Modules\Notify\Models\Traits\NotificationTemplateVersionRelations;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Traits\Updater;
use RuntimeException;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

// BaseModel in same namespace provides common behaviors
/**
 * @property int|null $template_id
 * @property string $id
 * @property string|null $subject
 * @property string|null $body_html
 * @property string|null $body_text
 * @property array<int, string>|null $channels
 * @property array<string, mixed>|null $variables
 * @property array<string, mixed>|null $conditions
 * @property int|string|null $version
 * @property-read ProfileContract|null $creator
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read NotificationTemplate|null $template
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static>|NotificationTemplateVersion newModelQuery()
 * @method static Builder<static>|NotificationTemplateVersion newQuery()
 * @method static Builder<static>|NotificationTemplateVersion query()
 *
 * @mixin Model
 */
class NotificationTemplateVersion extends BaseModel
{
    use NotificationTemplateVersionRelations;
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
        'change_notes'];

    public function restoreTemplate(): NotificationTemplate
    {
        $template = $this->template;

        if (! $template) {
            throw new RuntimeException('Template not found for version '.$this->id);
        }

        $template->update([
            'subject' => $this->subject ?? null,
            'body_html' => $this->body_html ?? null,
            'body_text' => $this->body_text ?? null,
            'channels' => $this->channels ?? null,
            'variables' => $this->variables ?? null,
            'conditions' => $this->conditions ?? null]);

        return $template;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'channels' => 'array',
            'variables' => 'array',
            'conditions' => 'array'];
    }
}
