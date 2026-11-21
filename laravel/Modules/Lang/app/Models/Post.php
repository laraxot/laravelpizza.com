<?php

declare(strict_types=1);

namespace Modules\Lang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
// --- traits ---
// use Laravel\Scout\Searchable;
use Modules\Lang\Models\Traits\PostMutators;
use Modules\Lang\Models\Traits\PostRelations;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Traits\Updater;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Colonne allineate a `2026_01_21_211814_create_posts_table`.
 *
 * @property string $id
 * @property int|null $user_id
 * @property string|int|null $post_id
 * @property string|null $lang
 * @property string|null $guid
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $post_type
 * @property string|null $txt
 * @property string|null $content
 * @property string|null $excerpt
 * @property string|null $slug
 * @property string|null $status
 * @property Carbon|null $published_at
 * @property string|null $locale
 * @property string|null $category
 * @property string|null $image_src
 * @property string|null $image_alt
 * @property string|null $image_title
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int|null $author_id
 * @property string|null $url
 * @property array<string, string>|null $url_lang
 * @property string|null $image_resize_src
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $category_id
 * @property string|null $image
 * @property int|null $published
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $linked_count
 * @property string|null $related_count
 * @property string|null $relatedrev_count
 * @property string|null $linkable_type
 * @property int|null $views_count
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property Model|null $linkable
 * @property ProfileContract|null $updater
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereGuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereImageAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereImageResizeSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereImageSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereImageTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereLinkableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereLinkedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereRelatedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereRelatedrevCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTxt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUrlLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereViewsCount($value)
 *
 * @mixin Model
 */
class Post extends BaseModel
{
    use HasSlug;
    use PostMutators;
    use PostRelations;

    // use Cachable;
    use Updater;

    /*
     * public function getUrlAttribute($value) {
     *
     * }
     */

    final public const array SEARCHABLE_FIELDS = ['title', 'guid', 'txt'];

    public static $snakeAttributes = true;

    /** @var bool */
    public $incrementing = false;

    /** @var int */
    protected $perPage = 30;

    // use Searchable;
    /** @var string */
    protected $connection = 'lang';

    /** @var list<string> */
    protected $fillable = [
        'id',
        'user_id',
        'post_id',
        'lang',
        'guid',
        'title',
        'subtitle',
        'post_type',
        'txt',
        'content',
        'excerpt',
        'slug',
        'status',
        'published_at',
        'locale',
        'category',
        // ------ IMAGE ---------
        'image_src',
        'image_alt',
        'image_title',
        // ------ SEO FIELDS -----
        'meta_title',
        'meta_description',
        'meta_keywords', // seo
        'author_id',
        // ------ BUFFER ----
        'url',
        'url_lang', // buffer
        'image_resize_src', // buffer
    ];

    /** @var list<string> */
    protected $appends = [];

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string */
    protected $keyType = 'string';

    /*
     * public function getRouteKeyName() {
     * return inAdmin() ? 'guid' : 'post_id';
     * }
     */

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('guid');
    }

    // -------- relationship ------
    /* deprecated
     * public function archive() {
     * $lang = $this->lang;
     * $post_type = $this->post_type;
     * $obj = $this->getLinkedModel();
     * $table = $obj->getTable();
     * $post_table = with(new Post())->getTable();
     * $rows = $obj->join($post_table, $post_table.'.post_id', $table.'.post_id')
     * ->where('lang', $lang)
     * ->where($post_table.'.post_type', $post_type)
     * ->where($post_table.'.guid', '!=', $post_type)
     * ->orderBy($table.'.updated_at', 'desc')
     * ->with('post')
     * ;
     *
     * return $rows;
     * }
     */

    // end function
    // -------------- MUTATORS ------------------

    /**
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return $this->only(self::SEARCHABLE_FIELDS);
    }
}
