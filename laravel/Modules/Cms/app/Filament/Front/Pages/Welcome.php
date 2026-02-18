<?php

/**
 * @see https://laraveldaily.com/post/filament-custom-edit-profile-page-multiple-forms-full-design
 */

declare(strict_types=1);

namespace Modules\Cms\Filament\Front\Pages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Filament\Pages\XotBasePage;
use Webmozart\Assert\Assert;

// implements HasTable
class Welcome extends XotBasePage
{
    public string $view_type;

    public array $containers = [];

    public array $items = [];

    public ?Model $instanceModel = null;
    // use InteractsWithTable;
    // use InteractsWithForms;

    // protected static string $view = 'cms::filament.front.pages.welcome';
    protected string $view = 'pub_theme::home';

    protected static string $layout = 'pub_theme::components.layouts.app';

    public function mount(): void
    {
        $lang = request('lang') ?? app()->getLocale();
        if (is_string($lang)) {
            app()->setLocale($lang);
        }
        [$this->containers, $this->items] = params2ContainerItem();
        $this->initView();
    }

    public function getViewData(): array
    {
        $data = [];
        if ($this->containers !== []) {
            $container_last = last($this->containers);
            Assert::string($container_last, '['.__LINE__.']['.__FILE__.']');
            $item_last = last($this->items);
            Assert::string($item_last, '['.__LINE__.']['.__FILE__.']');

            $container_last_singular = Str::singular($container_last);
            Assert::string($container_last_singular, 'Container last singular must be a string');

            $container_last_model = TenantService::model($container_last_singular);

            if (! method_exists($container_last_model, 'getFrontRouteKeyName')) {
                throw new \Exception('[WIP]['.__LINE__.']['.__FILE__.']');
            }

            $container_last_key_name = $container_last_model->getFrontRouteKeyName();
            Assert::string($container_last_key_name, 'Front route key name must be a string');

            /** @var Model $modelInstance */
            $modelInstance = $container_last_model;
            $row = $modelInstance->newQuery()->firstWhere([$container_last_key_name => $item_last]);

            $data[$container_last_singular] = $row;

            if ($row === null) {
                abort(404);
            }
        }

        return $data;
    }

    public function initView(): void
    {
        $containers = $this->containers;
        $items = $this->items;

        $view = '';
        if (\count($containers) === \count($items)) {
            $view = 'show';
        }
        if (\count($containers) > \count($items)) {
            $view = 'index';
        }
        if ($containers === []) {
            $view = 'home';
        }

        $this->view_type = $view;

        $views = [];

        if ($containers !== []) {
            $views[] = 'pub_theme::'.implode('.', $containers).'.'.$view;

            $firstContainer = $containers[0] ?? null;
            if (! is_string($firstContainer)) {
                throw new \Exception('First container must be a string');
            }

            $model_class = TenantService::modelClass($firstContainer);
            Assert::string($model_class, __FILE__.':'.__LINE__.' - '.class_basename(self::class));
            $module_name = Str::between($model_class, 'Modules', '\Models');
            Assert::string($module_name, 'Module name must be a string');
            $module_name_low = Str::lower($module_name);
            $views[] = $module_name_low.'::'.implode('.', $containers).'.'.$view;
        } else {
            $views[] = 'pub_theme::'.$view;
        }

        $view_work = Arr::first($views, view()->exists(...));

        if ($view_work === null) {
            dddx($views);
        }
        Assert::string($view_work, __FILE__.':'.__LINE__.' - '.class_basename(self::class));

        $this->view = $view_work;
    }

    public function url(string $name = 'show', array $parameters = []): string
    {
        // dddx($parameters);
        $parameters['lang'] = app()->getLocale();
        $record = $parameters['record'] ?? $this->instanceModel;
        // dddx($record);
        if ($record && is_object($record) && $name === 'show') {
            $container0 = class_basename($record);
            $container0 = Str::plural($container0);
            $container0 = Str::snake($container0);
            $parameters['container0'] = $container0;
            $parameters['item0'] = $record->slug ?? '';

            return route('test', $parameters);
        }
        if ($record && is_object($record) && $name === 'index') {
            $container0 = class_basename($record);
            $container0 = Str::plural($container0);
            $container0 = Str::snake($container0);
            $parameters['container0'] = $container0;

            return route('test', $parameters);
        }
        $parameters['container0'] = 'articles';
        $parameters['item0'] = 'zibibbo';

        return route('test', $parameters);
    }

    public function setModel(Model $model): self
    {
        $this->instanceModel = $model;

        return $this;
    }
}
