<?php

declare(strict_types=1);

namespace Modules\User\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\User\Filament\Forms\Components\UserSection;

/**
 * Controparte in lista di {@see UserSection}.
 *
 * Stessi campi anagrafici (`first_name`, `last_name`, `email`), due superfici: il form li edita,
 * la tabella li mostra raggruppati.
 *
 * Usage:
 * ```php
 * 'user' => UserColumn::make(),
 * ```
 *
 * @see Modules/User/docs/form-column-parity.md
 */
class UserColumn extends GroupColumn
{
    protected const string DEFAULT_NAME = 'user';

    /**
     * @return array<string, Column>
     */
    protected static function getSchema(): array
    {
        return [
            'first_name' => TextColumn::make('first_name'),
            'last_name' => TextColumn::make('last_name'),
            'email' => TextColumn::make('email'),
        ];
    }

    public static function make(?string $name = null): static
    {
        $columns = static::getSchema();
        $searchable = array_keys($columns);

        /** @var array<int, Column> $validatedColumns */
        $validatedColumns = array_values($columns);

        return parent::make($name ?? static::DEFAULT_NAME)
            ->schema($validatedColumns)
            ->searchable($searchable);
    }
}
