<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources;

use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\Resource as FilamentResource;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Components\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Modules\Media\Actions\GetAttachmentsSchemaAction;
use Modules\Xot\Actions\Filament\GetResourceClassNameByModelClassAction;
use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Actions\ModelClass\CountAction;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Webmozart\Assert\Assert;

use function Safe\glob;

/**
 * @method static string getUrl(?string $name = null, array<string, mixed> $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?\Illuminate\Database\Eloquent\Model $tenant = null, bool $shouldGuessMissingParameters = false, ?string $configuration = null)
 */
abstract class XotBaseResource extends FilamentResource
{
    use NavigationLabelTrait;

    protected static ?string $model = null;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    /**
     * @param  array<string, bool|float|int|string|null>  $params
     */
    public static function trans(string $key, bool $exceptionIfNotExist = false, array $params = []): string
    {
        $tmp = static::getKeyTrans($key);
        $res = trans($tmp, $params);

        if (is_string($res)) {
            if ($exceptionIfNotExist && $res === $tmp) {
                throw new \Exception('['.__LINE__.']['.class_basename(self::class).']');
            }

            return $res;
        }

        if (is_array($res)) {
            $first = current($res);
            if (is_string($first) || is_numeric($first)) {
                return is_string($first) ? $first : ((string) $first);
            }
        }

        return 'fix:'.$tmp;
    }

    public static function getModuleName(): string
    {
        return Str::before(Str::after(static::class, 'Modules\\'), '\\');
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    /**
     * Modelli derivati dal nome della Resource, memoizzati per classe.
     *
     * La property `$model` di Filament e' dichiarata sul parent: una Resource che non la
     * ridichiara scrive nello slot condiviso da tutte le altre nella stessa condizione
     * (457 su 571 in questo progetto), e la prima risolta detta il modello a tutte.
     * La mappa indicizzata per `static::class` memoizza senza contaminare.
     *
     * @var array<class-string, class-string<Model>>
     */
    private static array $resolvedModels = [];

    /**
     * @return class-string<Model>
     */
    public static function getModel(): string
    {
        if (static::$model !== null) {
            $res = static::$model;
            Assert::subclassOf(
                $res,
                Model::class,
                \sprintf('Class %s must extend Eloquent Model', $res),
            );

            return $res;
        }
        if (isset(self::$resolvedModels[static::class])) {
            return self::$resolvedModels[static::class];
        }

        $moduleName = static::getModuleName();
        $modelName = Str::before(class_basename(static::class), 'Resource');
        $res = 'Modules\\'.$moduleName.'\Models\\'.$modelName;
        Assert::classExists($res, \sprintf('Model class %s does not exist', $res));
        Assert::subclassOf(
            $res,
            Model::class,
            \sprintf('Class %s must extend Eloquent Model', $res),
        );
        self::$resolvedModels[static::class] = $res;

        return $res;
    }

    /**
     * @return array<int|string, \Filament\Schemas\Components\Component>
     *                                                                   DEVE ESSERE FINAL !!
     */
    final public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Bridge di migrazione — schema form ancora sulla Resource.
     * La classe `{Model}Form` è **obbligatoria** ({@see static::getFormClass()}):
     * se manca si solleva errore. Old serve solo a spostare il contenuto dentro
     * `Schemas\{Model}Form::getFormSchema()`; a migrazione chiusa si rimuove.
     *
     * ATTENZIONE: NON rendere `getFormSchema()` astratto senza prima migrare i
     * ~100 consumer che ancora implementano solo `getFormSchemaOld()` (grep
     * `getFormSchemaOld` su `Modules/*`) — vedi docs/chat/STOP-*-getformschema-*.md.
     *
     * NON final: ~55 Resource in Modules/* sovrascrivono questo metodo durante
     * la migrazione. Con `final` ogni override fallisce al bootstrap
     * ("Cannot override final method") e blocca anche PHPStan.
     *
     * @return array<int|string, \Filament\Schemas\Components\Component>
     */
    public function getFormSchemaOld(): array
    {
        return [];
    }

    /**
     * @return class-string<XotBaseResourceForm>
     */
    public static function getFormClass(): string
    {
        // return AuthorForm::configure($schema); -- esempio della doc Filament, tenuto come riferimento.
        $resource = static::getResourceBaseName();

        return static::resolveResourcePartClass(
            folder: 'Schemas',
            byModel: class_basename(static::getModel()).'Form',
            byResource: $resource.'Form',
            baseClass: XotBaseResourceForm::class,
        );
    }

    final public static function form(Schema $schema): Schema
    {
        $class = static::getFormClass();
        $configured = $class::configure($schema);
        Assert::isInstanceOf($configured, Schema::class);

        return $configured;
    }

    /**
     * @return class-string<XotBaseResourceTable>
     */
    public static function getTableClass(): string
    {
        $resource = static::getResourceBaseName();

        return static::resolveResourcePartClass(
            folder: 'Tables',
            byModel: Str::plural(class_basename(static::getModel())).'Table',
            byResource: Str::plural($resource).'Table',
            baseClass: XotBaseResourceTable::class,
        );
    }

    public static function table(Table $table): Table
    {
        $class = static::getTableClass();
        $configured = $class::configure($table);
        Assert::isInstanceOf($configured, Table::class);

        return $configured;
    }

    public static function getFormColumns(): int
    {
        return 1;
    }

    /**
     * Schema dell'infolist: tutte le risorse devono delegare qui.
     *
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    public function getInfolistSchema(): array
    {
        return [];
    }

    /**
     * @return class-string<XotBaseResourceInfolist>
     */
    public static function getInfolistClass(): string
    {
        // return AuthorForm::configure($schema); -- esempio della doc Filament, tenuto come riferimento.
        $resource = static::getResourceBaseName();

        return static::resolveResourcePartClass(
            folder: 'Schemas',
            byModel: class_basename(static::getModel()).'Infolist',
            byResource: $resource.'Infolist',
            baseClass: XotBaseResourceInfolist::class,
        );
    }

    /**
     * Unico punto di risoluzione di Form, Table e Infolist di una Resource. Tre tentativi:
     *
     * 1. nome dal modello: `{Resource}\Tables\{ModelPlurale}Table` (regola storica);
     * 2. nome dalla Resource: `SchedaPoResource` => `SchedaPoForm`, `SchedaPosTable`. Serve quando
     *    piu' Resource condividono un modello (le varianti Progressioni di `Scheda`): il nome dal
     *    modello sarebbe uguale per tutte;
     * 3. la Resource registrata per il modello (`Filament::getModelResource()`), cioe' la prima
     *    in ordine di discovery.
     *
     * Prima mancava il passo 2: le varianti finivano al passo 3, che restituiva `SchedaDipResource`
     * anche per `SchedaPoResource`, e la pagina si fermava su un Assert.
     *
     * @see Modules/Xot/docs/stories/resource-part-class-by-resource-name.story.md
     *
     * @template TPart of object
     *
     * @param  class-string<TPart>  $baseClass
     * @return class-string<TPart>
     */
    protected static function resolveResourcePartClass(string $folder, string $byModel, string $byResource, string $baseClass): string
    {
        foreach ([$byModel, $byResource] as $name) {
            $class = static::class.'\\'.$folder.'\\'.$name;
            if (class_exists($class)) {
                Assert::subclassOf($class, $baseClass);

                /** @var class-string<TPart> $class */
                return $class;
            }
        }

        $resource = app(GetResourceClassNameByModelClassAction::class)->execute(static::getModel());
        $class = $resource.'\\'.$folder.'\\'.$byModel;
        Assert::subclassOf($class, $baseClass);

        /** @var class-string<TPart> $class */
        return $class;
    }

    /**
     * `SchedaPoResource` => `SchedaPo`.
     */
    protected static function getResourceBaseName(): string
    {
        return Str::beforeLast(class_basename(static::class), 'Resource');
    }

    /**
     * Metodo finale: obbliga l'uso di getInfolistSchema().
     */
    final public static function infolist(Schema $schema): Schema
    {
        $class = static::getInfolistClass();
        $configured = $class::configure($schema);
        Assert::isInstanceOf($configured, Schema::class);

        return $configured;
    }

    /**
     * @return array<string, mixed>
     */
    public static function extendTableCallback(): array
    {
        return [];
    }

    /**
     * Get form extension callbacks.
     *
     * @return array<string, mixed>
     */
    public static function extendFormCallback(): array
    {
        return [];
    }

    public static function getNavigationBadge(): ?string
    {
        try {
            $count = app(CountAction::class)->execute(static::getModel());

            return number_format($count, 0).'';
        } catch (\Throwable $e) {
            report($e);

            return '--';
        }
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        $prefix = static::class.'\Pages\\';
        $name = Str::of(class_basename(static::class))->before('Resource')->toString();
        $plural = Str::of($name)->plural()->toString();
        $index = Str::of($prefix)->append('List'.$plural)->toString();
        $create = Str::of($prefix)->append('Create'.$name.'')->toString();
        $edit = Str::of($prefix)->append('Edit'.$name.'')->toString();
        $view = Str::of($prefix)->append('View'.$name.'')->toString();

        /** @var class-string<Page> $index */
        $index = $index;
        /** @var class-string<Page> $create */
        $create = $create;
        /** @var class-string<Page> $edit */
        $edit = $edit;
        /** @var class-string<Page> $view */
        $view = $view;

        $pages = [];
        $pages['index'] = $index::route('/');
        $pages['create'] = $create::route('/create');
        $pages['edit'] = $edit::route('/{record}/edit');

        if (class_exists($view)) {
            $pages['view'] = $view::route('/{record}');
        }

        return $pages;
    }

    /**
     * @return array<class-string<RelationManager>|RelationGroup|RelationManagerConfiguration>
     */
    public static function getRelations(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $filename = $reflector->getFileName();
        Assert::string($filename, __FILE__.':'.__LINE__.' - '.class_basename(self::class));

        $path = Str::of($filename)
            ->before('.php')
            ->append(\DIRECTORY_SEPARATOR)
            ->append('RelationManagers')
            ->toString();

        $filesResult = glob($path.\DIRECTORY_SEPARATOR.'*RelationManager.php');

        // PHPStan: glob() with valid pattern returns array
        if ($filesResult === []) {
            return [];
        }

        /** @var array<class-string<RelationManager>> $res */
        $res = [];
        foreach ($filesResult as $file) {
            if (! \is_string($file)) {
                continue;
            }
            $className = Str::of($file)
                ->after('RelationManagers'.\DIRECTORY_SEPARATOR)
                ->before('.php')
                ->prepend(static::class.'\RelationManagers\\')
                ->toString();

            if (class_exists($className)) {
                Assert::subclassOf($className, RelationManager::class);
                $res[] = $className;
            }
        }

        return $res;
    }

    public static function getWizardSubmitAction(): Htmlable
    {
        /** @var view-string $submit_view */
        $submit_view = 'pub_theme::filament.wizard.submit-button';
        if (! View::exists($submit_view)) {
            throw new \Exception("View {$submit_view} does not exist");
        }
        $render = View::make($submit_view)->render();

        return new HtmlString($render);
    }

    /**
     * Get attachments schema for forms.
     *
     * @return array<int, Component>
     */
    public static function getAttachmentsSchema(bool $multiple = true): array
    {
        $model = static::getModel();
        if (! method_exists($model, 'getAttachments')) {
            return [];
        }
        $attachments = $model::getAttachments();
        if (! \is_array($attachments)) {
            return [];
        }

        /** @var array<int, string> $safeAttachments */
        $safeAttachments = array_values(array_filter($attachments, 'is_string'));

        $disk = 'attachments';

        /** @var array<int, Component> $schema */
        $schema = app(GetAttachmentsSchemaAction::class)->execute($safeAttachments, $disk);

        return $schema;
    }

    protected static function getKeyTrans(string $key): string
    {
        /** @var string */
        $transKey = app(GetTransKeyAction::class)->execute(static::class);

        $key = $transKey.'.'.$key;
        $key = Str::of($key)->replace('.cluster.pages.', '.')->toString();
        if (Str::startsWith($key, 'edit_')) {
            $key = Str::after($key, 'edit_');
        }
        if (Str::endsWith($key, '_widget')) {
            $key = Str::beforeLast($key, '_widget');
        }

        return $key;
    }

    protected static function getStepByName(string $name): Step
    {
        $methodName = Str::of($name)
            ->snake()
            ->studly()
            ->prepend('get')
            ->append('Schema')
            ->toString();

        if (method_exists(static::class, $methodName)) {
            $schemaResult = static::$methodName();
            /** @var array<Htmlable|string> $schemaComponents */
            $schemaComponents = \is_array($schemaResult) ? array_values($schemaResult) : [];

            return Step::make($name)->schema($schemaComponents);
        }

        return Step::make($name)->schema([]);
    }
}
