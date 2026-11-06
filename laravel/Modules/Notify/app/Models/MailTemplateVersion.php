<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\Media\Models\Media;
use Modules\Notify\Models\Traits\MailTemplateVersionRelations;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Traits\Updater;
use RuntimeException;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * @property-read ProfileContract|null $creator
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read MailTemplate|null $template
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static>|MailTemplateVersion newModelQuery()
 * @method static Builder<static>|MailTemplateVersion newQuery()
 * @method static Builder<static>|MailTemplateVersion onlyTrashed()
 * @method static Builder<static>|MailTemplateVersion query()
 * @method static Builder<static>|MailTemplateVersion withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|MailTemplateVersion withoutTrashed()
 *
 * @property string $id
 * @property int $mail_template_id
 * @property int $version
 * @property string|null $subject
 * @property string $html_template
 * @property string|null $text_template
 * @property array<array-key, mixed>|null $metadata
 * @property string|null $created_by
 * @property string|null $change_notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder<static>|MailTemplateVersion whereChangeNotes($value)
 * @method static Builder<static>|MailTemplateVersion whereCreatedAt($value)
 * @method static Builder<static>|MailTemplateVersion whereCreatedBy($value)
 * @method static Builder<static>|MailTemplateVersion whereDeletedAt($value)
 * @method static Builder<static>|MailTemplateVersion whereDeletedBy($value)
 * @method static Builder<static>|MailTemplateVersion whereHtmlTemplate($value)
 * @method static Builder<static>|MailTemplateVersion whereId($value)
 * @method static Builder<static>|MailTemplateVersion whereMailTemplateId($value)
 * @method static Builder<static>|MailTemplateVersion whereMetadata($value)
 * @method static Builder<static>|MailTemplateVersion whereSubject($value)
 * @method static Builder<static>|MailTemplateVersion whereTextTemplate($value)
 * @method static Builder<static>|MailTemplateVersion whereUpdatedAt($value)
 * @method static Builder<static>|MailTemplateVersion whereUpdatedBy($value)
 * @method static Builder<static>|MailTemplateVersion whereVersion($value)
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class MailTemplateVersion extends BaseModel
{
    use MailTemplateVersionRelations;
    use SoftDeletes, Updater;

    protected $connection = 'notify';

    /** @var list<string> */
    protected $fillable = [
        'mail_template_id',
        'subject',
        'html_template',
        'text_template',
        'version',
        'created_by',
        'change_notes'];

    public function restoreTemplate(): MailTemplate
    {
        $template = $this->template;

        if ($template === null) {
            throw new RuntimeException('Template non trovato per questa versione');
        }

        $template->update([
            'subject' => $this->subject,
            'html_template' => $this->html_template,
            'text_template' => $this->text_template]);

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
            'metadata' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime'];
    }
}
