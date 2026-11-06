<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

/**
 * La tabella del model ha questa colonna? Controllo dello schema con cache per processo
 * (connection.tabella.colonna): lo usano le Table (HasXotTable::hasColumn) e i componenti
 * Filament riutilizzabili che si nascondono da soli dove la colonna non c'e' (es. le date
 * dell'esperienza in QualificaSection/QualificaColumn, presenti solo su progressione.schede).
 */
class ModelHasColumnAction
{
    use QueueableAction;

    /**
     * Esito di `Schema::hasColumn()` per connessione.tabella.colonna, valido per la durata del processo.
     * Senza, ogni costruzione di tabella (lista, relation manager, ogni update Livewire) lancia una query
     * su `information_schema.columns` per sapere se esiste `order_column`. Lo schema cambia solo con una
     * migrazione, quindi non serve rileggerlo a ogni richiesta. (Spostato da HasXotTable il 2026-11-05.)
     *
     * @var array<string, bool>
     */
    private static array $cache = [];

    /**
     * Model, nome di classe o null (componente non ancora legato a un model): una classe che non e'
     * un model Eloquent risponde false, non eccezione.
     */
    public function execute(Model|string|null $model, string $column): bool
    {
        if (is_string($model)) {
            if (! is_a($model, Model::class, true)) {
                return false;
            }
            $model = new $model;
        }
        if (! $model instanceof Model) {
            return false;
        }
        $instance = $model;
        $key = $instance->getConnectionName().'.'.$instance->getTable().'.'.$column;

        return self::$cache[$key] ??= $instance->getConnection()
            ->getSchemaBuilder()
            ->hasColumn($instance->getTable(), $column);
    }
}
