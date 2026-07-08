<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroResource\Pages;

use Carbon\Carbon;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroResource;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\Xot\Filament\Resources\Pages\XotBaseResourcePage;

/**
 * Undocumented class
 */
class CompilaCondizioniLavoro extends XotBaseResourcePage
{
    use HasRelationManagers;
    use InteractsWithRecord;

    protected static bool $isLazy = false;

    protected static string $resource = CondizioniLavoroResource::class;

    protected string $view = 'indennitacondizionilavoro::admin.condizioni_lavoro.compila.page';

    /**
     * @var array<string, mixed>
     */
    public array $form_data = [

    ];

    /**
     * @var array<string, mixed>
     */
    public array $rules = [
        'form_data.tot_gg' => 'numeric',
        'form_data.dettaglio.*.pivot.gg' => 'lte:form_data.tot_presenza_periodo_plus_no_timbr',
    ];

    /**
     * @var array<string, mixed>
     */
    public array $messages = [
        'form_data.tot_presenza_periodo_plus_no_timbr.gte' => ':attribute: DEVONO ESSERE MAGGIORNI DELLA SOMMA DEI GIORNI DEI PERIODI',
    ];

    /**
     * @var array<string, mixed>
     */
    public array $validationAttributes = [
        'form_data.tot_presenza_periodo_plus_no_timbr' => 'Giorni Complessivi',
    ];

    public string $previousUrl;

    public function mount(string|int $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->authorizeAccess();

        $this->fillForm();

        $this->previousUrl = url()->previous();
    }

    private function authorizeAccess(): void
    {
        static::authorizeResourceAccess();
        if (! Gate::allows('compila', $this->record)) {
            abort(403);
        }
    }

    private function fillForm(): void
    {
        $this->callHook('beforeFill');

        $data = $this->getRecord()->attributesToArray();

        /** @var CondizioniLavoro $record */
        $record = $this->getRecord();
        if ($record->anno >= 2023) {
            $quadrimestre = $record->quadrimestre;
            $dal = Carbon::parse($record->anno.'-01-01')->addMonths(4 * ($quadrimestre - 1));
            $al = Carbon::parse($record->anno.'-01-01')->addMonths(4 * $quadrimestre)->subDays(1);
            $record->update(['dal' => $dal, 'al' => $al]);
        }

        $data = $this->mutateFormDataBeforeFill($data);

        // Fill form_data instead of using non-existent form property
        $this->form_data = array_merge($this->form_data, $data);

        $this->callHook('afterFill');

        /** @var CondizioniLavoro $record */
        $record = $this->getRecord();
        $this->form_data['dettaglio'] = $record->indennitaTipoDettaglio->keyBy('id')->toArray();
        $this->form_data['tot_presenza_periodo_plus_no_timbr'] = $record->tot_presenza_periodo_plus_no_timbr;
    }

    protected function getViewData(): array
    {
        $dettaglio = $this->form_data['dettaglio'] ?? [];
        if ($dettaglio instanceof Collection) {
            $dettaglioArray = $dettaglio->toArray();
        } elseif (is_iterable($dettaglio)) {
            $dettaglioArray = is_array($dettaglio) ? $dettaglio : iterator_to_array($dettaglio);
        } else {
            return [];
        }

        /** @var array<int|string, array<string, mixed>> $dettaglioArray */

        /** @var Collection<int, array<string, mixed>> $collection */
        $collection = collect($dettaglioArray);
        $this->form_data['tot_gg'] = $collection
            ->reduce(function ($tot_gg, $item): float|int {
                if (! isset($item['pivot'])) {
                    return $tot_gg;
                }

                /** @var array<string, mixed> $pivot */
                $pivot = (array) $item['pivot'];
                if (! array_key_exists('gg', $pivot)) {
                    return $tot_gg;
                }

                return $tot_gg + (int) $pivot['gg'];
            }, 0);

        /** @var Collection<int, array<string, mixed>> $collection2 */
        $collection2 = collect($dettaglioArray);
        $this->form_data['tot_euro'] = $collection2
            ->reduce(function ($tot_euro, $item): float|int {
                if (! isset($item['euro_giorno'], $item['pivot'])) {
                    return $tot_euro;
                }

                /** @var array<string, mixed> $pivot */
                $pivot = (array) $item['pivot'];
                if (! array_key_exists('gg', $pivot)) {
                    return $tot_euro;
                }

                $euroGiorno = is_numeric($item['euro_giorno']) ? (float) $item['euro_giorno'] : 0.0;
                $giorni = (int) $pivot['gg'];

                return $tot_euro + ($euroGiorno * $giorni);
            }, 0);

        return [];
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    private function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    public function save(): void
    {
        $this->validate();
        $this->getRecord()->update([
            'tot_presenza_periodo_plus_no_timbr' => $this->form_data['tot_presenza_periodo_plus_no_timbr'],
            'tot' => $this->form_data['tot_euro'],
        ]);
        /** @var CondizioniLavoro $record */
        $record = $this->getRecord();

        // Type narrowing: ensure dettaglio is array
        $dettaglioData = isset($this->form_data['dettaglio']) && is_array($this->form_data['dettaglio']) ? $this->form_data['dettaglio'] : [];

        foreach ($dettaglioData as $pivot_id => $dettaglio) {
            if (! is_array($dettaglio) || ! isset($dettaglio['pivot']) || ! is_array($dettaglio['pivot']) || ! isset($dettaglio['pivot']['gg'])) {
                continue;
            }
            $pivot_data = ['gg' => $dettaglio['pivot']['gg']];
            $record->indennitaTipoDettaglio()->updateExistingPivot($pivot_id, $pivot_data);
        }

        FilamentNotification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }

    public function back(): void
    {
        redirect()->to($this->previousUrl);
    }
}
