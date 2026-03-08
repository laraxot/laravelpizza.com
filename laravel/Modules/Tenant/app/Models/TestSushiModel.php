<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use InvalidArgumentException;
use Modules\Tenant\Contracts\SushiToJsonContract;
use Modules\Tenant\Database\Factories\TestSushiModelFactory;
use Modules\Tenant\Models\Traits\SushiToJson;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
 * Modello di test per il trait SushiToJson.
 *
 * Utilizzato esclusivamente per i test del trait.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $status
 * @property array<array-key, mixed>|null $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static TestSushiModelFactory factory($count = null, $state = [])
 * @method static Builder<static>|TestSushiModel newModelQuery()
 * @method static Builder<static>|TestSushiModel newQuery()
 * @method static Builder<static>|TestSushiModel query()
 * @method static Builder<static>|TestSushiModel whereCreatedAt($value)
 * @method static Builder<static>|TestSushiModel whereDescription($value)
 * @method static Builder<static>|TestSushiModel whereId($value)
 * @method static Builder<static>|TestSushiModel whereMetadata($value)
 * @method static Builder<static>|TestSushiModel whereName($value)
 * @method static Builder<static>|TestSushiModel whereStatus($value)
 * @method static Builder<static>|TestSushiModel whereUpdatedAt($value)
 *
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 *
 * @mixin \Eloquent
 */
class TestSushiModel extends BaseModel implements SushiToJsonContract
{
    use HasXotFactory;
    use SushiToJson;

    /**
     * Schema esplicito per Sushi quando non ci sono righe.
     *
     * @var array<string, string>
     */
    protected $form = [
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

    /**
     * La tabella associata al modello.
     */
    protected $table = 'test_sushi';

    /**
     * Nota: non esporre i metodi protetti del trait.
     * I metodi del trait vengono utilizzati internamente dagli eventi Eloquent.
     */

    /**
     * Gli attributi che sono assegnabili in massa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'metadata',
        'created_by',
        'updated_by',
    ];

    /**
     * Override del path JSON in ambiente di test per NON toccare config/local/<nome progetto>/.
     */
    public function getJsonFile(): string
    {
        $tbl = // @var mixed getTable(;
        /** @var class-string $tenantService */
        $tenantService = TenantService::class;

        $filePath = $tenantService::filePath('database/content/'.$tbl.'.json');
        if (! is_string($filePath)) {
            throw new InvalidArgumentException('File path must be string');
        }

        return $filePath;
    }

    /**
     * Implementa il metodo getRows() richiesto da Sushi.
     * Delega al metodo getSushiRows() del trait.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return // @var mixed getSushiRows(;
    }

    /**
     * Gli attributi che devono essere convertiti.
     *
     * @return array<string, string>
     */
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
