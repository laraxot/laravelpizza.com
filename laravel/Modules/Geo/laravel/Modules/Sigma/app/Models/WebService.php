<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Modules\Ptv\Models\Profile;
use Modules\Tenant\Models\Traits\SushiToCsv;

/**
 * WebService Model
 *
 * Represents a web service configuration in the system.
 * Uses SushiToCsv trait for CSV-based persistence.
 *
 * @property int $id
 * @property string $name
 * @property string|null $endpoint
 * @property string|null $description
 * @property bool $is_active
 * @property DateTimeInterface $created_at
 * @property DateTimeInterface $updated_at
 * @property int|string|null $created_by
 * @property int|string|null $updated_by
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|WebService active()
 * @method static \Modules\Sigma\Database\Factories\WebServiceFactory factory($count = null, $state = [])
 * @method static Builder<static>|WebService newModelQuery()
 * @method static Builder<static>|WebService newQuery()
 * @method static Builder<static>|WebService query()
 * @method static Builder<static>|WebService whereId($value)
 *
 * @mixin \Eloquent
 */
class WebService extends BaseModel
{
    use SushiToCsv;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'endpoint',
        'description',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Retrieve rows for Sushi driver.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        $rows = $this->getSushiRows();

        /** @var array<int, array<string, mixed>> $rows */
        return $rows;
    }

    /**
     * Scope a query to only include active services.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    protected function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the validation rules for the model.
     *
     * @return array<string, array<int, string|Rule|Unique>>
     */
    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'endpoint' => ['required', 'url', 'max:512'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean'],
        ];
    }
}
