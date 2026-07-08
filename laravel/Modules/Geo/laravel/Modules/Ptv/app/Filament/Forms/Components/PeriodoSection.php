<?php

declare(strict_types=1);

/*
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Ptv\Filament\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class PeriodoSection extends Section
{
    /** @var array<string, TextInput|TextEntry> */
    public array $add = [];

    public static function getDefaultName(): ?string
    {
        return 'PeriodoSection';
    }

    /**
     * @param  array<string, TextInput|TextEntry>  $array
     */
    public function add(array $array): self
    {
        $this->add = array_merge($this->add, $array);

        return $this;
    }

    /**
     * @return array<string, TextInput|TextEntry>
     */
    public function getSchema(): array
    {
        return [
            'dal' => TextInput::make('dal'),
            'al' => TextInput::make('al'),
            'anno' => TextInput::make('anno'),
            ...$this->add,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            Grid::make(4)->schema($this->getSchema()),
        ]);
    }
}
