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
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Xot\Actions\Cast\SafeArrayCastAction;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Webmozart\Assert\Assert;

class RegistrationWidget extends XotBaseWidget
{
    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = null;

    public string $type;

    public string $resource;

    public string $model;

    public string $action;

    public Model $record;

    protected int|string|array $columnSpan = 'full';

    /**
     * @phpstan-var class-string
     *
     * @phpstan-ignore-next-line
     */
    protected string $view = 'pub_theme::filament.widgets.registration';

    public function mount(string $type, Request $_request): void
    {
        $this->type = $type;
        $this->resource = XotData::make()->getUserResourceClassByType($type);

        $modelClass = $this->resource::getModel();
        $this->model = \is_string($modelClass) ? $modelClass : '';

        $this->action = Str::of($this->model)
            ->replace('\\Models\\', '\\Actions\\')
            ->append('\\RegisterAction')
            ->toString();
        $record = $this->getFormModel();
        $data = $this->getFormFill();

        $this->data = $data;
        $this->form->fill($this->data);
        $this->form->model($record);
        $this->record = $record;
    }

    public function getFormModel(): Model
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = $this->model;

        $data = request()->all();
        $email = Arr::get($data, 'email');
        $token = Arr::get($data, 'token');

        /** @var Model|null $user */
        $user = $this->model::firstWhere('email', $email);
        if (null === $user) {
            /** @var Model $model */
            $model = app($this->model);

            return $model;
        }

        $remember_token = $user->getAttribute('remember_token');
        if ($token) {
            $user->setAttribute('remember_token', $token);
            $user->save();
            $remember_token = $user->getAttribute('remember_token');
        }

        if ($remember_token === $token) {
            $this->record = $user;

            return $user;
        }

        $model = app($modelClass);
        Assert::isInstanceOf($model, Model::class);

        return $model;
    }

    /**
     * @return array<string, mixed>
     */
    #[\Override]
    public function getFormFill(): array
    {
        /** @var array<string, mixed> $data */
        $data = SafeArrayCastAction::cast(parent::getFormFill());
        $data['type'] = $this->type;

        return $data;
    }

    /**
     * @return array<int|string, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        /** @var array<int|string, Component> $schema */
        $schema = $this->resource::getFormSchemaWidget();
        Assert::isArray($schema);

        return $schema;
    }

    /**
     * @see https://filamentphp.com/docs/3.x/forms/adding-a-form-to-a-livewire-component
     */
    public function register(): RedirectResponse|Redirector
    {
        $lang = app()->getLocale();

        $data = $this->form->getState();
        /** @var array<string, mixed> $initialData */
        $initialData = $this->data ?? [];
        $data = array_merge($initialData, $data);
        $record = $this->record;

        /** @var object{execute: callable} $actionInstance */
        $actionInstance = app($this->action);

        /** @phpstan-ignore method.notFound */
        $user = $actionInstance->execute($record, $data);

        $lang = app()->getLocale();
        $route = route('pages.view', ['slug' => $this->type.'_register_complete']);
        $route = LaravelLocalization::localizeUrl($route, $lang);

        // return redirect()->route('pages.view', ['slug' => $this->type . '_register_complete','lang'=>$lang]);
        return redirect($route);
    }
}
