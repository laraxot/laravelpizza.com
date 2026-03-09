<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Webmozart\Assert\Assert;

class EditUserWidget extends XotBaseWidget
{
    public string $type;
    public string $resource;
    public string $model;
    public string $action;
    public Model $record;
    public ?array $data = null;

    protected string $view = 'pub_theme::filament.widgets.edit-user';

    public function mount(string $type, ?string $userId = null): void
    {
        $this->type = $type;
        $xot = XotData::make();
        $this->model = $xot->getUserClass();

        $this->record = $this->getFormModel($userId);
        $this->form->fill($this->record->toArray());
    }

    public function getFormSchema(): array
    {
        return [];
    }

    public function updateUser(): RedirectResponse|Redirector
    {
        $data = $this->form->getState();
        $this->record->update($data);

        return redirect()->back();
    }

    protected function getFormModel(?string $userId = null): Model
    {
        $modelClass = $this->model;
        if ($userId) {
            return $modelClass::findOrFail($userId);
        }

        $user = Auth::user();
        Assert::isInstanceOf($user, Model::class);

        return $user;
    }
}
