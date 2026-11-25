<?php

declare(strict_types=1);
/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Xot\Filament\Actions\Table;

use Exception;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Xot\Actions\Export\ExportXlsByCollection;
use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Webmozart\Assert\Assert;

class ExportXlsTableAction extends XotBaseAction
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->translateLabel()
            ->tooltip(__('xot::actions.export_xls'))
            // ->icon('fas-file-excel')
            ->icon('xot-files.xls')
            ->action(static function (RelationManager $livewire) {
                $livewireClass = $livewire::class;
                $filterParts = array_map(
                    static fn (mixed $value): string => is_scalar($value) ? (string) $value : '',
                    Arr::flatten($livewire->tableFilters ?? []),
                );
                $filename =
                    class_basename($livewire).
                    '-'.
                    implode('-', $filterParts).
                    '.xlsx';
                $transKey = app(GetTransKeyAction::class)->execute($livewireClass);
                $transKey .= '.fields';
                $query = $livewire->getFilteredTableQuery();
                if ($query === null) {
                    throw new Exception('Query is null');
                }
                // ->getQuery(); // Staudenmeir\LaravelCte\Query\Builder
                /** @var Builder<Model> $eloquentQuery */
                $eloquentQuery = $query;
                $rows = $eloquentQuery->get();
                $fields = self::resolveXlsFields($livewireClass, $livewire->tableFilters);

                return app(ExportXlsByCollection::class)->execute($rows, $filename, $transKey, $fields);
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'export_xls';
    }

    /**
     * Chiave stringa = percorso data_get con intestazione esplicita
     * (title rating); chiave intera = percorso tradotto via transKey.
     *
     * @param  class-string  $livewireClass
     * @param  array<string, mixed>|null  $tableFilters
     * @return array<int|string, string>
     */
    private static function resolveXlsFields(string $livewireClass, ?array $tableFilters): array
    {
        $fields = [];
        if (! method_exists($livewireClass, 'getXlsFields')) {
            return $fields;
        }
        $rawFields = $livewireClass::getXlsFields($tableFilters);
        Assert::isArray($rawFields);

        foreach ($rawFields as $key => $field) {
            if (is_string($key) && is_string($field)) {
                $fields[$key] = $field;
            } elseif (is_string($field)) {
                $fields[] = $field;
            } elseif (is_array($field) && isset($field['name']) && is_string($field['name'])) {
                $fields[] = $field['name'];
            }
        }

        return $fields;
    }
}
