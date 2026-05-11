<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Resources\Pages\Page as FilamentPage;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;

/**
 * Base class for all custom pages in the application.
 *
 * This class provides common functionality for custom pages,
 * following the architectural pattern of never extending Filament classes directly.
 *
 * @property ?string              $model
 * @property array<string, mixed> $data
 * @property Schema               $form
 */
abstract class XotBasePage extends FilamentPage implements HasForms
{
    use InteractsWithFormActions;
    use InteractsWithForms;
    use NavigationLabelTrait;

    /**
     * The model class associated with this page, if any.
     *
     * @var class-string<Model>|null
     */
    public static ?string $model = null;

    /**
     * The form data.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * Get the view that should be used for the page.
     */
    public function getView(): string
    {
        $view = Str::of(static::class)
            ->after('Modules\\')
            ->before('\\Filament\\')
            ->lower()
            ->append('::filament.pages.')
            ->append(
                Str::of(static::class)
                    ->afterLast('\\')
                    ->kebab()
                    ->toString(),
            );

        return $view->toString();
    }

    public function getViewTest(): string
    {
        $class = self::class;
        $module = Str::between($class, 'Modules\\', '\Filament');

        $after = explode('\\', Str::after($class, '\Filament\\'));
        $after[1] = Str::before($after[1], 'Resource');
        $after[3] = Str::before($after[3], $after[1]);

        $after = collect($after)->map(static function ($item) {
            return Str::kebab($item);
            // return Str::snake($item);
        })->implode('.');
        $view = Str::lower($module).'::filament.'.$after;
        if (! view()->exists($view)) {
            throw new \Exception('view ['.$view.'] not Exists  !!');
        }

        return $view;
    }

    /**
     * Get navigation label with automatic translation.
     */
    public static function getNavigationLabel(): string
    {
        return static::transFunc(__FUNCTION__);
    }

    /**
     * Get page title with automatic translation.
     */
    public function getTitle(): string
    {
        return static::transFunc(__FUNCTION__);
    }

    /**
     * Get the heading with automatic translation.
     */
    public function getHeading(): string
    {
        return $this->getTitle();
    }

    /**
     * Configure the schema.
     */
    public function schema(Schema $schema): Schema
    {
        return $schema->components($this->getFormSchema())
            ->statePath('data')
            ->columns(2);
    }

    public function getFormStatePath(): string
    {
        return 'data';
    }

    final public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getFormSchema())
            ->model($this->getFormModel())
            ->statePath($this->getFormStatePath())
            ->operation($this->getFormContext())
            ->columns(2);
    }

    /**
     * Get the associated model class for this page.
     *
     * This method must be non-static to properly override the parent method.
     * Returns the model class string or throws an exception if not set.
     */
    /**
     * @return class-string<Model>
     */
    public function getModel(): string
    {
        if (null === static::$model) {
            throw new \LogicException('Model class not set for page: '.static::class);
        }

        /** @var class-string<Model> $model */
        $model = static::$model;

        return $model;
    }

    /**
     * Get the resources associated with this page.
     *
     * @return Collection<int, string>
     */
    public static function getResources(): Collection
    {
        /* @var Collection<int, string> $resources */
        // @phpstan-ignore-next-line
        return collect([]);
    }

    /**
     * Get the form model for the page.
     * Filament compatibility method.
     *
     * @return class-string<Model>|null
     */
    protected function getFormModel(): Model|string|null
    {
        return static::$model;
    }

    /**
     * Get the form context for the page.
     * Filament compatibility method.
     */
    protected function getFormContext(): ?string
    {
        return 'edit';
    }

    /**
     * Get the form schema for the page.
     *
     * @return array<int|string, Component>
     */
    protected function getFormSchema(): array
    {
        return [];
    }

    /*
     * Hook chiamato all'inizializzazione del componente.
     *
     * public function mount(int|string $record): void
     * {
     * parent::mount($record);
     * $this->form->fill($this->data ?? []);
     * }
     */
    /**
     * Get the view data for the page.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'data' => $this->data,
            'record' => $this->record ?? null,
        ];
    }
}
