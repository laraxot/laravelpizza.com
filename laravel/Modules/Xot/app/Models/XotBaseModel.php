<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Models\Traits\RelationX;
use Modules\Xot\Traits\Updater;
use Webmozart\Assert\Assert;

/**
 * @method static \Illuminate\Database\Eloquent\Factories\Factory<static> factory($count = null, $state = [])
 *
 * Class XotBaseModel.
 */
abstract class XotBaseModel extends EloquentModel
{
    use HasXotFactory;
    use RelationX;
    use Updater;

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @see https://laravel-news.com/6-eloquent-secrets
     *
     * @var bool
     */
    public static $snakeAttributes = true;

    /** @var int */
    protected $perPage = 30;

    /** @var string */
    protected $connection = 'xot';

    /** @var list<string> */
    protected $appends = [];

    /** @var list<string> */
    protected $hidden = [
        // 'password'
    ];

    /**
     * Risolve il concreto del **modulo chiamante** mantenendo il basename di `static`.
     *
     * Il namespace non viene dedotto da `static` (che resta sul prototype del modulo
     * base, es. `Ptv\Models\CriteriOption`) ma dall'**oggetto chiamante** trovato nel
     * backtrace: una `Scheda` di Progressioni che invoca `CriteriOption::getClassName()`
     * ottiene `Progressioni\Models\CriteriOption`. Per questo la chiamata è
     * `CriteriOption::getClassName()` senza argomenti e senza `static::`.
     *
     * Funziona anche dai contesti Filament (`Filament\Resources\`), dove il modello
     * viene risolto via `getModelClass()` dell'oggetto chiamante.
     *
     * @return class-string<EloquentModel>
     */
    public static function getClassName(): string
    {
        $object = Arr::first(debug_backtrace(), function (array $value) {
            return isset($value['object'])
            && (Str::contains($value['object']::class, 'Models\\') || Str::contains($value['object']::class, 'Filament\\Resources\\'));
        });

        if (! isset($object['object'])) {
            throw new \RuntimeException('Unable to resolve caller object for getClassName()');
        }

        $objectClass = $object['object']::class;
        if (method_exists($object['object'], 'getModelClass')) {
            $objectClass = $object['object']->getModelClass();
        }
        Assert::string($objectClass);
        /** @var string $objectClass */
        $namespace = Str::beforeLast((string) $objectClass, '\Models\\');
        $className = Str::afterLast(static::class, '\\');

        $res = $namespace.'\\Models\\'.$className;
        Assert::classExists($res);
        Assert::subclassOf($res, EloquentModel::class);

        return $res;
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'published_at' => 'datetime',
            'verified_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}
