<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;

class GroupColumn extends Column
{
    public array $form = [];

    /**
     * @var array<Column>
     */
    protected array $schema = [];

    protected string $view = 'ui::filament.tables.columns.group';

    /**
     * Initialize the component.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Component initialization logic
    }

    public function getFields(): array
    {
        /* @var array<string, mixed> */
        return $this->schema;
    }

    /**
     * @param  array<int|string, mixed>  $form
     */
    public function schema(array $form): self
    {
        // Type-check to ensure all elements are Column instances
        $filtered = array_filter($form, function (mixed $item): bool {
            return $item instanceof Column;
        });

        /** @var array<int|string, Column> $filtered */
        /** @var array<int, Column> $filteredValues */
        $filteredValues = array_values($filtered);
        $this->schema = $filteredValues;

        return $this;
    }
}
