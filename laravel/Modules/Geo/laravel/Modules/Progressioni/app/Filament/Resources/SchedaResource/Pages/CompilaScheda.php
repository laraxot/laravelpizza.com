<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\SchedaResource\Pages;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
// use Filament\Pages\Page; //route not exists
use Filament\Pages\Contracts\HasFormActions;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
// use Filament\Resources\Pages\Concerns\UsesResourceForm; // Not needed for this custom form implementation
use Illuminate\Support\Facades\Gate;
use Modules\Progressioni\Filament\Resources\SchedaResource;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

// class CompilaCondizioniLavoro extends \Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord {
/**
 * Custom form implementation for compiling evaluation sheets
 * Uses form_data array instead of Filament form component
 */
class CompilaScheda extends XotBasePage
{
    /* implements HasFormActions */
    // use HasRecordBreadcrumb;
    use HasRelationManagers;
    use InteractsWithRecord;
    // use UsesResourceForm; // Not needed - using custom form_data implementation

    protected static string $resource = SchedaResource::class;

    protected string $view = 'progressioni::admin.schede.compila.page';

    /** @var array<string, mixed> */
    public array $form_data = [];

    public string $previousUrl = '#';

    /*
    public array $rules = [
        // 'form_data.tot_gg' => 'numeric',
        // 'form_data.tot_presenza_periodo_plus_no_timbr' => 'gte:form_data.tot_gg',
        // 'form_data.tot_presenza_periodo_plus_no_timbr' => 'required',
        // 'form_data.dettaglio.*.pivot.gg' => 'lte:form_data.tot_presenza_periodo_plus_no_timbr',
        'form_data.punt_progressione' => 'required|numeric|min:0|max:4',
        'form_data.email' => 'email',
    ];
    */

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            // 'form_data.punt_progressione' => 'required|numeric|min:0|max:4',
            'form_data.punt_progressione' => 'required|decimal:0,2|min:0|max:4',
            'form_data.email' => 'email',
            'form_data.benificiario_progressione' => '',
        ];
    }

    /** @var array<string, string> */
    public array $messages = [
        // 'form_data.tot_presenza_periodo_plus_no_timbr.gte' => ':attribute: DEVONO ESSERE MAGGIORNI DELLA SOMMA DEI GIORNI DEI PERIODI',
    ];

    /** @var array<string, string> */
    public array $validationAttributes = [
        // 'form_data.tot_presenza_periodo_plus_no_timbr' => 'Giorni Complessivi',
    ];

    /*
    protected function getActions(): array {
        return [
            Actions\DeleteAction::make(),
        ];
    }*/
    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->authorizeAccess();

        $this->fillForm();

        $this->previousUrl = url()->previous();
    }

    private function authorizeAccess(): void
    {
        // Check if user can access the resource
        $resource = static::$resource;
        if (! $resource::canEdit($this->getRecord())) {
            abort(403);
        }

        // Check specific permission for compiling
        if (! Gate::allows('compila', $this->record)) {
            abort(403);
        }
    }

    private function fillForm(): void
    {
        // Hook for before filling form data
        $this->beforeFill();

        $data = $this->getRecord()->attributesToArray();

        /*
        if ($this->getRecord()->anno >= 2023) {
            $q = $this->getRecord()->quadrimestre;
            $dal = Carbon::parse($this->getRecord()->anno.'-01-01')->addMonths(4 * ($q - 1));
            $al = Carbon::parse($this->getRecord()->anno.'-01-01')->addMonths(4 * $q)->subDays(1);
            $res = tap($this->getRecord())->update(['dal' => $dal, 'al' => $al]);
            // dddx($res);
        }
        */
        $data = $this->mutateFormDataBeforeFill($data);

        // Store form data directly without using Filament form
        /** @var array<string, mixed> $data */
        $this->form_data = $data;

        // dddx($this->form_data['benificiario_progressione']);

        // Hook for after filling form data
        $this->afterFill();

        // $this->form_data['dettaglio'] = $this->getRecord()->indennitaTipoDettaglio->keyBy('id')->toArray();
        // $this->form_data['tot_presenza_periodo_plus_no_timbr'] = $this->getRecord()->tot_presenza_periodo_plus_no_timbr;
    }

    protected function getViewData(): array
    {
        /*
        $this->form_data['tot_gg'] = collect($this->form_data['dettaglio'])
        ->filter(function ($item) {
            // return is_numeric($item);
            return true;
        })
        ->sum('pivot.gg');
        */
        /*
        $this->form_data['tot_gg'] = collect($this->form_data['dettaglio'])
              ->reduce(static fn ($tot_gg, $item): float|int => $tot_gg + (int) $item['pivot']['gg'], 0);
        $this->form_data['tot_euro'] = collect($this->form_data['dettaglio'])
            ->reduce(static fn ($tot_euro, $item): float|int => $tot_euro + ($item['euro_giorno'] * (int) $item['pivot']['gg']), 0);
        */
        return [];
    }

    /**
 * @param array<string, mixed> $data
 * @return array<string, mixed>
 */
        private function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    /**
     * Hook called before filling form data.
     */
    protected function beforeFill(): void
    {
        // Override in child classes if needed
    }

    /**
     * Hook called after filling form data.
     */
    protected function afterFill(): void
    {
        // Override in child classes if needed
    }

    public function save(): void
    {
        $this->validate();
        // dddx($this->form_data['benificiario_progressione']);
        // dddx($this->form_data['punt_progressione']);
        $this->getRecord()->update($this->form_data);

        // dddx($this->getRecord()->benificiario_progressione);
        /*
        $this->getRecord()->update([
            'tot_presenza_periodo_plus_no_timbr' => $this->form_data['tot_presenza_periodo_plus_no_timbr'],
            'tot' => $this->form_data['tot_euro'],
        ]);
        foreach ($this->form_data['dettaglio'] as $pivot_id => $dettaglio) {
            $pivot_data = ['gg' => $dettaglio['pivot']['gg']];
            $this->getRecord()->indennitaTipoDettaglio()->updateExistingPivot($pivot_id, $pivot_data);
        }
        */
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }

    public function back(): void
    {
        /** @var string|null $url */
        $url = static::$resource::getUrl('index');
        redirect($url ?? '');
    }
}
