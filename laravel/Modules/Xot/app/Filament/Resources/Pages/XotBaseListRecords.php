<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords as FilamentListRecords;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Links\RecordAnchor;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Webmozart\Assert\Assert;

/**
 * Base class for list records pages.
 *
 * La tabella NON si configura qui: la costruisce `XotBaseResource::table()` attraverso
 * `getTableClass()`, cioe' la `*Table` class della Resource. Per questo la pagina non usa
 * `HasXotTable` — un hook `getTableColumns()` scritto su una list page risolverebbe allo
 * stub deprecato di Filament e la tabella resterebbe vuota, senza errori ne' log.
 *
 * Guardie: `tests/Unit/ListPageHasTableClassTest.php` (ogni list page risolve la sua Table
 * class) e `tests/Unit/Filament/TableHooksDeclaredByUsTest.php` (nessun hook risolve allo
 * stub Filament). Regola: `laravel/docs/wiki/rules/xot-table-method-names.md`.
 *
 * @property ?string $model
 * @property ?string $resource
 * @property ?string $slug
 */
abstract class XotBaseListRecords extends FilamentListRecords
{
    /**
     * @param  array<string, bool|float|int|string|null>  $params
     */
    public static function trans(string $key, array $params = []): string
    {
        $resourceClass = static::getResource();

        return $resourceClass::trans($key, false, $params);
    }

    /**
     * Get the resource class name.
     *
     * @return class-string<XotBaseResource>
     */
    public static function getResource(): string
    {
        $resource = Str::of(static::class)->before('\\Pages\\')->toString();
        Assert::classExists($resource);
        Assert::subclassOf($resource, XotBaseResource::class);

        return $resource;
    }

    public static function getModelClass(): string
    {
        $resource = static::getResource();
        $model = $resource::getModel();

        return $model;
    }

    public static function getModuleName(): string
    {
        return Str::of(static::class)->between('Modules\\', '\Filament\\')->toString();
    }

    /**
     * Get the header actions.
     *
     * @return array<string, Action|ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make()
                ->icon('heroicon-o-plus')
                ->url(fn (): string => RecordAnchor::appendReturnTo(
                    static::getResource()::getUrl('create'),
                    RecordAnchor::currentUrl(),
                )),
        ];
    }

    /**
     * DEVE ESSERE FINAL
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
     */
    public function getTableColumns(): array
    {
        return [];
    }

    /**
     * DEVE ESSERE FINAL
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
     */
    public function getTableActions(): array
    {
        return [];
    }

    /**
     * DEVE ESSERE FINAL
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
     */
    public function getTableFilters(): array
    {
        return [];
    }

    /**
     * DEVE ESSERE FINAL
     *
     * @not-deprecated Hook di progetto, non il metodo deprecato omonimo di Filament.
     */
    public function getTableBulkActions(): array
    {
        return [];
    }
}
