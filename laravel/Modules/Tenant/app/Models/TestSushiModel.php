<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Models\Contracts\HasSushiToJson;
use Modules\Tenant\Models\Traits\SushiToJson;
use Webmozart\Assert\Assert;

use function Safe\json_decode;
use function Safe\json_encode;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $status
 * @property array<array-key, mixed>|null $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @method static \Modules\Tenant\Database\Factories\TestSushiModelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestSushiModel whereUpdatedBy($value)
 *
 */
class TestSushiModel extends BaseModel implements HasSushiToJson
{
    use SushiToJson;

    /**
     * @var array<string, string>
     */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'status' => 'string',
        'metadata' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    protected $table = 'test_sushi';

    protected $fillable = [
        'name',
        'description',
        'status',
        'metadata',
        'created_by',
        'updated_by',
    ];

    public function getJsonFile(): string
    {
        if (app()->environment('testing')) {
            $dir = storage_path('tests/sushi-json');
            if (! File::exists($dir)) {
                File::makeDirectory($dir, 0o755, true, true);
            }

            return $dir.'/test_sushi.json';
        }

        // fallback: usa il comportamento del trait (replicato qui)
        return app(GetTenantFilePathAction::class)->execute('database/content/'.$this->getTable().'.json');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    /**
     * @return array<string, mixed>
     */
    public function loadExistingData(): array
    {
        $path = $this->getJsonFile();

        if (! File::exists($path)) {
            return [];
        }

        $content = File::get($path);
        $data = json_decode($content, true);
        Assert::isArray($data);

        /** @var array<string, mixed> $data */
        return $data;
    }

    /**
     * @param  array<int|string, array<string, mixed>>  $data
     */
    public function saveToJson(array $data): bool
    {
        $path = $this->getJsonFile();

        File::put($path, json_encode($data, JSON_PRETTY_PRINT));

        return true;
    }

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'created_by' => 'integer',
            'updated_by' => 'integer',
        ];
    }
}
