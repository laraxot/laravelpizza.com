<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

// use Spatie\LaravelPackageTools\Concerns\Package\HasTranslations;
use Exception;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Notify\Database\Factories\MailTemplateFactory;
use Spatie\MailTemplates\Interfaces\MailTemplateInterface;
use Spatie\MailTemplates\Models\MailTemplate as SpatieMailTemplate;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

/**
 * @property-read list<string> $translatable_columns_from
 * @property-read array<string, mixed> $variables
 * @property-read array<string, array<string, mixed>> $translations
 *
 * @method static Builder<static>|MailTemplate forMailable(\Illuminate\Contracts\Mail\Mailable $mailable)
 * @method static Builder<static>|MailTemplate newModelQuery()
 * @method static Builder<static>|MailTemplate newQuery()
 * @method static Builder<static>|MailTemplate query()
 * @method static Builder<static>|MailTemplate whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|MailTemplate whereJsonContainsLocales(string $column, array<int, string> $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|MailTemplate whereLocale(string $column, string $locale)
 * @method static Builder<static>|MailTemplate whereLocales(string $column, array<int, string> $locales)
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $mailable
 * @property string|null $slug
 * @property string|array<array-key, mixed>|null $subject
 * @property string|array<array-key, mixed>|null $html_template
 * @property string|array<array-key, mixed>|null $text_template
 * @property string|int $version
 * @property string|null $params
 * @property array<array-key, mixed>|null $sms_template
 * @property string|null $sms_from
 * @property int $counter
 * @property string|null $html_layout_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder<static>|MailTemplate whereCounter($value)
 * @method static Builder<static>|MailTemplate whereCreatedAt($value)
 * @method static Builder<static>|MailTemplate whereCreatedBy($value)
 * @method static Builder<static>|MailTemplate whereDeletedAt($value)
 * @method static Builder<static>|MailTemplate whereDeletedBy($value)
 * @method static Builder<static>|MailTemplate whereHtmlLayoutPath($value)
 * @method static Builder<static>|MailTemplate whereHtmlTemplate($value)
 * @method static Builder<static>|MailTemplate whereId($value)
 * @method static Builder<static>|MailTemplate whereMailable($value)
 * @method static Builder<static>|MailTemplate whereName($value)
 * @method static Builder<static>|MailTemplate whereParams($value)
 * @method static Builder<static>|MailTemplate whereSlug($value)
 * @method static Builder<static>|MailTemplate whereSmsFrom($value)
 * @method static Builder<static>|MailTemplate whereSmsTemplate($value)
 * @method static Builder<static>|MailTemplate whereSubject($value)
 * @method static Builder<static>|MailTemplate whereTextTemplate($value)
 * @method static Builder<static>|MailTemplate whereUpdatedAt($value)
 * @method static Builder<static>|MailTemplate whereUpdatedBy($value)
 * @method static Builder<static>|MailTemplate whereVersion($value)
 *
 * @mixin Model
 */
class MailTemplate extends SpatieMailTemplate implements MailTemplateInterface
{
    /** @use HasFactory<MailTemplateFactory> */
    use HasFactory;

    use HasSlug;

    use HasTranslations;

    /** @var list<string> */
    public array $translatable = ['subject', 'html_template', 'text_template', 'sms_template'];

    protected $connection = 'notify';

    /** @var list<string> */
    protected $fillable = [
        'mailable',
        'name',
        'slug',
        'subject',
        'html_layout_path',
        'html_template',
        'text_template',
        'sms_template',
        'sms_from',
        'whatsapp_template',
        // 'version',  //under development
        'params',
        'counter'];

    /**
     * Get the options for generating the slug.
     *
     * `preventOverwrite()`: senza, HasSlug rigenera lo slug da `subject` ad ogni
     * save/update — anche il `$tpl->update(['counter' => ...])` che
     * SpatieEmail::__construct() fa ad ogni istanziazione. Risultato: uno slug
     * impostato a mano (es. `survey-pdf-44-invito` dalla scheda "Inviti" o dallo
     * script di migrazione) veniva silenziosamente sovrascritto col
     * subject-slug, e il lookup successivo `findForMailable()` non lo trovava più
     * (story quaeris-send-invite-migrate-to-record-notification.md, Difetto 10).
     * Con `preventOverwrite()` lo slug si genera solo se il campo è vuoto.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('subject')
            ->saveSlugsTo('slug')
            ->preventOverwrite();
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeForMailable(Builder $query, Mailable $mailable): Builder
    {
        if (! method_exists($mailable, 'getSlug')) {
            throw new Exception('Il metodo getSlug() non è definito nella classe '.$mailable::class);
        }
        $slug = $mailable->getSlug();

        return $query->where('mailable', $mailable::class)->where('slug', $slug);
    }

    /**
     * Define attribute casts.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime'];
    }
}
