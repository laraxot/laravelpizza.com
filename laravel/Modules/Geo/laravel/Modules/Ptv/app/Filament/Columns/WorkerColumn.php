<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;

/**
 * WorkerColumn - Custom column for worker information
 *
 * Provides a grouped column displaying worker details including:
 * - matricola (matr)
 * - cognome (surname)
 * - nome (name)
 * - email
 *
 * Usage:
 * ```php
 * WorkerColumn::make('lavoratore')
 * ```
 */
class WorkerColumn extends GroupColumn
{
    /**
     * @var array<string, Column>
     */
    protected array $extraColumns = [];

    /**
     * Get the default schema for worker information
     *
     * @return array<string, Column>
     */
    protected static function getSchema(): array
    {
        return [
            'matr' => TextColumn::make('matr')
                ->label('Matricola')
                ->sortable()
                ->searchable(),
            'cognome' => TextColumn::make('cognome')
                ->label('Cognome')
                ->sortable()
                ->searchable(),
            'nome' => TextColumn::make('nome')
                ->label('Nome')
                ->sortable()
                ->searchable(),
            'email' => TextColumn::make('email')
                ->label('Email')
                ->sortable()
                ->searchable(),
        ];
    }

    /**
     * Create a new WorkerColumn instance
     */
    public static function make(?string $name = null): static
    {
        $columns = static::getSchema();
        $searchable = array_keys($columns);

        /** @var array<int, Column> $validatedColumns */
        $validatedColumns = array_values(array_filter($columns, static fn ($col): bool => $col instanceof Column));

        // @phpstan-ignore-next-line - GroupColumn is final but needs to be extended
        return parent::make($name)
            ->label('Lavoratore')
            ->schema($validatedColumns)
            ->searchable($searchable);
    }

    /**
     * Append additional columns to the worker schema
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
