<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\SchedaResource\Pages;

use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Gate;
use Modules\Performance\Filament\Resources\IndividualeResource;
use Modules\Performance\Models\Individuale;
use Modules\Ptv\Filament\Resources\SchedaResource;
use Modules\Xot\Actions\View\GetViewByModelClassAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseResourcePage;
use Webmozart\Assert\Assert;

/**
 * @property Schema $form
 * @property Individuale $record
 */
abstract class BaseCompilaScheda extends XotBaseResourcePage
{
    // protected static string $resource = IndividualeResource::class;
    protected static string $resource = SchedaResource::class;

    public string $previousUrl = '#';

    /** @var array<string, mixed> */
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

    /**
     * @param  int|string  $record
     */
    public function mount($record): void
    {
        Assert::isInstanceOf($model = $this->resolveRecord($record), Individuale::class);
        $this->record = $model;
        $this->authorizeAccess();
        // *
        $criteri_valutazione = $this->record
            ->criteriValutazione()
            ->where('post_type', $this->record->type)
            ->get();

        foreach ($criteri_valutazione as $criterio) {
            $k = $criterio->getAttribute('nome');
            if (\is_string($k)) {
                $this->data[$k] = data_get($this->record, $k, 0);
            }
        }

        // */
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
        return [
            // 'criteri_options_root' => $criteri_options_root,
            'view' => $this->getView(),
        ];
    }

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
        $view = app(GetViewByModelClassAction::class)->execute($this->record::class, '.pages.compila');

        if (! view()->exists($view)) {
            throw new \Exception('View ['.$view.'] not found');
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

        $res = $this->record->update($data);

        // $this->redirect(route('admin.'.$this->getRoutePrefix().'.edit', $this->record->getKey()));

        Notification::make()
            ->title('Aggiornato ')
            ->success()
            ->send();
    }

    public function recalculate(): void
    {
        $tot = 0;

        $criteri_valutazione = $this->record
            ->criteriValutazione()
            ->where('post_type', $this->record->type)
            ->get();

        foreach ($criteri_valutazione as $v) {
            $nome = $v->getAttribute('nome');
            if (\is_string($nome)) {
                $dataValue = $this->data[$nome] ?? 0;

                if (is_numeric($dataValue)) {
                    $value = (float) $dataValue;
                    $peso = $this->record->getPeso($nome);

                    $tot += $peso * $value;
                }
            }
        }

        $tot /= 4;

        $this->totale = $tot;
    }

    public function updatedData(): void
    {
        $this->recalculate();
    }
}
