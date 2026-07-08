# Architettura Filament : Pattern XotBase

## Introduzione

SaluteOra utilizza un pattern architetturale fondamentale per l'integrazione con Filament: **non estendere mai direttamente** le classi Filament, ma utilizzare sempre le classi wrapper con prefisso `XotBase` fornite dal modulo `Xot`.

Questo documento spiega in dettaglio i motivi architetturali, i vantaggi e l'implementazione di questo pattern.

## Pattern Architetturale

### Struttura delle Classi XotBase

```
Filament\Pages\Page
    ↑
    └── Modules\Xot\Filament\Pages\XotBasePage
        ↑
        └── Modules\Notify\Filament\Clusters\Test\Pages\YourCustomPage
```

### Principi Fondamentali

1. **Separazione degli Strati**: Le classi XotBase fungono da layer di astrazione tra il codice applicativo e il framework Filament
2. **Centralizzazione della Logica**: Funzionalità comuni vengono implementate una sola volta
3. **Uniformità del Codice**: Garanzia di comportamento coerente in tutti i moduli
4. **Estensibilità Controllata**: Possibilità di estendere Filament in modo centralizzato

## Vantaggi Architetturali

| Vantaggio | Descrizione | Impatto |
|-----------|-------------|---------|
| **Traduzione Automatica** | Il trait `TransTrait` fornisce funzionalità di traduzione standardizzate | Evita duplicazione di codice di traduzione in ogni pagina |
| **Gestione Form Integrata** | Implementazione del metodo `form()` e `getFormSchema()` | Standardizza la creazione dei form |
| **State Management** | Gestione dello stato via `$data` centralizzata | Comportamento coerente per tutti i dati dei form |
| **Routing Semplificato** | Logica di routing e generazione URL | Semplifica la navigazione tra le pagine |
| **Capacità Multi-tenant** | Supporto integrato per multi-tenancy | Separazione automatica dei dati per tenant |
| **Gestione Modelli** | Risoluzione automatica dei modelli tramite convenzioni | Riduce il codice boilerplate |

## Analisi Tecnica di XotBasePage

```php
abstract class XotBasePage extends Page implements HasForms
{
    use TransTrait;
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static string $view = 'job::filament.pages.job-monitor';
    protected static ?string $model = null;
    public ?array $data = [];

    // Traduzione automatica
    public static function getNavigationLabel(): string
    {
        return static::transFunc(__FUNCTION__);
    }

    // Form standardizzato
    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }

    // Schema form override nelle classi figlie
    protected function getFormSchema(): array
    {
        return [];
    }
}
```

## Conseguenze del Non Utilizzo

Il mancato utilizzo delle classi XotBase porta a:

1. **Inconsistenza del Codice**: Comportamenti diversi in diverse parti dell'applicazione
2. **Duplicazione**: La stessa logica viene implementata più volte
3. **Testing Difficoltoso**: Più punti da testare per la stessa funzionalità
4. **Manutenzione Complessa**: Modifiche al comportamento richiedono aggiornamenti in multiple location
5. **Incompatibilità con Multi-tenant**: Funzionalità tenant-aware non disponibili

## Casi d'Uso Pratici

### Traduzione Automatica

Prima (❌):
```php
// In ogni classe Page
public static function getNavigationLabel(): string
{
    return __('notify::pages.send_sms.navigation_label');
}
```

Dopo (✅):
```php
// Solo in XotBasePage, riutilizzato in tutte le classi
public static function getNavigationLabel(): string
{
    return static::transFunc(__FUNCTION__);
}
```

### Gestione Form Semplificata

Prima (❌):
```php
// In ogni classe Page
public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
{
    return $form
        ->schema([
            // Schema specifico
        ])
        ->statePath('myCustomState');
}
```

Dopo (✅):
```php
// Solo override getFormSchema() nelle classi figlie
protected function getFormSchema(): array
{
    return [
        // Schema specifico
    ];
}
```

## Best Practices

1. **Mai estendere direttamente** le classi Filament, sempre utilizzare le classi XotBase
2. **Non duplicare metodi** già definiti in XotBase
3. **Seguire le convenzioni di naming** per beneficiare della risoluzione automatica
4. **Utilizzare la traduzione automatica** tramite le chiavi strutturate
5. **Implementare solo i metodi necessari** per la logica specifica della pagina

## Riferimenti

- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Architecture Patterns](https://laravel.com/docs/10.x/architecture)
- [DRY Principle](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself)
- [Wrapper Pattern](https://en.wikipedia.org/wiki/Decorator_pattern)

## Controllo Qualità

Per verificare che tutte le classi seguano questa regola:

```bash
find /var/www/html/saluteora/laravel/Modules -type f -name "*.php" -exec grep -l "extends.*\\\\Filament\\\\Pages\\\\Page" {} \;
```

Le pagine che violano questa regola devono essere immediatamente corrette sostituendo l'estensione con la classe XotBase appropriata.
