<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;

class QualificaColumn extends GroupColumn
{
    /**
     * @var array<string, Column>
     */
    protected array $extraColumns = [];

    public static function make(?string $name = null): static
    {
        $columns = static::getSchema();
        $searchable = array_keys($columns);

        /** @var array<int, Column> $validatedColumns */
        $validatedColumns = array_values(array_filter($columns, static fn ($col): bool => $col instanceof Column));

        // @phpstan-ignore-next-line - GroupColumn is final but needs to be extended
        return parent::make($name)
            ->schema($validatedColumns)
            ->searchable($searchable);
    }

    /**
     * @param  array<string, Column>  $columns
     */
    public function appendColumns(array $columns): static
    {
        $this->extraColumns = array_merge($this->extraColumns, $columns);

        $form = array_merge(
            static::getSchema(),
            $this->extraColumns
        );

        // @phpstan-ignore-next-line
        return $this->schema($form);
    }

    /**
     * @return array<string, Column>
     */
    protected static function getSchema(): array
    {
        return [
            'propro' => TextColumn::make('propro'),
            'posfun' => TextColumn::make('posfun'),
            'categoria_eco' => TextColumn::make('categoria_eco'),
            'categoria_ecoval' => TextColumn::make('categoria_ecoval'),
            'posfunval' => TextColumn::make('posfunval'),
            'posiz' => TextColumn::make('posiz'),
            'posiz_txt' => TextColumn::make('posiz_txt'),
            'disci1' => TextColumn::make('disci1'),
            'disci1_txt' => TextColumn::make('disci1_txt'),
            // 'codqua' => TextColumn::make('codqua'),
            // 'codqua_txt' => TextColumn::make('codqua_txt'),
        ];
    }
}
