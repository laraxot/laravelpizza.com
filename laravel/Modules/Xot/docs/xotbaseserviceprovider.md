# XotBaseServiceProvider

## Panoramica

XotBaseServiceProvider è la classe base astratta per tutti i ServiceProvider dei moduli nel sistema. Estende `Illuminate\Support\ServiceProvider` e implementa funzionalità comuni per la registrazione di componenti, configurazioni, traduzioni e altro.

## Proprietà Fondamentali

```php
public string $name = '';           // Nome del modulo (DEVE essere public)
public string $nameLower = '';      // Nome del modulo in minuscolo
protected string $module_dir = __DIR__;    // Directory del modulo
protected string $module_ns = __NAMESPACE__; // Namespace del modulo
```

### Importanza della Visibilità

- `$name` e `$nameLower` DEVONO essere `public` perché vengono utilizzati da classi figlie
- La visibilità non può essere modificata nelle classi che estendono XotBaseServiceProvider
- Modificare la visibilità causerà un errore PHP: "Access level ... must be public (as in class XotBaseServiceProvider)"

## Metodi Principali

### boot()
```php
public function boot(): void
{
    $this->registerTranslations();
    $this->registerViews();
    $this->loadMigrationsFrom($this->module_dir.'/../Database/Migrations');
    $this->registerLivewireComponents();
    $this->registerBladeComponents();
    $this->registerCommands();
}
```

Responsabilità:
- Registrazione traduzioni
- Registrazione viste
- Caricamento migrazioni
- Registrazione componenti Livewire
- Registrazione componenti Blade
- Registrazione comandi

### register()
```php
public function register(): void
{
    $this->nameLower = Str::lower($this->name);
    $this->module_ns = collect(explode('\\', $this->module_ns))->slice(0, -1)->implode('\\');
    $this->app->register($this->module_ns.'\Providers\RouteServiceProvider');
    $this->app->register($this->module_ns.'\Providers\EventServiceProvider');
    $this->registerConfig();
    $this->registerBladeIcons();
}
```

Responsabilità:
- Inizializzazione proprietà del modulo
- Registrazione RouteServiceProvider
- Registrazione EventServiceProvider
- Registrazione configurazioni
- Registrazione icone Blade

## Best Practices

1. **Non Modificare la Visibilità**
   - Mantenere `public` per `$name` e `$nameLower`
   - Non cambiare la visibilità dei metodi ereditati

2. **Evitare Override Non Necessari**
   - Non sovrascrivere metodi se non si aggiunge funzionalità
   - Chiamare sempre `parent::method()` quando si sovrascrive

3. **Configurazione Corretta**
   - Impostare sempre `$name` nel costruttore
   - Verificare che `$module_dir` e `$module_ns` siano corretti

## Esempio di Implementazione Corretta

```php
namespace Modules\Notify\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class NotifyServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Notify';
    
    public function boot(): void
    {
        parent::boot();
        // Aggiungi funzionalità specifiche qui
    }
}
```

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura dei Provider](../../../docs/architecture/providers.md)
- [Struttura dei Moduli](../../../docs/architecture/modules.md)

### Collegamenti ai Moduli
- [Notify ServiceProvider](../../Notify/docs/service-provider.md)
- [User ServiceProvider](../../User/docs/service-provider.md)

## Note Importanti

1. La proprietà `$name` è fondamentale e DEVE essere `public`
2. Non modificare mai la visibilità delle proprietà/metodi ereditati
3. Seguire sempre il pattern di registrazione standard
4. Documentare ogni modifica o estensione
5. Mantenere la coerenza tra i moduli 
## Collegamenti tra versioni di XotBaseServiceProvider.md
* [XotBaseServiceProvider.md](../../../../docs/moduli/xot/XotBaseServiceProvider.md)

## Correzione, motivazione e miglioramenti (2025-05-13)

### Motivazione
- Garantire robustezza, coerenza e manutenibilità tra tutti i moduli.
- Prevenire errori di visibilità e override errati.
- Facilitare l'estensione e la personalizzazione dei provider nei moduli.
- Rendere la classe conforme a PHPStan livello 10 e alle best practices Laraxot.

### Azioni e pattern applicati
- **Tipizzazione e PHPDoc**: tutti i metodi pubblici e protected devono avere PHPDoc dettagliato e tipi di ritorno espliciti.
- **Centralizzazione dei fallback**: la logica di fallback per path e namespace va centralizzata in metodi protected riutilizzabili.
- **Gestione errori e logging**: loggare i casi di fallback e le eccezioni non bloccanti.
- **Pattern di override**: ogni override deve chiamare sempre `parent::method()`. Vietato cambiare la visibilità delle proprietà/metodi ereditati.
- **Testabilità**: usare metodi protected per facilitare il mocking nei test.
- **Registrazione icone Blade**: seguire il pattern documentato in [registerBladeIcons.md](./registerBladeIcons.md), con fallback e validazione dei path.

### Consigli di miglioramento
- Centralizzare la gestione dei path (views, lang, svg, ecc.) in un helper o trait.
- Aggiungere logging per fallback e eccezioni non bloccanti.
- Rafforzare la tipizzazione e la documentazione.
- Fornire esempi di override corretti e sbagliati.
- Implementare test di integrazione per la registrazione delle risorse.
- Introdurre versioning e validazione per le icone SVG.

### Esempi di override

**Corretto:**
```php
public function boot(): void
{
    parent::boot();
    // Estensioni specifiche...
}
```

**Sbagliato:**
```php
public function boot(): void
{
    // parent::boot() mancante!
    // ...
}
```

### Collegamenti
- [Best practices per i provider](./service-provider-best-practices.md)
- [Registrazione icone Blade](./registerBladeIcons.md)

## Gestione dei Path delle Traduzioni

**Regola:**
Per la registrazione delle traduzioni, utilizzare sempre l'action `GetModulePathByGeneratorAction` per ottenere il path della cartella `lang` del modulo. Non usare mai direttamente `module_path` o path hardcoded.

**Motivazione:**
- Garantisce coerenza e robustezza tra i moduli
- Permette fallback e validazione centralizzata
- Facilita la manutenzione e l'evoluzione della struttura dei moduli

**Esempio corretto:**
```php
try {
    $langPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'lang');
    \Webmozart\Assert\Assert::string($langPath, 'Percorso lang non valido');
    $this->loadTranslationsFrom($langPath, $this->nameLower);
} catch (\Throwable $e) {
    $fallbackPath = base_path('Modules/'.$this->name.'/lang');
    $this->loadTranslationsFrom($fallbackPath, $this->nameLower);
}
```

**Esempio sbagliato:**
```php
$langPath = module_path($this->name, 'lang');
$this->loadTranslationsFrom($langPath, $this->nameLower);
```

**Nota:**
Applicare la stessa regola per la registrazione delle traduzioni JSON.

**Collegamento:**
Vedi anche [registerBladeIcons.md](./registerBladeIcons.md) per la gestione centralizzata dei path.

## Console Commands: Religione, Politica, Filosofia, Zen

### Principio
La registrazione dei comandi console è automatica: ogni comando presente in Console/Commands viene autoregistrato dalla base.

### Cosa NON fare
**NON** aggiungere mai manualmente:
```php
$this->commands([
    ...
]);
```

### Cosa fare
- Definire i comandi nella cartella Console/Commands
- Lasciare che la base li autoregistri

### Motivazione
- DRY, KISS, Zen, Politica, Filosofia: meno codice, più coerenza, meno errori
- La responsabilità è centralizzata

### Collegamenti correlati
- [Regola DRY](../../../.cursor/rules/dry.mdc)
- [Regola Zen](../../../.windsurf/rules/zen.mdc)
- [Regola KISS](../../../.windsurf/rules/kiss.mdc)
- [Politica](../../../.windsurf/rules/politica.mdc)
- [Filosofia](../../../.windsurf/rules/filosofia.mdc)

### Zen finale
> "Il miglior comando è quello che non devi mai registrare a mano."

