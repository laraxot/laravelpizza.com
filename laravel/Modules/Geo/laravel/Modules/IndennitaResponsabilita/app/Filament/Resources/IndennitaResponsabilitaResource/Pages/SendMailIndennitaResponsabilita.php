<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Filament\Forms\Components\TextInput;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

class SendMailIndennitaResponsabilita extends XotBasePage
{
    // use HasRelationManagers;
    // use InteractsWithRecord;

    /** @var array<string, mixed> */
    public array $tableFilters = [];

    protected static string $resource = IndennitaResponsabilitaResource::class;

    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.send-mail';

    public function __construct()
    {
        // dddx('a');
    }

    public function mount(): void
    {
        $data = request()->all();
        if (isset($data['anno/valutatore']) && is_array($data['anno/valutatore'])) {
            // Type narrowing: ensure $data['anno/valutatore'] is array<string, mixed>
            /** @var array<string, mixed> $tableFiltersData */
            $tableFiltersData = $data['anno/valutatore'];
            $this->tableFilters = $tableFiltersData;
        }
        // dddx('b');
    }

    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required(),
        ];
    }
}
