<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Modules\Xot\Filament\Tables\Columns\XotBaseColumn;

/**
 * Groups multiple Filament columns in one cell.
 *
 * Child columns must be mounted to the same Table as this GroupColumn —
 * otherwise getState() / toEmbeddedHtml() throw
 * "The column [x] is not mounted to a table".
 */
class GroupColumn extends XotBaseColumn
{
    /** @var array<int|string, mixed> */
    public array $form = [];

    /**
     * @var array<Column>
     */
    protected array $schema = [];

    protected string $view = 'ui::filament.tables.columns.group';

    /**
     * @return array<Column>
     */
    public function getFields(): array
    {
        return $this->schema;
    }

    /**
     * @param  array<int|string, mixed>  $form
     */
    public function schema(array $form): static
    {
        $filtered = array_filter($form, static function (mixed $item): bool {
            return $item instanceof Column;
        });

        /** @var array<int, Column> $filteredValues */
        $filteredValues = array_values($filtered);
        $this->schema = $filteredValues;

        $this->mountChildrenToTable($this->table);

        return $this;
    }

    public function table(?Table $table): static
    {
        parent::table($table);
        $this->mountChildrenToTable($table);

        return $this;
    }

    private function mountChildrenToTable(?Table $table): void
    {
        if ($table === null) {
            return;
        }

        foreach ($this->schema as $child) {
            $child->table($table);
        }
    }
}
