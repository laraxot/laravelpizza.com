<?php

/**
 * https://forum.laravel-livewire.com/t/wire-ignore-with-google-autocomplete/734/3.
 * $this->dispatch('address:list:refresh');.
 */

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Http\Livewire\LettF;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\IndennitaResponsabilita\Models\ImportiCategoria;
use Modules\IndennitaResponsabilita\Models\LettF;
use Modules\Xot\Actions\GetViewAction;

class Edit extends Component
{
    /** @var array<string, mixed> */
    public array $form_data;

    public string $date_format = 'd/m/Y';

    // public LettF $row;
    /** @var array<string, string> */
    protected $listeners = ['load_values' => '$refresh'];

    public function mount(LettF $lettF): void
    {
        // $this->row = $row;
        // dddx(['dalf' => $row->dalf, 'alf' => $row->alf]);
        /** @var array<string, mixed> $formData */
        $formData = $lettF->toArray();
        $this->form_data = $formData;
        /** @var Carbon|null $dalf */
        $dalf = $lettF->dalf;
        if ($dalf !== null) {
            $this->form_data['dalf'] = $dalf->format($this->date_format);
        }
        /** @var Carbon|null $alf */
        $alf = $lettF->alf;
        if ($alf !== null) {
            $this->form_data['alf'] = $alf->format($this->date_format);
        }

        /** @var ImportiCategoria|null $importi */
        $importi = $lettF->importi;
        if ($importi !== null) {
            $this->form_data['importi_categoria'] = $importi->categoria;
            $this->form_data['importi_min'] = $importi->min;
            $this->form_data['importi_max'] = $importi->max;
        }
        // dddx(['dalf' => $row->dalf, 'alf' => $row->alf]);
    }

    public function render(): View
    {
        // $view = 'indennitaresponsabilita::livewire.lett_f.edit';
        /** @var view-string $view */
        $view = app(GetViewAction::class)->execute();
        /** @var array<string, mixed> $view_params */
        $view_params = [];

        return view($view, $view_params);
    }

    public function update(): void
    {
        /** @var array<string, mixed> $validatedData */
        $validatedData = $this->validate();
        /** @var array<string, mixed> $data */
        $data = $validatedData['form_data'] ?? [];

        /** @var int|string|null $id */
        $id = $this->form_data['id'] ?? null;
        if ($id === null) {
            return;
        }
        /** @var LettF|null $row */
        $row = LettF::find($id);
        if ($row === null) {
            return;
        }
        $row->update($data);

        session()->flash('message', ' successfully updated.['.now().']');
    }

    public function totalePunteggioAttribuito(): int|float
    {
        /** @var float|int|string|null $complessita */
        $complessita = $this->form_data['complessita'] ?? 0;
        /** @var float|int|string|null $coordinamento */
        $coordinamento = $this->form_data['coordinamento'] ?? 0;
        /** @var float|int|string|null $responsabilita */
        $responsabilita = $this->form_data['responsabilita'] ?? 0;

        $complessitaNum = is_numeric($complessita) ? (float) $complessita : 0.0;
        $coordinamentoNum = is_numeric($coordinamento) ? (float) $coordinamento : 0.0;
        $responsabilitaNum = is_numeric($responsabilita) ? (float) $responsabilita : 0.0;

        return $complessitaNum + $coordinamentoNum + $responsabilitaNum;
    }

    public function valoreEconomicoCalcolato(): int|float
    {
        /** @var float|int|string|null $importiMax */
        $importiMax = $this->form_data['importi_max'] ?? 0;
        $importiMaxNum = is_numeric($importiMax) ? (float) $importiMax : 0.0;

        return $this->totalePunteggioAttribuito() * $importiMaxNum / 100;
    }

    public function valoreEconomicoAttribuito(): int|float
    {
        /** @var float|int|string|null $importiMin */
        $importiMin = $this->form_data['importi_min'] ?? 0;
        $importiMinNum = is_numeric($importiMin) ? (float) $importiMin : 0.0;

        if ($this->valoreEconomicoCalcolato() > $importiMinNum) {
            return $this->valoreEconomicoCalcolato();
        }

        if ($this->totalePunteggioAttribuito() == 0) {
            return 0;
        }

        return $importiMinNum;
    }

    public function valoreEconomicoEffettivo(): int|float
    {
        if ($this->totalePunteggioAttribuito() == 0) {
            return 0;
        }

        /** @var string|null $dalfStr */
        $dalfStr = $this->form_data['dalf'] ?? null;
        if ($dalfStr === null) {
            return 0;
        }
        /** @var string|null $alfStr */
        $alfStr = $this->form_data['alf'] ?? null;
        if ($alfStr === null) {
            return 0;
        }

        $dalRaw = Carbon::createFromFormat($this->date_format, $dalfStr);
        if (! ($dalRaw instanceof Carbon)) {
            return 0;
        }
        $dal = $dalRaw;
        $alRaw = Carbon::createFromFormat($this->date_format, $alfStr);
        if (! ($alRaw instanceof Carbon)) {
            return 0;
        }
        $al = $alRaw;
        $gg = $dal->diffInDays($al, true) + 1;
        /** @var string $leapYear */
        $leapYear = $dal->format('L');
        $tot_gg = 365 + (int) $leapYear;

        return $this->valoreEconomicoAttribuito() * $gg / $tot_gg;
    }
}
