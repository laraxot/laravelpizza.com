<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;

/**
 * RepColumn - Custom column for reparto (department) information
 *
 * Provides a grouped column displaying department details including:
 * - stabilimento (stabi)
 * - descrizione stabilimento (stabi_txt)
 * - reparto (repar)
 * - descrizione reparto (repar_txt)
 *
 * Usage:
 * ```php
 * RepColumn::make('reparto')
 * ```
 */
class RepColumn extends GroupColumn
{
    /**
     * @var array<string, Column>
     */
    protected array $extraColumns = [];

    /**
     * Get the default schema for department information
     *
     * @return array<string, Column>
     */
    protected static function getSchema(): array
    {
        return [
            'stabi' => TextColumn::make('stabi')
                ->label('Stabilimento')
                ->sortable()
                ->searchable(),
            'stabi_txt' => TextColumn::make('stabi_txt')
                ->label('Descrizione Stabilimento')
                ->sortable()
                ->searchable(),
            'repar' => TextColumn::make('repar')
                ->label('Reparto')
                ->sortable()
                ->searchable(),
            'repar_txt' => TextColumn::make('repar_txt')
                ->label('Descrizione Reparto')
                ->sortable()
                ->searchable(),
        ];
    }

    /**
     * Create a new RepColumn instance
     */
    public static function make(?string $name = null): static
    {
        $columns = static::getSchema();
        $searchable = array_keys($columns);

        /** @var array<int, Column> $validatedColumns */
        $validatedColumns = array_values(array_filter($columns, static fn ($col): bool => $col instanceof Column));

        // @phpstan-ignore-next-line - GroupColumn is final but needs to be extended
        return parent::make($name)
            ->label('Reparto')
            ->schema($validatedColumns)
            ->searchable($searchable);
    }

    /**
     * Append additional columns to the department schema
     *
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
}
