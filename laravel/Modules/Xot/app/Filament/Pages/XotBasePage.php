<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page as FilamentPage;
use Filament\Schemas\Schema;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LogicException;
use Modules\Xot\Actions\View\GetViewByClassAction;
use Modules\Xot\Filament\Traits\TransTrait;
use RuntimeException;
use UnitEnum;

/**
 * Classe base astratta per tutte le pagine Filament non legate a risorse specifiche.
 * Fornisce funzionalità comuni e standardizzate per la gestione delle pagine.
 *
 * Implementa:
 * - Sistema di traduzioni integrato
 * - Gestione autorizzazioni
 * - Integrazione con form
 * - Rilevamento intelligente modello
 * - Metodi helper comuni
 *
 * @property ?string $model Il modello associato alla pagina
 * @property array<string, mixed> $data I dati del form
 *
 * @see \Modules\Xot\docs\xotbasepage_implementation.md Documentazione completa
 */
abstract class XotBasePage extends FilamentPage implements HasForms
{
    use InteractsWithForms;
    use TransTrait;

    /**
     * Modello associato alla pagina.
     * Se non specificato, verrà dedotto automaticamente dal nome della classe.
     *
     * @var class-string<Model>|null
     */
    public static ?string $model = null;

    /**
     * Dati del form.
     * Contiene i dati del form durante la gestione della pagina.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * Vista predefinita per la pagina.
     * Deve essere sovrascritta nelle classi figlie.
     */
    protected string $view = '';

    /**
     * Cache timeout per operazioni di cache (in secondi).
     */
    protected static int $cacheTimeout = 3600;

    /**
     * Ottiene il nome del modulo dalla classe.
     * Estrae il nome del modulo dal namespace della classe.
     *
     * @return string Il nome del modulo (es. '<main module>', 'User', ecc.)
     */
    public static function getModuleName(): string
    {
        $namespace = static::class;
        $moduleName = Str::between($namespace, 'Modules\\', '\\Filament');

        if ($moduleName === '') {
            throw new LogicException(sprintf('Cannot extract module name from class %s', static::class));
        }

        return $moduleName;
    }

    /**
     * Ottiene l'etichetta plurale del modello.
     *
     * @return string L'etichetta plurale del modello
     */
    public static function getPluralModelLabel(): string
    {
        return static::trans('plural_label');
    }

    /**
     * Ottiene il gruppo di navigazione.
     *
     * @return UnitEnum|string|null Il gruppo di navigazione
     */
    public static function getNavigationGroup(): UnitEnum|string|null
    {
        return static::transFunc(__FUNCTION__);
    }

    /**
     * Ottiene il modello associato alla pagina.
     * Se non specificato esplicitamente, tenta di dedurlo dal nome della classe.
     *
     * @return class-string<Model> Il namespace completo della classe del modello
     */
    public function getModel(): string
    {
        /** @phpstan-ignore property.staticAccess */
        if (static::$model !== null) {
            /** @phpstan-ignore property.staticAccess */
            /** @var class-string<Model> $modelValue */
            $modelValue = static::$model;

            return $modelValue;
        }

        $moduleName = static::getModuleName();
        $className = class_basename(static::class);

        // Rimuove suffissi comuni per ottenere il nome del modello
        $modelName = Str::of($className)
            ->before('Resource')
            ->before('Page')
            ->before('Dashboard')
            ->before('Report')
            ->trim()
            ->toString();

        if ($modelName === '') {
            throw new LogicException(sprintf('Cannot determine model name from class %s', static::class));
        }

        $modelNamespace = 'Modules\\'.$moduleName.'\\Models\\'.$modelName;

        // Verifica che la classe del modello esista
        if (! class_exists($modelNamespace)) {
            throw new LogicException("Model class {$modelNamespace} does not exist");
        }

        /** @var class-string<Model> $modelNamespace */
        return $modelNamespace;
    }

    /**
     * Configura il form della pagina.
     * Imposta lo schema e il percorso dello stato per il form.
     *
     * @param  \Filament\Schemas\Schema  $schema  Il form da configurare
     * @return \Filament\Schemas\Schema Lo schema configurato
     */
    public function schema(Schema $schema): Schema
    {
        $schema = $schema->components($this->getFormSchema());

        $schema->statePath('data');

        $debounce = $this->getAutosaveDebounce();
        if ($debounce !== null && method_exists($schema, 'autosaveDebounce')) {
            $schema->autosaveDebounce($debounce);
        }

        return $schema;
    }

    /**
     * Ottiene la vista associata alla pagina.
     *
     * @return string Il percorso della vista
     */
    public function getView(): string
    {
        if ($this->view === '') {
            $view = app(GetViewByClassAction::class)->execute(static::class);
            if (view()->exists($view)) {
                return (string) $view;
            }

            // Se non troviamo una vista, lanciamo un'eccezione
            throw new RuntimeException('Nessuna vista trovata per la classe: '.static::class);
        }

        return $this->view;
    }

    /**
     * Ottiene il tempo di debounce per l'autosave in millisecondi.
     * Sovrascrivere nelle classi figlie per modificare questo valore.
     *
     * @return int|null Il tempo di debounce in millisecondi o null per disabilitare l'autosave
     */
    protected function getAutosaveDebounce(): ?int
    {
        return null; // Disabilitato per default
    }

    /**
     * Ottiene l'utente autenticato.
     * Verifica che l'utente sia un'istanza di Model per permettere aggiornamenti.
     *
     * @return Authenticatable&Model L'utente autenticato
     *
     * @throws RuntimeException Se l'utente non è autenticato o non è un'istanza di Model
     */
    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if ($user === null) {
            throw new RuntimeException('Nessun utente autenticato trovato.');
        }

        if (! ($user instanceof Model)) {
            throw new RuntimeException(
                'L\'utente autenticato deve essere un modello Eloquent per permettere aggiornamenti.',
            );
        }

        /** @var Authenticatable&Model $user */
        return $user;
    }

    /**
     * Verifica se l'utente ha l'accesso alla pagina.
     * Utilizza il sistema di autorizzazioni per controllare l'accesso.
     *
     * @throws AuthorizationException Se l'utente non è autorizzato
     */
    protected function authorizeAccess(): void
    {
        $this->authorize('view', static::class);
    }

    /**
     * Verifica se l'utente ha un permesso specifico.
     * Utile per controlli granulari all'interno delle pagine.
     *
     * @param  string  $permission  Il permesso da verificare
     * @return bool True se l'utente ha il permesso, false altrimenti
     */
    protected function hasPermissionTo(string $permission): bool
    {
        $user = $this->getUser();

        // @phpstan-ignore-next-line
        if (! method_exists($user, 'hasPermissionTo')) {
            throw new RuntimeException('Il modello utente deve implementare il metodo hasPermissionTo');
        }

        // Use method_exists to safely call hasPermissionTo
        return $user->hasPermissionTo($permission);
    }

    /**
     * Risolve il percorso della vista.
     *
     * @return string Il percorso della vista
     *
     * @throws RuntimeException Se la vista non esiste
     */
    protected function resolveViewPath(): string
    {
        $view = $this->getView();
        if (view()->exists($view)) {
            return $view;
        }

        throw new RuntimeException("View [{$view}] not found for page: ".static::class);
    }

    /**
     * Ottiene una query builder per il modello associato alla pagina.
     *
     * @return Builder<Model>
     *
     * @throws LogicException Se il modello non è definito
     */
    protected function getQuery(): Builder
    {
        $modelClass = $this->getModel();

        if (! class_exists($modelClass)) {
            throw new LogicException("Model class {$modelClass} does not exist");
        }

        /** @var class-string<Model> $modelClass */
        $instance = new $modelClass();
        if (! ($instance instanceof Model)) {
            throw new LogicException("Class {$modelClass} must extend Eloquent Model");
        }

        return $modelClass::query();
    }

    /**
     * Invalida la cache per il modello specificato.
     *
     * @param  class-string<Model>|null  $modelClass
     */
    protected function invalidateCache(?string $modelClass = null, int|string|null $id = null): void
    {
        // Implementazione custom se necessaria
        // Per ora lasciamo vuoto, può essere implementato nelle classi figlie
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }
}
