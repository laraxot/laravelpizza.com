<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Features\SupportRedirects\Redirector;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Xot\Actions\Cast\SafeArrayCastAction;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;
use Webmozart\Assert\Assert;

class RegistrationWidget extends XotBaseSchemaWidget
{
    public string $type = '';

    /** @var class-string */
    public string $resource;

    /** @var class-string<Model> */
    public string $model = Model::class;

    public string $action = '';

    public Model $record;

    protected int|string|array $columnSpan = 'full';

    public function mount(string $type = ''): void
    {
        parent::mount();
        $this->type = $type;
        $resourceClass = XotData::make()->getUserResourceClassByType($type);
        Assert::classExists($resourceClass);
        $this->resource = $resourceClass;

        /** @var class-string<Model> $modelClass */
        $modelClass = $resourceClass::getModel();
        Assert::subclassOf($modelClass, Model::class);
        $this->model = $modelClass;

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
        $data = request()->all();
        $email = Arr::get($data, 'email');
        $token = Arr::get($data, 'token');

        $user = is_string($email)
            ? $this->model::firstWhere('email', $email)
            : null;
        if (! $user instanceof Model) {
            $model = app($this->model);
            Assert::isInstanceOf($model, Model::class);

            return $model;
        }

        $rememberToken = $user->getAttribute('remember_token');
        if (is_string($token) && '' !== $token) {
            $user->setAttribute('remember_token', $token);
            $user->save();
            $this->record = $user;

            return $user;
        }

        if (is_string($rememberToken) && $rememberToken === $token) {
            $this->record = $user;

            return $user;
        }

        $model = app($this->model);
        Assert::isInstanceOf($model, Model::class);

        return $model;
    }

    /**
     * @return array<string, mixed>
     */
    // @override
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
    public function getFormSchema(): array
    {
        return self::normalizeFormSchema($this->resource::getFormSchemaWidget());
    }

    /**
     * @see https://filamentphp.com/docs/3.x/forms/adding-a-form-to-a-livewire-component
     */
    // @override
    public function register(): RedirectResponse|Redirector
    {
        $data = $this->form->getState();
        /** @var array<string, mixed> $initialData */
        $initialData = $this->data ?? [];
        $data = array_merge($initialData, $data);
        $record = $this->record;

        $actionInstance = app($this->action);
        if (! \is_object($actionInstance) || ! method_exists($actionInstance, 'execute')) {
            throw new \RuntimeException(\sprintf('Registration action [%s] must expose an execute method.', $this->action));
        }
        \call_user_func([$actionInstance, 'execute'], $record, $data);

        $lang = app()->getLocale();
        $route = route('pages.view', ['slug' => $this->type.'_register_complete']);
        $route = LaravelLocalization::localizeUrl($route, $lang);

        // return redirect()->route('pages.view', ['slug' => $this->type . '_register_complete','lang'=>$lang]);
        return redirect($route);
    }

    /**
     * @return array<int|string, Component>
     */
    private static function normalizeFormSchema(mixed $schema): array
    {
        if (! \is_array($schema)) {
            return [];
        }

        $normalized = [];
        foreach ($schema as $key => $component) {
            if (! $component instanceof Component) {
                return [];
            }

            $normalized[$key] = $component;
        }

        return $normalized;
    }
}
