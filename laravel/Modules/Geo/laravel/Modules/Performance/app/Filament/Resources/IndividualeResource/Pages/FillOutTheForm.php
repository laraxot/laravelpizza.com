<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeResource\Pages;

use Exception;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Modules\Performance\Filament\Resources\IndividualeResource;
use Modules\Performance\Models\Individuale;
use Modules\Ptv\Filament\Resources\SchedaResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseResourcePage;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Webmozart\Assert\Assert;

/**
 * @property Schema $form
 * @property Individuale $record
 */
class FillOutTheForm extends XotBaseResourcePage
{
    
    //protected static string $resource = IndividualeResource::class;
    protected static string $resource = SchedaResource::class;

    public string $previousUrl = '#';

    /** @var array<string, mixed> */
    /**
     * Form data holder.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public float $totale = 0;

    public bool $excellence = false;

    /** @var array<string, string> */
    protected array $rules = [
        'data.risultati_ottenuti' => 'required|numeric|min:0|max:4',
        'data.qualita_prestazione' => 'required|numeric|min:0|max:4',
        'data.arricchimento_professionale' => 'required|numeric|min:0|max:4',
        'data.impegno' => 'required|numeric|min:0|max:4',
        'data.esperienza_acquisita' => 'required|numeric|min:0|max:4',
    ];

    /*
    public static function getResource(): string
    {
        return IndividualeResource::class;
    }
    */

    /**
     * @param  int|string  $record
     */
    public function mount($record): void
    {
        Assert::isInstanceOf($model = $this->resolveRecord($record), Individuale::class);
        $this->record = $model;
        $this->authorizeAccess();
        $criteri_valutazione = $this->record->criteriValutazione()->get();
        foreach ($criteri_valutazione as $criterio) {
            $k = $criterio->getAttribute('nome');
            if (is_string($k)) {
                $this->data[$k] = data_get($this->record, $k, 0);
            }
        }

        $this->excellence = (bool) $this->record->excellence;
        $this->totale = (float) $this->record->totale_punteggio;
        // $this->fillForm();
        

        $this->previousUrl = url()->previous();
    }

    /**
     * @return array<string, mixed>
     */
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
        // dddx($this->record->options);
        Assert::isInstanceOf($model = $this->record, Individuale::class);
        $model->options()->where('parent_id', null)->update(['parent_id' => 0]);
        $criteri_options_root = $model->options()
            ->where('parent_id', 0)
            ->where('name', 'criterio')
            ->get();

        return [
            'criteri_options_root' => $criteri_options_root,
            'view' => $this->getView(),
        ];
    }

    /*
     private function fillFormOld(): void {
        $this->callHook('beforeFill');

        $data = $this->getRecord()->attributesToArray();


        $data = $this->mutateFormDataBeforeFill($data);

        $this->form->fill($data);
        $this->data = $data;

        // dddx($this->form_data['benificiario_progressione']);

        $this->callHook('afterFill');

        // $this->form_data['dettaglio'] = $this->getRecord()->indennitaTipoDettaglio->keyBy('id')->toArray();
        // $this->form_data['tot_presenza_periodo_plus_no_timbr'] = $this->getRecord()->tot_presenza_periodo_plus_no_timbr;
    }
    */

    private function authorizeAccess(): void
    {
        static::authorizeResourceAccess();
        // abort_unless(static::getResource()::canEdit($this->getRecord()), 403);
        if (! Gate::allows('compila', $this->record)) {
            abort(403);
        }
    }

    public function getView(): string
    {
        $resource = static::getResource();
        $view = 'performance::'.Str::of(class_basename($resource))
            ->snake()
            ->before('_resource')
            ->append('.pages.fill_out_the_form')
            ->toString();
        if (! view()->exists($view)) {
            throw new Exception('View ['.$view.'] not found');
        }

        return $view;
    }

    public function back(): void
    {
        $this->redirect(static::$resource::getUrl('index'));
    }

    public function save(): void
    {
        $this->validate();
        $data = $this->data;
        $data['excellence'] = $this->excellence;
        $data['totale_punteggio'] = $this->totale;

        // $this->authorizeAccess();
        // $this->record->fill($this->data);
        // $this->record->save();
        $this->record->update($data);

        // $this->redirect(route('admin.'.$this->getRoutePrefix().'.edit', $this->record->getKey()));

        Notification::make()
            ->title('Aggiornato ')
            ->success()
            ->send();
    }

    public function recalculate(): void
    {
        $tot = 0;

        $criteri_valutazione = $this->record->criteriValutazione->where('post_type', $this->record->type);
        foreach ($criteri_valutazione as $v) {
            $nome = $v->getAttribute('nome');
            if (is_string($nome)) {
                $dataValue = $this->data[$nome] ?? 0;
                if (is_numeric($dataValue)) {
                    $value = floatval($dataValue);
                    $peso = $this->record->getPeso($nome);
                    $tot += $peso * $value;
                }
            }
        }

        $tot /= 4;

        $this->totale = $tot;
    }

    /*
    public function updating(): void {
        dddx([
            'property'=>$property,
            'value'=>$value
        ]);
    }
    */
    /*
    public function updated(): void {
        dddx([
            'property'=>$property
        ]);
    }
    */

    public function updatedData(): void
    {
        $this->recalculate();
    }
}
