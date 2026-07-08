<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Columns;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;

class PeriodoColumn extends GroupColumn
{
    /**
     * @var array<string, Column>
     */
    protected array $extraColumns = [];

    public static function make(?string $name = null): static
    {
        // @phpstan-ignore-next-line
        return parent::make($name)
            ->schema([
                TextColumn::make('dal'),
                TextColumn::make('al'),
                TextColumn::make('anno'),
            ]);
    }

    /**
     * @param  array<string, Column>  $columns
     */
    public function appendColumns(array $columns): static
    {
        $this->extraColumns = array_merge($this->extraColumns, $columns);

        $form = array_merge(
            $this->getSchema(),
            $this->extraColumns
        );

        // @phpstan-ignore-next-line
        return $this->schema($form);
    }

    /**
     * @return array<int, Column>
     */
    protected function getSchema(): array
    {
        return [
            TextColumn::make('dal'),
            TextColumn::make('al'),
            TextColumn::make('anno'),
        ];
    }
}
