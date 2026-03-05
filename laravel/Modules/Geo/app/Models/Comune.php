<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Geo\Database\Factories\ComuneFactory;
use Modules\Tenant\Contracts\SushiToJsonContract;
use Modules\Tenant\Models\Traits\SushiToJson;
use Modules\Xot\Contracts\ProfileContract;

use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\json_decode;
use function Safe\json_encode;
use function Safe\mkdir;

/**
 * Modello per i comuni italiani con Sushi.
 *
 * Implementa il pattern Facade per fornire un'interfaccia unificata a tutti i dati geografici:
 * regioni, province, città, CAP, codici ISTAT, ecc.
 * Tutti i dati sono estratti da file JSON e gestiti tramite Sushi.
 *
 * @method string getJsonFile()
 * @method array  loadExistingData()
 * @method string authId()
 * @method void   ensureDirectoryExists()
 * @method void   saveToJson()
 * @method int    findRowIndexById(int $id)
 *
 * @property string|null                  $nome
 * @property float|null                   $codice
 * @property array<array-key, mixed>|null $zona
 * @property array<array-key, mixed>|null $regione
 * @property array<array-key, mixed>|null $provincia
 * @property string|null                  $sigla
 * @property string|null                  $codiceCatastale
 * @property array<array-key, mixed>|null $cap
 * @property int|null                     $popolazione
 * @property int|null                     $id
 * @property string|null                  $title
 * @property string|null                  $slug
 * @property string|null                  $content
 * @property string|null                  $created_at
 * @property string|null                  $updated_at
 * @property string|null                  $created_by
 * @property string|null                  $updated_by
 * @property ProfileContract|null         $creator
 * @property ProfileContract|null         $updater
 *
 * @method static Builder<static>|Comune newModelQuery()
 * @method static Builder<static>|Comune newQuery()
 * @method static Builder<static>|Comune query()
 * @method static Builder<static>|Comune whereCap($value)
 * @method static Builder<static>|Comune whereCodice($value)
 * @method static Builder<static>|Comune whereCodiceCatastale($value)
 * @method static Builder<static>|Comune whereContent($value)
 * @method static Builder<static>|Comune whereCreatedAt($value)
 * @method static Builder<static>|Comune whereCreatedBy($value)
 * @method static Builder<static>|Comune whereId($value)
 * @method static Builder<static>|Comune whereNome($value)
 * @method static Builder<static>|Comune wherePopolazione($value)
 * @method static Builder<static>|Comune whereProvincia($value)
 * @method static Builder<static>|Comune whereRegione($value)
 * @method static Builder<static>|Comune whereSigla($value)
 * @method static Builder<static>|Comune whereSlug($value)
 * @method static Builder<static>|Comune whereTitle($value)
 * @method static Builder<static>|Comune whereUpdatedAt($value)
 * @method static Builder<static>|Comune whereUpdatedBy($value)
 * @method static Builder<static>|Comune whereZona($value)
 *
 * @property ProfileContract|null $deleter
 *
 * @method static ComuneFactory factory($count = null, $state = [])
 *
 * @property int|null    $altitudine
 * @property string|null $codice_catastale
 * @property float|null  $lat
 * @property float|null  $lng
 * @property string|null $sigla_provincia
 * @property float|null  $superficie
 * @property string|null $zona_altimetrica
 *
 * @method static Builder<static>|Comune whereAltitudine($value)
 * @method static Builder<static>|Comune whereLat($value)
 * @method static Builder<static>|Comune whereLng($value)
 * @method static Builder<static>|Comune whereSiglaProvincia($value)
 * @method static Builder<static>|Comune whereSuperficie($value)
 * @method static Builder<static>|Comune whereZonaAltimetrica($value)
 *
 * @mixin \Eloquent
 */
class Comune extends BaseModel implements SushiToJsonContract
{
    use SushiToJson;

    public string $jsonDirectory = '';

    /** @var array<int, string> */
    public $translatable = [];

    /** @var list<string> */
    protected $fillable = [
        'id',
        'codice',
        'nome',
        'regione',
        'provincia',
        'sigla_provincia',
        'cap',
        'codice_catastale',
        'popolazione',
        'zona_altimetrica',
        'altitudine',
        'superficie',
        'lat',
        'lng',
    ];

    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        'slug' => 'string',
        'content' => 'string',
        'zona' => 'json',
        'provincia' => 'json',
        'regione' => 'json',
        'cap' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    public function getJsonFile(): string
    {
        return module_path('Geo', 'resources/json/comuni.json');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function loadExistingData(): array
    {
        $path = $this->getJsonFile();
        if (! file_exists($path)) {
            return [];
        }
        try {
            $data = json_decode(file_get_contents($path), true);
            if (! is_array($data)) {
                return [];
            }

            /** @var array<int, array<string, mixed>> $rows */
            $rows = [];

            foreach ($data as $row) {
                if (is_array($row)) {
                    /* @var array<string, mixed> $row */
                    $rows[] = $row;
                }
            }

            return $rows;
        } catch (\Throwable) {
            return [];
        }
    }

    public function saveToJson(array $data): bool
    {
        $file = $this->getJsonFile();
        $directory = dirname($file);
        if (! file_exists($directory)) {
            mkdir($directory, 0o755, true);
        }
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return true;
    }

    public function authId(): string
    {
        return (string) (auth()->id() ?? 'system');
    }

    public function ensureDirectoryExists(string $filePath): void
    {
        $directory = dirname($filePath);
        if (! file_exists($directory)) {
            mkdir($directory, 0o755, true);
        }
    }

    public function findRowIndexById(array $rows, int $id): ?int
    {
        foreach ($rows as $index => $row) {
            if (is_array($row) && ((int) ($row['id'] ?? 0)) === $id) {
                return (int) $index;
            }
        }

        return null;
    }

    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    /**
     * Get all regions.
     *
     * @return Collection<string>
     */
    public static function getRegioni(): Collection
    {
        /* @phpstan-ignore return.type */
        return static::all()
            ->pluck('regione')
            ->unique()
            ->sort()
            ->values();
    }

    /**
     * Get all provinces for a region.
     *
     * @return Collection<string>
     */
    public static function getProvinceByRegione(string $regione): Collection
    {
        /* @phpstan-ignore return.type */
        return static::where('regione', $regione)
            ->pluck('provincia')
            ->unique()
            ->sort()
            ->values();
    }

    /**
     * Get all comuni for a province.
     *
     * @return Collection<static>
     */
    public static function getComuniByProvincia(string $provincia): Collection
    {
        /* @phpstan-ignore return.type */
        return static::where('provincia', $provincia)->orderBy('nome')->get();
    }

    /**
     * Find a comune by name (case insensitive).
     *
     * @param string $nome The name of the comune to find (case insensitive)
     *
     * @return static|null The found comune or null if not found
     */
    public static function findByNome(string $nome): ?self
    {
        /* @phpstan-ignore return.type */
        return static::all()
            ->first(fn ($comune) => strtolower($comune->nome ?? '') === strtolower($nome));
    }

    /**
     * Find comuni by CAP code (partial match supported).
     *
     * @param string $cap The CAP code to search for
     *
     * @return Collection<static> Collection of matching comuni
     */
    public static function findByCap(string $cap): Collection
    {
        /* @phpstan-ignore return.type */
        return static::where('cap', 'like', "%{$cap}%")->get();
    }

    /**
     * Find a city by ID.
     *
     * @return array{id: int, nome: string, provincia: string, regione: string, cap: string, codice_catastale: string, popolazione: int, altitudine: int, superficie: float, lat: float, lng: float, zona_altimetrica: string}|null
     */
    public static function findComune(int $id): ?array
    {
        $comune = static::query()->where('id', $id)->first();

        /* @phpstan-ignore return.type */
        return $comune ? $comune->toArray() : null;
    }

    /**
     * Get the directory where Comune JSON files are stored.
     */
    public function getJsonDirectory(): string
    {
        return $this->jsonDirectory;
    }

    /**
     * Set the directory where Comune JSON files are stored.
     */
    public function setJsonDirectory(string $directory): void
    {
        $this->jsonDirectory = $directory;
    }

    /** @return array<string, string>     */
    #[\Override]
    protected function casts(): array
    {
        return [
            'regione' => 'array',
            'zona' => 'array',
            'provincia' => 'array',
            'cap' => 'array',
        ];
    }
}
