<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;

/**
 * QuaColumn - Custom column for qualification (qualifica) information
 *
 * Provides a grouped column displaying qualification details including:
 * - profilo professionale (propro)
 * - posizione funzionale (posfun)
 * - categoria economica (categoria_eco)
 * - categoria economica valutata (categoria_ecoval)
 * - posizione funzionale valutata (posfunval)
 * - posizione (posiz)
 * - descrizione posizione (posiz_txt)
 * - disciplina (disci1)
 * - descrizione disciplina (disci1_txt)
 *
 * Usage:
 * ```php
 * QuaColumn::make('qualifica')
 * ```
 */
class QuaColumn extends GroupColumn
{
    /**
     * @var array<string, Column>
     */
    protected array $extraColumns = [];

    /**
     * Get the default schema for qualification information
     *
     * @return array<string, Column>
     */
    protected static function getSchema(): array
    {
        return [
            'propro' => TextColumn::make('propro')
                ->label('Profilo Professionale')
                ->sortable()
                ->searchable(),
            'posfun' => TextColumn::make('posfun')
                ->label('Posizione Funzionale')
                ->sortable()
                ->searchable(),
            'categoria_eco' => TextColumn::make('categoria_eco')
                ->label('Categoria Economica')
                ->sortable()
                ->searchable(),
            'categoria_ecoval' => TextColumn::make('categoria_ecoval')
                ->label('Categoria Eco. Valutata')
                ->sortable()
                ->searchable(),
            'posfunval' => TextColumn::make('posfunval')
                ->label('Pos. Funz. Valutata')
                ->sortable()
                ->searchable(),
            'posiz' => TextColumn::make('posiz')
                ->label('Posizione')
                ->sortable()
                ->searchable(),
            'posiz_txt' => TextColumn::make('posiz_txt')
                ->label('Descrizione Posizione')
                ->sortable()
                ->searchable(),
            'disci1' => TextColumn::make('disci1')
                ->label('Disciplina')
                ->sortable()
                ->searchable(),
            'disci1_txt' => TextColumn::make('disci1_txt')
                ->label('Descrizione Disciplina')
                ->sortable()
                ->searchable(),
        ];
    }

    /**
     * Create a new QuaColumn instance
     */
    public static function make(?string $name = null): static
    {
        $columns = static::getSchema();
        $searchable = array_keys($columns);

        /** @var array<int, Column> $validatedColumns */
        $validatedColumns = array_values(array_filter($columns, static fn ($col): bool => $col instanceof Column));

        // @phpstan-ignore-next-line - GroupColumn is final but needs to be extended
        return parent::make($name)
            ->label('Qualifica')
            ->schema($validatedColumns)
            ->searchable($searchable);
    }

    /**
     * Append additional columns to the qualification schema
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
