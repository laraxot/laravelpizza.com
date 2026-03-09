<?php

declare(strict_types=1);

namespace Modules\Media\Http\Livewire\Card\Video;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Modules\Xot\Actions\GetViewAction;

/**
 * Class Clip.
 */
class Clip extends Component
{
    public string $tpl = 'edit';

    public Model $model;

    /**
     * Undocumented variable.
     *
     * @var array
     */
    /** @var array<string, string> */
    protected $listeners = [
        'updateDataFromModal' => 'updateDataFromModal',
    ];

    /**
     * Undocumented function.
     */
    public function mount(Model $model): void
    {
        $model = $model;
    }

    /**
     * Undocumented function.
     */
    public function render(): View
    {
        /**
         * @phpstan-var view-string
         */
        $view = app(GetViewAction::class)->execute($tpl);
        $view_params = [
            'view' => $view,
        ];

        return view($view, $view_params);
    }

    /**
     * Undocumented function.
     */
    public function editClip(): void
    {
        $data = $model->toArray();
        $this->dispatch('showModal', ['editClip', $data]);
    }

    /**
     * Undocumented function.
     */
    public function updateDataFromModal(string $id, array $data): void
    {
        if ($id !== 'editClip') {
            return;
        }

        if ($data['id'] !== $model->getKey())
            return;
        }

        // dddx(['data'=>$data,'model'=>$model]);
        /** @var array<string, string> */
        $up = collect($data)->only(['title', 'subtitle'])->all();

        $model->update($up);
        $model->refresh();
    }
}
