<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\ReportResource\Widgets;

use Error;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Modules\Sigma\Models\Repart;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * @property Schema $form
 */
class FirmaStabiReparWidget extends XotBaseWidget
{
    // Temporarily removed InteractsWithPageFilters due to trait collision

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    protected string $view = 'ptv::filament.widgets.firma_stabi_repar';

    protected int|string|array $columnSpan = 'full';

    public string $resource = '';

    public array $listener = [
        'filters-updated' => 'filtersUpdated',
    ];

    public function mount(): void
    {
        // Initialize widget data
        $this->data = [];
    }

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [
            'form_grid' => Grid::make(2)
                ->schema([
                    'stabi_diri_id' => Hidden::make('stabi_diri_id'),
                    'nome_stabi' => TextInput::make('nome_stabi')
                        ->required(),
                    'nome_diri' => TextInput::make('nome_diri')
                        ->required(),
                ]),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            /** @var array<string, mixed> $data */
            $data = $this->form->getState();
            if (! array_key_exists('stabi_diri_id', $data)) {
                throw new Halt('Missing stabi_diri_id in form state');
            }
            $stabi_repar_class = Str::of($this->resource)->before('\\Filament\\')->append('\\Models\\StabiDirigente')->toString();
            $stabi_repar = $stabi_repar_class::firstWhere(['id' => $data['stabi_diri_id']]);

            if (! $stabi_repar instanceof Model) {
                throw new Halt('StabiDirigente model not found');
            }

            $stabi_repar->update($data);
        } catch (Halt $exception) {
            Notification::make()
                ->title('Error !')
                ->body($exception->getMessage())
                ->danger()
                ->send();

            return;
        } catch (Error $exception) {
            Notification::make()
                ->title('Error !')
                ->body($exception->getMessage())
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }

    public function areFormActionsSticky(): bool
    {
        return false;
    }

    public function getFormActionsAlignment(): string|Alignment
    {
        return Alignment::Start;
    }

    /**
     * @param  array<string, mixed>|null  $filters
     */
    #[On('filters-updated')]
    public function filtersUpdated(?array $filters = []): void
    {
        $filters = $filters ?: $this->pageFilters ?? [];

        if ($filters === []) {
            return;
        }

        // $this->filters=array_merge($this->filters ?? [],$filters);
        // $livewire->tableFilters

        $data = [];
        /*
        $profile = XotData::make()->getProfileModel();
        if(isset($filters['stabi'])){
            $data['stabi']=$profile?->teams?->firstWhere('id',$filters['stabi'])?->name;
        }
        */
        // Type narrowing: ensure filters is array with required keys
        if (! is_array($filters)) {
            return;
        }

        /** @var array<string, mixed> $filtersTyped */
        $filtersTyped = $filters;
        // Type narrowing: ensure required keys exist before access
        if (isset($filtersTyped['stabi']) && isset($filtersTyped['repar']) && isset($filtersTyped['anno'])) {
            /*
            $data['repar']=Repart::firstWhere([
                'ente'=>90,
                'stabi'=> $filters['stabi'],
                'repar'=>  $filters['repar'],
            ])->dest1;
            */
            // dddx($this->resource); // => Modules\Performance\Filament\Resources\IndividualeRegionaleResource
            $stabi_repar_class = Str::of($this->resource)->before('\\Filament\\')->append('\\Models\\StabiDirigente')->toString();
            if (! class_exists($stabi_repar_class)) {
                return;
            }
            /** @var class-string<Model> $stabiReparClass */
            $stabiReparClass = $stabi_repar_class;
            // Type narrowing: ensure filters array has required keys with correct types
            $stabiValue = isset($filtersTyped['stabi']) && (is_int($filtersTyped['stabi']) || is_string($filtersTyped['stabi'])) ? $filtersTyped['stabi'] : null;
            $reparValue = isset($filtersTyped['repar']) && (is_int($filtersTyped['repar']) || is_string($filtersTyped['repar'])) ? $filtersTyped['repar'] : null;
            $annoValue = isset($filtersTyped['anno']) && (is_int($filtersTyped['anno']) || is_string($filtersTyped['anno'])) ? $filtersTyped['anno'] : null;
            /** @var array<string, mixed> $whereAttributes */
            $whereAttributes = [
                'stabi' => $stabiValue,
                'repar' => $reparValue,
                'anno' => $annoValue,
            ];
            /** @var Model|null $stabi_repar */
            $stabi_repar = $stabiReparClass::firstOrCreate($whereAttributes);
            if ($stabi_repar instanceof Model) {
                $id = isset($stabi_repar->id) && is_numeric($stabi_repar->id) ? (int) $stabi_repar->id : null;
                $nomeStabi = isset($stabi_repar->nome_stabi) && is_string($stabi_repar->nome_stabi) ? $stabi_repar->nome_stabi : '';
                $nomeDiri = isset($stabi_repar->nome_diri) && is_string($stabi_repar->nome_diri) ? $stabi_repar->nome_diri : '';
                if ($id !== null) {
                    $data['stabi_diri_id'] = $id;
                }
                if ($nomeStabi !== '') {
                    $data['nome_stabi'] = $nomeStabi;
                }
                if ($nomeDiri !== '') {
                    $data['nome_diri'] = $nomeDiri;
                }
            }
        }

        // dddx($this->tableFilters);

        $this->form->fill($data);
    }
}
