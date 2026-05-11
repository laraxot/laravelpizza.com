<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRelatedRecords as FilamentManageRelatedRecords;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Traits\HasXotForm;
use Modules\Xot\Filament\Traits\HasXotTable;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;

/**
 * Base page for Filament related-record managers.
 */
abstract class XotBaseManageRelatedRecords extends FilamentManageRelatedRecords
{
    use HasXotForm;
    use HasXotTable;
    use NavigationLabelTrait {
        NavigationLabelTrait::trans as traitTrans;
    }

    protected static string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): string
    {
        return '';
    }

    public function getTitle(): string
    {
        return static::transFunc(__FUNCTION__).' - '.$this->getRecordTitle();
    }

    public function getRecordTitle(): string
    {
        $value = $this->record->{static::$recordTitleAttribute};

        return (string) $value;
    }

    public function schema(Schema $schema): Schema
    {
        return $schema->components($this->getFormSchema());
    }

    /**
     * @return array<Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    public static function getNavigationLabel(): string
    {
        return static::transFunc(__FUNCTION__);
    }

    protected function getTableHeading(): Htmlable|string|null
    {
        return $this->getTableHeadingFromTrait();
    }

    /**
     * @return array<string, TextColumn>
     */
    #[\Override]
    protected function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->label('ID')->sortable(),
            'name' => TextColumn::make('name')
                ->label('Nome')
                ->searchable()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->label('Data Creazione')
                ->dateTime('d/m/Y H:i')
                ->sortable(),
        ];
    }

    /**
     * @return array<string, Action>
     */
    protected function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make()->label('Crea Nuovo')->disableCreateAnother(),
        ];
    }

    /**
     * @return array<string, Action>
     */
    protected function getTableActions(): array
    {
        return [];
    }

    private function getTableHeadingFromTrait(): ?string
    {
        $key = static::getKeyTrans('table.heading');
        $trans = trans($key);

        return is_string($trans) && $trans !== $key ? $trans : null;
    }
}
