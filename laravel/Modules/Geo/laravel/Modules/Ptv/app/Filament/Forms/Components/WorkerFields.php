<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Modules\Xot\Filament\Schemas\Components\XotBaseGroup;

class WorkerFields extends XotBaseGroup
{
    protected string $matrFieldName = 'matr';

    protected string $cognomeFieldName = 'cognome';

    protected string $nomeFieldName = 'nome';

    protected string $emailFieldName = 'email';

    protected bool|Closure $isDisabled = false;

    protected bool $isRequired = false;

    protected int $gridColumnCount = 4;

    public function matrField(string $fieldName): static
    {
        $this->matrFieldName = $fieldName;

        $this->refreshSchema();

        return $this;
    }

    public function cognomeField(string $fieldName): static
    {
        $this->cognomeFieldName = $fieldName;

        $this->refreshSchema();

        return $this;
    }

    public function nomeField(string $fieldName): static
    {
        $this->nomeFieldName = $fieldName;

        $this->refreshSchema();

        return $this;
    }

    public function emailField(string $fieldName): static
    {
        $this->emailFieldName = $fieldName;

        $this->refreshSchema();

        return $this;
    }

    public function disabled(bool|Closure $condition = true): static
    {
        $this->isDisabled = $condition;

        $this->refreshSchema();

        return $this;
    }

    public function required(bool $condition = true): static
    {
        $this->isRequired = $condition;

        $this->refreshSchema();

        return $this;
    }

    public function gridColumns(int $columns): static
    {
        $this->gridColumnCount = $columns;
        $this->refreshSchema();

        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshSchema();
    }

    protected function refreshSchema(): void
    {
        $this->schema([
            Grid::make($this->gridColumnCount)->schema([
                TextInput::make($this->matrFieldName)
                    ->disabled($this->isDisabled)
                    ->required($this->isRequired),
                TextInput::make($this->cognomeFieldName)
                    ->disabled($this->isDisabled)
                    ->required($this->isRequired),
                TextInput::make($this->nomeFieldName)
                    ->disabled($this->isDisabled)
                    ->required($this->isRequired),
                TextInput::make($this->emailFieldName)
                    ->disabled($this->isDisabled)
                    ->required($this->isRequired),
            ]),
        ]);
    }
}
