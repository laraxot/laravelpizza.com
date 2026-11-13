<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Contracts\TenantContract;
use Modules\User\Models\Traits\BaseTenantRelationsTrait;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Modules\User\Models\Tenant.
 *
 * @property EloquentCollection<int, Model&UserContract> $members
 * @property int|null $members_count
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static> newModelQuery()
 * @method static Builder<static> newQuery()
 * @method static Builder<static> query()
 */
abstract class BaseTenant extends BaseModel implements HasAvatar, HasMedia, TenantContract
{
    use HasSlug;
    use HasUuids {
        HasUuids::resolveRouteBindingQuery as resolveRouteBindingQueryFromUuids;
    }
    use BaseTenantRelationsTrait;
    use InteractsWithMedia;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'slug',
        'email_address',
        'phone',
        'mobile',
        'address',
        'primary_color',
        'secondary_color',
    ];

    /**
<<<<<<< .merge_file_POWtpG
     * @param  Builder<Model>|Model  $query
     * @param  string|int  $value
     * @param  string|null  $field
=======
     * `settings` e' una colonna JSON: senza cast un array in ingresso finisce nell'INSERT
     * come stringa ("Array to string conversion").
     *
     * @return array<string, string>
     */
    #[\Override]
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'settings' => 'array',
            'trial_ends_at' => 'datetime',
        ]);
    }

    /**
     * @param Builder<Model>|Model $query
     * @param string|int $value
     * @param string|null $field
>>>>>>> .merge_file_YnpcBA
     * @return Builder<Model>
     */
    public function resolveRouteBindingQuery($query, $value, $field = null): Builder
    {
        if ($query instanceof Model) {
            $query = $query->newQuery();
        }

        return $query->where($field ?? $this->getRouteKeyName(), $value);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        // Senza media getFirstMediaUrl() restituisce '': Filament si aspetta null per
        // mostrare l'avatar di ripiego, non un <img src="">.
        $url = $this->getFirstMediaUrl('avatar');

        return $url !== '' ? $url : null;
    }
}
