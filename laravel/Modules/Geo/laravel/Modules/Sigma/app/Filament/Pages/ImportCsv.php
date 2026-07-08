<?php

declare(strict_types=1);

namespace Modules\Sigma\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Modules\Xot\Actions\Import\ImportCsvAction;
use Modules\Xot\Filament\Pages\XotBasePage;

class ImportCsv extends XotBasePage
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-arrow-up';

    protected string $view = 'sigma::filament.pages.sql-upload';

    /** @var Schema */
    public $form;

    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            'db' => TextInput::make('db')->default('generale')->required(),
            'tbl' => TextInput::make('tbl')->required(),
            'disk' => TextInput::make('disk')->default('cache')->required(),
            'path' => TextInput::make('path')->default('PTV_Asz00f.csv')->required(),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        app(ImportCsvAction::class)->execute(
            (string) $data['disk'],
            (string) $data['path'],
            (string) $data['db'],
            (string) $data['tbl'],
        );
    }
}
