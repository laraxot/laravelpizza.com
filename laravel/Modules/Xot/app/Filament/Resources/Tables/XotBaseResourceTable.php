<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Filament\Traits\HasXotTable;
use Webmozart\Assert\Assert;

/**
 * @property string|null $tableSearch Fornita a runtime da chi consuma HasXotTable
 *                                    in un contesto Livewire (mai dichiarata qui
 *                                    per non ricreare il conflitto di composizione
 *                                    risolto in HasXotTable).
 */
abstract class XotBaseResourceTable
{
    use HasXotTable;

    public static function configure(Table $table): Table
    {
        if (static::class === self::class) {
            throw new \LogicException('XotBaseResourceTable::configure() must be called on a concrete table class.');
        }

        $instance = app(static::class);
        Assert::isInstanceOf($instance, self::class);

        return $instance->table($table);
    }

    /**
     * @return array<string, Column>
     */
    abstract public function getTableColumns(): array;

    /**
     * La Resource proprietaria, dedotta dal namespace `{Resource}\Schemas\{Model}Form`.
     *
     * @return class-string<XotBaseResource>
     */
    public static function getResource(): string
    {
        $resource = Str::of(static::class)->before('\\Tables\\')->toString();
        Assert::classExists($resource);
        Assert::subclassOf($resource, XotBaseResource::class);

        return $resource;
    }

    /**
     * Modello delle righe mostrate (la relazione), distinto dal modello
     * dell'owner. Ridefinito DIRETTAMENTE qui, mai da un trait: vedi
     * l'incidente storico nel docblock di classe. Stesso pattern di
     * `XotBaseListRecords::getModelClass()`.
     *
     * `getRelationship()` (nativo Filament,
     * `ManageRelatedRecords::getRelationship(): Relation|Builder`) non
     * restituisce MAI una stringa — verificato via Reflection sul metodo
     * nativo. Una variante di questo metodo che trattava
     * `is_string($relationship)` come caso possibile e' stata reintrodotta
     * piu' volte lo stesso giorno da sessioni concorrenti: oltre a essere
     * morta, lasciava il caso reale `Builder` (non `Relation`) senza
     * gestione, sempre finito nel throw. Guardia automatica in
     * `XotBaseManageRelatedRecordsRegressionTest`.
     *
     * @return class-string<Model>
     */
    public static function getModelClass(): string
    {
        $resource = static::getResource();
        $model = $resource::getModel();

        return $model;
    }
}
