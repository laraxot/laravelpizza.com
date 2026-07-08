<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Illuminate\Support\Carbon;
use Modules\Media\Models\Media;
use Modules\Ptv\Models\Profile;
use Modules\Rating\Enums\RuleEnum;
use Modules\Rating\Models\BaseRating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\IndennitaResponsabilita\Database\Factories\RatingFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * Modules\IndennitaResponsabilita\Models\Rating
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $color
 * @property string|null $icon
 * @property string|null $txt
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property RuleEnum|null $rule
 * @property bool|null $is_disabled
 * @property bool|null $is_readonly
 * @property int|null $anno
 * @property int|null $order_column
 * @method static Builder|Rating newModelQuery()
 * @method static Builder|Rating newQuery()
 * @method static Builder|Rating query()
 * @method static Builder|Rating whereColor($value)
 * @method static Builder|Rating whereCreatedAt($value)
 * @method static Builder|Rating whereCreatedBy($value)
 * @method static Builder|Rating whereExtraAttributes($value)
 * @method static Builder|Rating whereIcon($value)
 * @method static Builder|Rating whereId($value)
 * @method static Builder|Rating whereIsDisabled($value)
 * @method static Builder|Rating whereIsReadonly($value)
 * @method static Builder|Rating whereOrderColumn($value)
 * @method static Builder|Rating whereRule($value)
 * @method static Builder|Rating whereTitle($value)
 * @method static Builder|Rating whereTxt($value)
 * @method static Builder|Rating whereUpdatedAt($value)
 * @method static Builder|Rating whereUpdatedBy($value)
 * @method static Builder|Rating withExtraAttributes(array|string $attributes = [], mixed $value = null)
 * @property-read Profile|null $creator
 * @property-read Model|\Eloquent $linkedTo
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Profile|null $updater
 * @method static RatingFactory factory($count = null, $state = [])
 * @property string|null $slug
 * @property-read Profile|null $deleter
 * @method static Builder<static>|Rating whereSlug($value)
 * @method static Builder<static>|Rating withExtraAttributes(array<string, mixed> $attributes)
 * @mixin \Eloquent
 */
class Rating extends BaseRating
{
    protected $connection = 'indennita_responsabilita'; // this will use the specified database connection

    // DRY: casts(), scopeWithExtraAttributes(), $fillable ereditati da BaseRating
    // @see Modules/Rating/docs/schemaless-attributes-errors.md
    // @see Modules/IndennitaResponsabilita/docs/rating-schemaless-usage.md
}
