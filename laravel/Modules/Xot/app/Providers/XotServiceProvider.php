<?php

declare(strict_types=1);

namespace Modules\Xot\Providers;

use Composer\Autoload\ClassLoader;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Exports\Jobs\CreateXlsxFile;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\TimePicker;
use Filament\Infolists\Components\Entry;
use Filament\Support\Components\Component;
use Filament\Support\Facades\FilamentColor;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Modules\Xot\Actions\Composer\RegisterRuntimePsr4NamespacesAction;
use Modules\Xot\Actions\Factory\GetFactoryAction;
use Modules\Xot\Actions\PaDesignColorsAction;
use Modules\Xot\Console\Commands\BuildTestSqliteCommand;
use Modules\Xot\Console\Commands\CheckAccessorTwinsCommand;
use Modules\Xot\Console\Commands\GenerateFilamentResources;
use Modules\Xot\Console\Commands\ModuleLinkCommand;
use Modules\Xot\Console\Commands\SymlinkPublishCommand;
use Modules\Xot\Console\Commands\ThemeLinkCommand;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Exports\Jobs\XotCreateXlsxFile;
use Modules\Xot\Filament\Traits\HasXotTable;
use Modules\Xot\View\Composers\XotComposer;
use Webmozart\Assert\Assert;

use function Safe\realpath;

/**
 * Class XotServiceProvider.
 */
class XotServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Xot';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    #[\Override]
    public function boot(): void
    {
        parent::boot();
        $this->redirectSSL();
        $this->registerViewComposers();
        $this->registerEvents();
        // $this->registerExceptionHandler(); // guardare come fa sentry
        $this->registerTimezone();
        $this->registerFilamentMacros();
        $this->registerPaFilamentColors();
        $this->registerBulkDeleteAuthorization();
        $this->registerXotLivewireComponents();
        $this->registerProviders();
    }

    #[\Override]
    public function register(): void
    {
        $this->registerRuntimePsr4Autoload();
        parent::register();
        $this->registerConfig();

        // $this->registerExceptionHandlersRepository();
        // $this->extendExceptionHandler();
        $this->registerCommands();
        $this->registerExportJobs();
        $this->registerFactoryNameResolver();
    }

    /**
     * `CanExportRecords` risolve il job xlsx con `app(CreateXlsxFile::class, [...])`:
     * il binding lo sostituisce con `XotCreateXlsxFile`, che per gli exporter
     * `XotBaseExporter` legge il CSV intermedio con lo stesso escape con cui
     * `XotExportCsv` lo scrive (story Ptv/5.165); per gli altri delega al vendor.
     */
    private function registerExportJobs(): void
    {
        $this->app->bind(CreateXlsxFile::class, XotCreateXlsxFile::class);
    }

    /**
     * `Model::factory()` risolve la factory con `GetFactoryAction` (`Modules\<M>\Models\X` ->
     * `Modules\<M>\Database\Factories\XFactory`), ma `Factory::factoryForModel()` (relazioni magiche
     * `has*`/`for*`) e Larastan usano il resolver di Laravel, che per i modelli dei moduli punta a
     * `Database\Factories\XFactory`, classe inesistente. Un solo resolver allinea runtime e analisi statica:
     * `Team::factory()->create()` e' `Team`, non `mixed`. Fuori da `Modules\` vale la convenzione Laravel.
     */
    private function registerFactoryNameResolver(): void
    {
        Factory::guessFactoryNamesUsing(static function (string $modelName): string {
            if (str_starts_with($modelName, 'Modules\\')) {
                $factoryClass = (new GetFactoryAction())->getFactoryClass($modelName);
            } else {
                $modelsNamespace = app()->getNamespace().'Models\\';
                $relativeName = Str::startsWith($modelName, $modelsNamespace)
                    ? Str::after($modelName, $modelsNamespace)
                    : Str::after($modelName, app()->getNamespace());
                $factoryClass = Factory::$namespace.$relativeName.'Factory';
            }

            // Factory inesistente: `Factory::class` (astratta) al posto di una classe fantasma, cosi' il
            // tipo resta `class-string<Factory>`; chi la usa fallisce comunque ("Cannot instantiate abstract").
            return is_a($factoryClass, Factory::class, true) ? $factoryClass : Factory::class;
        });
    }

    public function registerProviders(): void
    {
        // $this->app->register(Filament\ModulesServiceProvider::class);
    }

    private function registerRuntimePsr4Autoload(): void
    {
        $autoloadPath = base_path('vendor/autoload.php');

        if (! is_file($autoloadPath)) {
            return;
        }

        $loader = require $autoloadPath;

        if (! $loader instanceof ClassLoader) {
            return;
        }

        (new RegisterRuntimePsr4NamespacesAction())->execute($loader);
    }

    public function registerTimezone(): void
    {
        Assert::string(
            $timezone = config('app.timezone') ?? 'Europe/Berlin',
            '['.__LINE__.']['.class_basename($this).']',
        );
        Assert::string(
            $date_format = config('app.date_format') ?? 'd/m/Y',
            '['.__LINE__.']['.class_basename($this).']',
        );
        Assert::string($locale = config('app.locale') ?? 'it', '['.__LINE__.']['.class_basename($this).']');

        app()->setLocale($locale);
        Carbon::setLocale($locale);
        date_default_timezone_set($timezone);

        DateTimePicker::configureUsing(fn (DateTimePicker $component) => $component->timezone($timezone));
        DatePicker::configureUsing(
            fn (DatePicker $component) => $component->timezone($timezone)->displayFormat($date_format),
        );
        TimePicker::configureUsing(fn (TimePicker $component) => $component->timezone($timezone));
        TextColumn::configureUsing(fn (TextColumn $column) => $column->timezone($timezone));
    }

    /**
     * Eliminazione di gruppo: Filament autorizza una volta sola con `deleteAny()`, che 35 policy del progetto non definiscono (audit DCP-181, A-1).
     * Un solo punto per tutti i siti, presenti e futuri: ogni record passa da `delete()` se il modello ha una policy.
     */
    public function registerBulkDeleteAuthorization(): void
    {
        DeleteBulkAction::configureUsing(
            fn (DeleteBulkAction $action): DeleteBulkAction => $action->authorizeIndividualRecords(HasXotTable::bulkDeleteRecordAuthorization()),
        );
    }

    /**
     * Palette PA su widget FO (login, wizard) senza panel attivo — allineata ai panel admin.
     */
    public function registerPaFilamentColors(): void
    {
        FilamentColor::register(app(PaDesignColorsAction::class)->filamentPalette());
    }

    public function registerFilamentMacros(): void
    {
        // Macro temporarily disabled due to compatibility issues with Filament version
        // TODO: Re-implement when compatible with current Filament version
        /*
        TextInput::macro('generateSlug', function () {
            $this->live(onBlur: true)->afterStateUpdated(function (string $operation, string $state, Set $set): void {
                if ($operation === 'create') {
                    return;
                }
                $set('slug', Str::slug($state));
            });
            return $this;
        });
        */
    }

    /*
     * @see https://github.com/cerbero90/exception-handler
     * --  guardare come fa sentry
     * public function registerExceptionHandler(): void
     * {
     * $exceptionHandler = $this->app->make(ExceptionHandler::class);
     * if ($exceptionHandler instanceof HandlerDecorator) {
     * $exceptionHandler->reporter(
     * static function (\Throwable $e): void {
     * $data = (new WebhookErrorFormatter($e))->format();
     * if ($e instanceof AuthenticationException || $e instanceof NotFoundHttpException) {
     * return;
     * }
     *
     * if (is_string(config('logging.channels.slack_errors.url'))
     * && mb_strlen(config('logging.channels.slack_errors.url')) > 5) {
     * Log::channel('slack_errors')
     * ->error($e->getMessage(), $data);
     * }
     * }
     * );
     * }
     * }
     */

    #[\Override]
    public function registerConfig(): void
    {
        // $config_file = realpath(__DIR__.'/../config/metatag.php');
        // $this->mergeConfigFrom($config_file, 'metatag');
    }

    public function loadHelpersFrom(string $path): void
    {
        $files = File::files($path);
        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $realPath = $file->getRealPath();
            if ($realPath === false) {
                continue;
            }

            include_once $realPath;
        }
    }

    /**
     * Register console commands.
     */
    public function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateFilamentResources::class,
                CheckAccessorTwinsCommand::class,
                BuildTestSqliteCommand::class,
                ThemeLinkCommand::class,
                ModuleLinkCommand::class,
                SymlinkPublishCommand::class,
                // \Modules\Xot\Console\Commands\OptimizeFilamentMemoryCommand::class,
            ]);
        }
    }

    protected function translatableComponents(): void
    {
        // Placeholder è deprecato in favore di TextEntry (state()): Entry::class copre già
        // TextEntry e le altre entry infolist, quindi non serve registrarlo separatamente.
        $components = [Field::class, BaseFilter::class, Column::class, Entry::class];
        foreach ($components as $component) {
            $component::configureUsing(function (Component $translatable): void {
                if (method_exists($translatable, 'translateLabel')) {
                    $translatable->translateLabel();
                }
            });
        }
    }

    /*
     * Register the custom exception handlers repository.
     * -- guardare come fa sentry
     * private function registerExceptionHandlersRepository(): void
     * {
     * $this->app->singleton(HandlersRepository::class, HandlersRepository::class);
     * }
     */
    /*
     * Extend the Laravel default exception handler.
     *
     * @see https://github.com/cerbero90/exception-handler/blob/master/src/Providers/ExceptionHandlerServiceProvider.php
     * -- guardare come fa sentry
     * private function extendExceptionHandler(): void
     * {
     * $this->app->extend(
     * ExceptionHandler::class,
     * static function (ExceptionHandler $handler, $app) {
     * return new HandlerDecorator($handler, $app[HandlersRepository::class]);
     * }
     * );
     * }
     */
    private function redirectSSL(): void
    {
        if (app()->runningInConsole()) {
            return;
        }

        // --- meglio ficcare un controllo anche sull'env

        if (
            // config('xra.forcessl') && (isset($_SERVER['SERVER_NAME']) && 'localhost' !== $_SERVER['SERVER_NAME']
            // && isset($_SERVER['REQUEST_SCHEME']) && 'http' === $_SERVER['REQUEST_SCHEME'])
            XotData::make()->forceSSL()
        ) {
            URL::forceScheme('https');

            /*
             * da fare in htaccess
             */
            // if (! request()->secure() /* && in_array(env('APP_ENV'), ['stage', 'production']) */) {
            //    exit(redirect()->secure(request()->getRequestUri()));
            // }
        }
    }

    /**
     * Undocumented function.
     *
     * @see https://medium.com/@dobron/running-laravel-ide-helper-generator-automatically-b909e75849d0
     */
    private function registerEvents(): void
    {
        Event::listen(MigrationsEnded::class, static function (): void {
            // Artisan::call('ide-helper:models -r -W');
        });
    }

    private function registerViewComposers(): void
    {
        View::composer('*', XotComposer::class);
    }

    /**
     * Register Xot specific Livewire components.
     */
    private function registerXotLivewireComponents(): void
    {
        // Temporaneamente disabilitato per debug
        // if (class_exists(\Livewire\Livewire::class)) {
        //     try {
        //         \Livewire\Livewire::component(
        //             'modules.xot.filament.widgets.modules-overview-widget',
        //             \Modules\Xot\Filament\Widgets\ModulesOverviewWidget::class
        //         );
        //         \Log::debug('ModulesOverviewWidget registrato correttamente');
        //     } catch (\Exception $e) {
        //         \Log::error('Errore nella registrazione ModulesOverviewWidget: ' . $e->getMessage());
        //     }
        // }
    }
} // end class
