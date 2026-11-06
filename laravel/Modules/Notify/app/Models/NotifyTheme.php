<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Modules\Media\Models\Media;
use Modules\Notify\Database\Factories\NotifyThemeFactory;
use Modules\Notify\Models\Traits\NotifyThemeMutators;
use Modules\Notify\Models\Traits\NotifyThemeRelations;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * Modules\Notify\Models\NotifyTheme.
 *
 * @method static NotifyThemeFactory factory($count = null, $state = [])
 *
 * @property-read ProfileContract|null $creator
 * @property-read array{path: string, width: int, height: int} $logo
 * @property-read Model $linkable
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static>|NotifyTheme newModelQuery()
 * @method static Builder<static>|NotifyTheme newQuery()
 * @method static Builder<static>|NotifyTheme query()
 *
 * @property string $id
 * @property string|null $lang
 * @property string|null $type
 * @property string|null $subject
 * @property string|null $body
 * @property string|null $from
 * @property string|null $post_type
 * @property int|null $post_id
 * @property string|null $body_html
 * @property string|null $theme
 * @property string|null $from_email
 * @property string|null $logo_src
 * @property int|null $logo_width
 * @property int|null $logo_height
 * @property array<array-key, mixed>|null $view_params
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder<static>|NotifyTheme whereBody($value)
 * @method static Builder<static>|NotifyTheme whereBodyHtml($value)
 * @method static Builder<static>|NotifyTheme whereCreatedAt($value)
 * @method static Builder<static>|NotifyTheme whereCreatedBy($value)
 * @method static Builder<static>|NotifyTheme whereDeletedAt($value)
 * @method static Builder<static>|NotifyTheme whereDeletedBy($value)
 * @method static Builder<static>|NotifyTheme whereFrom($value)
 * @method static Builder<static>|NotifyTheme whereFromEmail($value)
 * @method static Builder<static>|NotifyTheme whereId($value)
 * @method static Builder<static>|NotifyTheme whereLang($value)
 * @method static Builder<static>|NotifyTheme whereLogoHeight($value)
 * @method static Builder<static>|NotifyTheme whereLogoSrc($value)
 * @method static Builder<static>|NotifyTheme whereLogoWidth($value)
 * @method static Builder<static>|NotifyTheme wherePostId($value)
 * @method static Builder<static>|NotifyTheme wherePostType($value)
 * @method static Builder<static>|NotifyTheme whereSubject($value)
 * @method static Builder<static>|NotifyTheme whereTheme($value)
 * @method static Builder<static>|NotifyTheme whereType($value)
 * @method static Builder<static>|NotifyTheme whereUpdatedAt($value)
 * @method static Builder<static>|NotifyTheme whereUpdatedBy($value)
 * @method static Builder<static>|NotifyTheme whereViewParams($value)
 *
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class NotifyTheme extends BaseModel
{
    use NotifyThemeMutators;
    use NotifyThemeRelations;

    /** @var list<string> */
    protected $fillable = [
        'id',
        'lang',
        'type',
        'subject',
        'body',
        'body_html',
        'from',
        'from_email',
        'post_type',
        'post_id',
        'theme',
        'logo_src',
        'logo_width',
        'logo_height',
        'view_params'];

    /** @var list<string> */
    protected $appends = [
        'logo'];

    /**
     * `logo` non e' una colonna: l'accessor delega al gemello e `$value` resta per il contratto accessor di Xot.
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     *
     * @param  array<string, mixed>|null  $value
     * @return array{path: string, width: int, height: int}
     */

    /**
     * @return array{path: string, width: int, height: int}
     */

    /**
     * Get the parent linkable model (user or post).
     */
    /** @return MorphTo<Model, $this> */

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
            // 'published_at' => 'datetime:Y-m-d', // da verificare
            'view_params' => 'array'];
    }
}
