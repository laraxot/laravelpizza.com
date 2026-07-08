<?php

declare(strict_types=1);

namespace Modules\Ptv\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Modules\Ptv\Contracts\StabiDirigenteContract;
use Modules\Xot\Actions\GetViewAction;
use Nwidart\Modules\Facades\Module;
use RuntimeException;

use function Safe\class_implements;

class EditFirma extends Component
{
    public ?int $stabi = null;

    public ?int $repar = null;

    public ?int $year = null;

    public string $module_name;

    public ?string $nome_stabi = null;

    public ?string $nome_diri = null;

    public ?string $stabi_diri = null;

    public function mount(string $module_name): void
    {
        $this->year = is_numeric(request()->input('year')) ? (int) request()->input('year') : null;
        $this->stabi = is_numeric(request()->input('stabi')) ? (int) request()->input('stabi') : null;
        $this->repar = is_numeric(request()->input('repar')) ? (int) request()->input('repar') : null;
        $this->module_name = $module_name;

        $stabi_diri = $this->getStabiDiri();
        if ($stabi_diri !== null) {
            // @phpstan-ignore-next-line property.notFound
            $this->nome_diri = $stabi_diri->nome_diri;
            // @phpstan-ignore-next-line property.notFound
            $this->nome_stabi = $stabi_diri->nome_stabi;
        }
    }

    public function getStabiDiri(): ?StabiDirigenteContract
    {
        if ($this->stabi === null) {
            return null;
        }

        $mod = Module::find($this->module_name);
        if ($mod === null) {
            return null;
        }

        $mod_name = $mod->getName();
        $stabi_diri_class = '\Modules\\'.$mod_name.'\Models\StabiDirigente';

        // Type narrowing: ensure class exists and is instantiable
        if (! class_exists($stabi_diri_class)) {
            return null;
        }

        // Verify class implements StabiDirigenteContract before instantiation
        if (! is_subclass_of($stabi_diri_class, Model::class)) {
            return null;
        }

        /** @var array<int, class-string> $implements */
        $implements = (array) class_implements($stabi_diri_class);
        if (! in_array(StabiDirigenteContract::class, $implements, true)) {
            return null;
        }

        /** @var Model&StabiDirigenteContract $stabi_diri_obj */
        $stabi_diri_obj = app($stabi_diri_class);

        $result = $stabi_diri_obj->firstOrCreate(
            [
                'stabi' => $this->stabi,
                'repar' => $this->repar,
                'anno' => $this->year,
            ]
        );

        // Result is guaranteed to be StabiDirigenteContract because firstOrCreate returns instance of same class
        // Type narrowing already done above, so result is StabiDirigenteContract
        return $result;
    }

    public function render(): View
    {
        $view = app(GetViewAction::class)->execute();

        return view($view, ['view' => $view]);
    }

    public function update(): void
    {
        $stabi_diri = $this->getStabiDiri();
        if ($stabi_diri === null) {
            throw new RuntimeException('StabiDirigente not found');
        }
        $stabi_diri->update([
            'nome_stabi' => $this->nome_stabi,
            'nome_diri' => $this->nome_diri,
        ]);

        session()->flash('message', 'Updated Successfully.');
    }
}
