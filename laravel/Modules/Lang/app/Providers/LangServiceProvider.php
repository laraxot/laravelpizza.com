<?php

declare(strict_types=1);

namespace Modules\Lang\Providers;

use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\Entry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Support\Components\Component;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Illuminate\Container\Container;
use Modules\Lang\Actions\Filament\AutoLabelAction;
use Modules\Lang\Services\TranslatorService;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Webmozart\Assert\Assert;

/**
 * ---.
 */
class LangServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Lang';

    /**
     * @SuppressWarnings("CamelCasePropertyName")
     */
    protected string $module_dir = __DIR__;

    /**
     * @SuppressWarnings("CamelCasePropertyName")
     */
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        // BladeService::registerComponents($module_dir.'/../View/Components', 'Modules\\Lang');
        // $this->registerTranslator();
        $this->translatableComponents();
        $this->registerFilamentLabel();
    }

    public function registerFilamentLabel(): void
    {
        Select::configureUsing(function (Select $component) {
            $component->placeholder(__('filament-forms::components.select.placeholder'));

            return $component;
        });
        Field::configureUsing(function (Field $component) {
            $component = app(AutoLabelAction::class)->execute($component);
            Assert::isInstanceOf($component, Field::class);

            $validationMessages = __('user::validation');
            if (is_array($validationMessages) && [] !== $validationMessages) {
                /** @var array<string, string> $typedMessages */
                $typedMessages = [];
                foreach ($validationMessages as $key => $value) {
                    if (is_string($key) && is_string($value)) {
                        $typedMessages[$key] = $value;
                    }
                }

                if ([] !== $typedMessages) {
                    $component->validationMessages($typedMessages);
                }
            }

            $component = app(AutoLabelAction::class)->execute($component, 'placeholder');
            $component = app(AutoLabelAction::class)->execute($component, 'helperText');

            return app(AutoLabelAction::class)->execute($component, 'description');
        });

        Section::configureUsing(function (Section $component) {
            $component = app(AutoLabelAction::class)->execute($component);

            return app(AutoLabelAction::class)->execute($component, 'heading');
        });

        BaseFilter::configureUsing(function (BaseFilter $component) {
            return app(AutoLabelAction::class)->execute($component);
        });

        Column::configureUsing(function (Column $component) {
            $component = app(AutoLabelAction::class)->execute($component);
            Assert::isInstanceOf($component, Column::class);

            return $component->wrapHeader()->verticallyAlignStart()->grow();
            // ->wrap()
        });

        Step::configureUsing(function (Step $component) {
            return app(AutoLabelAction::class)->execute($component);

            // ->translateLabel()
        });

        Action::configureUsing(function (Action $component) {
            $component = app(AutoLabelAction::class)->execute($component);
            $component = app(AutoLabelAction::class)->execute($component, 'icon');
            $component = app(AutoLabelAction::class)->execute($component, 'tooltip');

            // if (method_exists($component, 'iconButton')) {
            //    // $component->iconButton();
            // }
            /*
            dddx([
            'methods' => get_class_methods($component),
            'getRecord' => $component->getRecord(),
            ]);
            */
            if (method_exists($component, 'getRecord') && null === $component->getRecord()) {
                if (method_exists($component, 'button')) {
                    $component->button();
                }
            }

            // if (method_exists($component, 'icon')) {
            // $component->icon('heroicon-o-plus');
            // }

            // ->translateLabel()
            return $component;
        });

        // Method Filament\Widgets\StatsOverviewWidget\Stat::configureUsing does not exist.
        /*
         * Stat::configureUsing(function (Stat $component) {
         * $component = app(AutoLabelAction::class)->execute($component);
         *
         * // ->translateLabel()
         * return $component;
         * });
         */
    }

    public function registerTranslator(): void
    {
        // @var mixed app->singleton('translator', function (Container $app
            $loader = $app['translation.loader'];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            Assert::string($locale = $app['config']['app.locale'], __FILE__.':'.__LINE__.' - '.class_basename(self::class));
            Assert::string($fallback_locale = $app['config']['app.fallback_locale'], __FILE__.':'.__LINE__.' - '.class_basename(self::class));

            $translatorService = new TranslatorService($loader, $locale);

            $translatorService->setFallback($fallback_locale);

            /*
             * if($app->bound('translation-manager')){
             * $trans->setTranslationManager($app['translation-manager']);
             * }
             */
            return $translatorService;
        });
    }

    protected function translatableComponents(): void
    {
        $components = [Field::class, BaseFilter::class, Placeholder::class, Column::class, Entry::class];
        foreach ($components as $component) {
            $component::configureUsing(function (Component $translatable): void {
                /* @phpstan-ignore method.notFound */
                $translatable->translateLabel();
            });
        }
    }
}
