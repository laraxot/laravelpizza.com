<?php

declare(strict_types=1);

namespace Modules\Ptv\Http\Livewire\Nav;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Sigma\Models\Repart;
use Modules\Xot\Actions\GetViewAction;

class StabiReparAnno extends Component
{
    /** @var array<int, array{label: string, id: int}> */
    public array $select_opts = [];

    /** @var array<int, array{label: string, id: int}> */
    public array $select_opt_subs = [];

    /**
     * Undocumented variable.
     *
     * @var int|string|null
     */
    public $stabi;

    public int $repar;

    /**
     * Year variable.
     *
     * @var int|string|null
     */
    public $year;

    /**
     * @param  array{options: Collection<int, string>}  $nav
     */
    public function mount(array $nav, int $year): void
    {
        $opts = $nav['options']->all();
        $opts = collect($opts)->map(static fn ($v, $k): array => ['label' => $v, 'id' => $k])->all();

        $this->select_opts = $opts;
        $this->year = (int) request()->input('year', $year);
        $this->stabi = (int) request()->input('stabi');
        $this->repar = (int) request()->input('repar');
        $this->setSubSelectStabi($this->stabi);
    }

    public function render(): View
    {
        $view = app(GetViewAction::class)->execute();

        $view_params = [
            'stabi' => $this->stabi,
            'repar' => $this->repar,
            'anno' => $this->year,
            'view' => $view,
            'select_opts' => $this->select_opts,
        ];

        return view($view, $view_params);
    }

    /**
     * @return array<array{label: string, id: int}>
     */
    public function setSubSelectStabi(int $stabi): array
    {
        $rows = Repart::where('stabi', $stabi)
            ->where('repar', '!=', 0)
            ->get();
        $opts = $rows->map(static fn (Repart $item): array => [
            'label' => $item->repar.'] '.$item->dest1,
            'id' => $item->repar,
        ])->all();

        $this->select_opt_subs = $opts;

        return $opts;
    }

    public function setSubSelect(): void
    {
        $this->setSubSelectStabi((int) $this->stabi);
    }
}
