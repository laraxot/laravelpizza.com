<?php

declare(strict_types=1);

/**
 * inspired by  DutchCodingCompany\FilamentSocialite.
 */

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Tenant\Models\Traits\SushiToPhpArray;
use Modules\User\Database\Factories\SocialProviderFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * @property int|null             $id
 * @property string|null          $name
 * @property array|null           $scopes
 * @property array|null           $parameters
 * @property bool|null            $stateless
 * @property bool|null            $active
 * @property bool|null            $socialite
 * @property string|null          $svg
 * @property string|null          $client_id
 * @property string|null          $client_secret
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static SocialProviderFactory  factory($count = null, $state = [])
 * @method static Builder|SocialProvider newModelQuery()
 * @method static Builder|SocialProvider newQuery()
 * @method static Builder|SocialProvider query()
 * @method static Builder|SocialProvider whereActive($value)
 * @method static Builder|SocialProvider whereClientId($value)
 * @method static Builder|SocialProvider whereClientSecret($value)
 * @method static Builder|SocialProvider whereId($value)
 * @method static Builder|SocialProvider whereName($value)
 * @method static Builder|SocialProvider whereParameters($value)
 * @method static Builder|SocialProvider whereScopes($value)
 * @method static Builder|SocialProvider whereSocialite($value)
 * @method static Builder|SocialProvider whereStateless($value)
 * @method static Builder|SocialProvider whereSvg($value)
 *
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static Builder|SocialProvider whereCreatedAt($value)
 * @method static Builder|SocialProvider whereCreatedBy($value)
 * @method static Builder|SocialProvider whereUpdatedAt($value)
 * @method static Builder|SocialProvider whereUpdatedBy($value)
 *
 * @mixin IdeHelperSocialProvider
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class SocialProvider extends BaseModel
{
    use SushiToPhpArray;

    /** @var bool */
    public $incrementing = false;

    /** @var list<string> */
    protected $fillable = [
        // 'id',
        'name', // => 'Facebook',
        'scopes', // => null,
        'parameters', // => null,
        'stateless', // => true,
        'active', // => false,
        'socialite', // => true,
        'svg', // => '<svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none"><path fill="#0866FF" d="M48 24C48 10.745 37.255 0 24 0S0 10.745 0 24c0 11.255 7.75 20.7 18.203 23.293V31.334h-4.95V24h4.95v-3.16c0-8.169 3.697-11.955 11.716-11.955 1.521 0 4.145.298 5.218.596v6.648c-.566-.06-1.55-.09-2.773-.09-3.935 0-5.455 1.492-5.455 5.367V24h7.84L33.4 31.334H26.91v16.49C38.793 46.39 48 36.271 48 24H48Z"/><path fill="#fff" d="M33.4 31.334 34.747 24h-7.84v-2.594c0-3.875 1.521-5.366 5.457-5.366 1.222 0 2.206.03 2.772.089V9.481c-1.073-.299-3.697-.596-5.218-.596-8.02 0-11.716 3.786-11.716 11.955V24h-4.95v7.334h4.95v15.96a24.042 24.042 0 0 0 8.705.53v-16.49H33.4Z"/></svg>',
        // 'client_id',// => env('FACEBOOK_CLIENT_ID'),
        // 'client_secret',// => env('FACEBOOK_CLIENT_SECRET'),
    ];

    /**
     * Logical form definition for this Sushi-backed model.
     *
     * @var array<string, string>
     */
    protected array $form = [
        'id' => 'integer',
        'name' => 'string',
        'scopes' => 'json',
        'parameters' => 'json',
        'stateless' => 'boolean',
        'active' => 'boolean',
        'socialite' => 'boolean',
        'svg' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    /** @var array<string, string> */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
        'scopes' => 'text',
        'parameters' => 'text',
        'stateless' => 'boolean',
        'active' => 'boolean',
        'socialite' => 'boolean',
        'svg' => 'text',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    /** @return array<string, string> */
    #[\Override]
    protected function casts(): array
    {
        return [
            'scopes' => 'array',
            'parameters' => 'array',
            'stateless' => 'boolean',
            'active' => 'boolean',
            'socialite' => 'boolean',
        ];
    }
}
