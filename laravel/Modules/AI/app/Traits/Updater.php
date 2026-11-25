<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Datas\XotData;

/**
 * Trait Updater.
 * https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 *
 * @property int|null $created_by ID dell'utente che ha creato il record
 * @property int|null $updated_by ID dell'utente che ha aggiornato il record
 * @property int|null $deleted_by ID dell'utente che ha eliminato il record
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 */
trait Updater
{
    /**
     * Get the user who created the model.
     *
     * @return BelongsTo<Model&ProfileContract, $this>
     *
     * @phpstan-return BelongsTo<Model&ProfileContract, $this>
     */
    public function creator(): BelongsTo
    {
        /** @var class-string<ProfileContract&Model> $profileClass */
        $profileClass = XotData::make()->getProfileClass();

        return $this->belongsTo($profileClass, 'created_by', 'user_id');
    }

    /**
     * Get the last user who updated the model.
     *
     * @return BelongsTo<Model&ProfileContract, $this>
     *
     * @phpstan-return BelongsTo<Model&ProfileContract, $this>
     */
    public function updater(): BelongsTo
    {
        /** @var class-string<ProfileContract&Model> $profileClass */
        $profileClass = XotData::make()->getProfileClass();

        return $this->belongsTo($profileClass, 'updated_by', 'user_id');
    }

    /**
     * Get the user who deleted the model.
     *
     * @return BelongsTo<Model&ProfileContract, $this>
     *
     * @phpstan-return BelongsTo<Model&ProfileContract, $this>
     */
    public function deleter(): BelongsTo
    {
        /** @var class-string<ProfileContract&Model> $profileClass */
        $profileClass = XotData::make()->getProfileClass();

        return $this->belongsTo($profileClass, 'deleted_by', 'user_id');
    }

    /**
     * Imposta created_by/updated_by/deleted_by con l'utente autenticato.
     *
     * In creazione gli attributi del modello contengono solo i campi valorizzati, quindi
     * la presenza della colonna si chiede allo schema (una volta per tabella e connessione).
     * In eliminazione logica deleted_by va salvato prima: il soft delete aggiorna solo
     * deleted_at/updated_at e scarterebbe l'attributo.
     */
    protected static function bootUpdater(): void
    {
        static::creating(static function (Model $model): void {
            foreach (['created_by', 'updated_by'] as $column) {
                if ($model->getAttribute($column) === null && self::updaterHasColumn($model, $column)) {
                    $model->setAttribute($column, authId());
                }
            }
        });

        static::updating(static function (Model $model): void {
            if (self::updaterHasColumn($model, 'updated_by')) {
                $model->setAttribute('updated_by', authId());
            }
        });

        static::deleting(static function (Model $model): void {
            if (! self::updaterHasColumn($model, 'deleted_by')) {
                return;
            }

            $model->setAttribute('deleted_by', authId());

            $isSoftDelete = method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting();
            if ($isSoftDelete && $model->exists) {
                $model->saveQuietly();
            }
        });
    }

    private static function updaterHasColumn(Model $model, string $column): bool
    {
        /** @var array<string, bool> $cache */
        static $cache = [];

        $key = ($model->getConnectionName() ?? 'default').'.'.$model->getTable().'.'.$column;
        if (! array_key_exists($key, $cache)) {
            $cache[$key] = array_key_exists($column, $model->getAttributes())
                || $model->getConnection()->getSchemaBuilder()->hasColumn($model->getTable(), $column);
        }

        return $cache[$key];
    }
}

// end trait Updater
