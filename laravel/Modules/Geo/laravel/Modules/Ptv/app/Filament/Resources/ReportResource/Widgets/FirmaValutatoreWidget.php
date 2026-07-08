<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\ReportResource\Widgets;

use Error;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Override;

/**
 * @property Schema $form
 */
class FirmaValutatoreWidget extends XotBaseWidget
{
    public ?string $valutatore_id = '';

    public ?string $anno = '';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    protected string $view = 'ptv::filament.widgets.firma_valutatore';

    public string $resource = '';

    public ?Model $record = null;

    public function mount(): void
    {
        $this->filtersUpdated();
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [

            TextInput::make('nome_diri')
                ->label('Firma')
                ->required(),
        ];
    }

    /*
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }
    */

    #[Override]
    public function save(): void
    {
        try {
            /** @var array<string, mixed> $data */
            $data = $this->form->getState();

            if ($this->record instanceof Model) {
                $this->record->update($data);
            }
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

    /*
    public function areFormActionsSticky(): bool
    {
        return false;
    }

    public function getFormActionsAlignment(): string | Alignment
    {
        return Alignment::Start;
    }
    */

    /**
     * @param  array<string, mixed>  $newFilters
     */
    public function updateFilters(array $newFilters = []): void
    {
        dddx($newFilters);
    }

    /**
     * @param array<string, mixed>|null $filters
     */
    #[On('valutatoreIdUpdated')]
    public function valutatoreIdUpdated(?array $filters = []): void
    {
        $filtersArray = is_array($filters) ? $filters : ($this->pageFilters ?? []);

        if ($filtersArray === []) {
            $this->form->fill([]);

            return;
        }

        // Type narrowing: ensure filtersArray is array before Arr::get
        /** @var array<string, mixed> $filtersArrayTyped */
        $filtersArrayTyped = is_array($filtersArray) ? $filtersArray : [];
        $valutatoreIdRaw = Arr::get($filtersArrayTyped, 'valutatore_id', null);
        $this->valutatore_id = is_string($valutatoreIdRaw) || is_numeric($valutatoreIdRaw) ? (string) $valutatoreIdRaw : '';
        $stabi_repar_class = Str::of($this->resource)->before('\\Filament\\')->append('\\Models\\StabiDirigente')->toString();
        if (! class_exists($stabi_repar_class)) {
            $this->record = null;
            $this->form->fill([]);

            return;
        }
        /** @var class-string<Model> $stabiReparClass */
        $stabiReparClass = $stabi_repar_class;
        /** @var array<string, mixed> $where */
        $where = ['id' => $this->valutatore_id];
        $record = $stabiReparClass::firstWhere($where);

        if (! $record instanceof Model) {
            $this->record = null;
            /** @var array<string, mixed> $emptyData */
            $emptyData = [];
            $this->form->fill($emptyData);

            return;
        }

        $nomeDiri = isset($record->nome_diri) && is_string($record->nome_diri) ? $record->nome_diri : '';
        /** @var array<string, mixed> $data */
        $data = [
            'nome_diri' => $nomeDiri,
        ];

        $this->record = $record;
        $this->form->fill($data);
    }

    /**
     * @param array<string, mixed>|null $filters
     */
    #[On('filters-updated')]
    public function filtersUpdated(?array $filters = []): void
    {
        $filtersArray = is_array($filters) ? $filters : ($this->pageFilters ?? []);

        if ($filtersArray === []) {
            $this->form->fill([]);

            return;
        }

        // $this->filters=array_merge($this->filters ?? [],$filters);
        // $livewire->tableFilters

        // Type narrowing: ensure filtersArray is array before Arr::get
        /** @var array<string, mixed> $filtersArrayTyped */
        $filtersArrayTyped = is_array($filtersArray) ? $filtersArray : [];
        $annoRaw = Arr::get($filtersArrayTyped, 'anno', null);
        $this->anno = is_string($annoRaw) || is_numeric($annoRaw) ? (string) $annoRaw : '';
        $valutatoreIdRaw = Arr::get($filtersArrayTyped, 'valutatore_id', null);
        $this->valutatore_id = is_string($valutatoreIdRaw) || is_numeric($valutatoreIdRaw) ? (string) $valutatoreIdRaw : '';

        $stabi_repar_class = Str::of($this->resource)->before('\Filament\\')->append('\Models\StabiDirigente')->toString();
        if (! class_exists($stabi_repar_class)) {
            $this->record = null;
            /** @var array<string, mixed> $emptyData */
            $emptyData = [];
            $this->form->fill($emptyData);

            return;
        }
        /** @var class-string<Model> $stabiReparClass */
        $stabiReparClass = $stabi_repar_class;
        /** @var array<string, mixed> $where */
        $where = ['id' => $this->valutatore_id];
        $record = $stabiReparClass::firstWhere($where);

        if (! $record instanceof Model) {
            $this->record = null;
            /** @var array<string, mixed> $emptyData */
            $emptyData = [];
            $this->form->fill($emptyData);

            return;
        }

        $nomeDiri = isset($record->nome_diri) && is_string($record->nome_diri) ? $record->nome_diri : '';
        /** @var array<string, mixed> $data */
        $data = ['nome_diri' => $nomeDiri];
        $this->record = $record;

        $this->form->fill($data);
    }
}
