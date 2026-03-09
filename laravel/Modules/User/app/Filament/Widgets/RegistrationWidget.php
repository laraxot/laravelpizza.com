<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Webmozart\Assert\Assert;

class RegistrationWidget extends XotBaseWidget
{
    public string $type;
    public string $model;
    public Model $record;

    protected string $view = 'pub_theme::filament.widgets.registration';

    public function mount(string $type, Request $request): void
    {
        $this->type = $type;
        $xot = XotData::make();
        $this->model = $xot->getUserClass();
        $this->record = $this->getFormModel();
        $this->form->fill(['type' => $this->type]);
    }

    public function getFormModel(): Model
    {
        $modelClass = $this->model;
        return new $modelClass;
    }

    public function getFormSchema(): array
    {
        return [];
    }

    public function register(): RedirectResponse|Redirector
    {
        return redirect()->back();
    }
}
