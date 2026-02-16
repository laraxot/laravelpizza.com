# Convenzioni di Naming per Filament 

Questo documento definisce le convenzioni di naming standardizzate per i componenti Filament nel sistema SaluteOra, con particolare attenzione alle pagine e alle risorse.

## Convenzioni di Naming per Pagine Filament

### Regola Fondamentale

**Tutte le classi nella cartella `app/Filament/Clusters/*/Pages` devono terminare con il suffisso "Page".**

### Pattern di Naming Corretto

```
{Nome}Page
```

Esempi corretti:
- `SendSmsPage`
- `SendWhatsAppPage`
- `SendTelegramPage`
- `SendEmailPage`
- `TestSmtpPage`

Esempi errati:
- `SendSmsTest` ❌
- `SendWhatsAppTest` ❌
- `SendTelegramTest` ❌

### Motivazione

1. **Coerenza con Filament**: Filament utilizza il suffisso "Page" per tutte le sue pagine native
2. **Chiarezza semantica**: Il suffisso "Page" indica chiaramente che la classe rappresenta una pagina dell'interfaccia utente
3. **Distinzione dai test**: Evita confusione con le classi di test, che tipicamente contengono "Test" nel nome
4. **Conformità PSR**: Segue le convenzioni PSR per la nomenclatura delle classi

## Struttura delle Classi Page

```php
namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class SendSmsPage extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';
    protected static string $view = 'notify::filament.pages.send-sms';
    protected static ?string $cluster = Test::class;
    
    // Resto dell'implementazione...
}
```

## Convenzioni per le Viste Blade

Le viste Blade associate alle pagine Filament devono seguire la convenzione:

```
{modulo}::filament.pages.{nome-kebab-case}
```

Esempi:
- `notify::filament.pages.send-sms`
- `notify::filament.pages.send-whatsapp`
- `notify::filament.pages.send-telegram`

## Convenzioni per le Risorse Filament

### Regola Fondamentale

**Tutte le classi nella cartella `app/Filament/Resources` devono terminare con il suffisso "Resource".**

### Pattern di Naming Corretto

```
{Nome}Resource
```

Esempi corretti:
- `UserResource`
- `ProductResource`
- `OrderResource`

### Pagine di Risorse

Le pagine associate alle risorse devono seguire queste convenzioni:

- `ListRecords` per le pagine di elenco
- `CreateRecord` per le pagine di creazione
- `EditRecord` per le pagine di modifica
- `ViewRecord` per le pagine di visualizzazione

## Convenzioni per i Widget

**Tutte le classi nella cartella `app/Filament/Widgets` devono terminare con il suffisso "Widget".**

### Pattern di Naming Corretto

```
{Nome}Widget
```

Esempi corretti:
- `StatsOverviewWidget`
- `LatestOrdersWidget`
- `CalendarWidget`

## Convenzioni per i Clusters

I cluster devono utilizzare nomi significativi che raggruppano funzionalità correlate:

```php
namespace Modules\Notify\Filament\Clusters;

use Filament\Clusters\Cluster;

class Test extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    
    // Configurazione del cluster...
}
```

## Vantaggi della Standardizzazione

1. **Coerenza**: Tutte le classi seguono lo stesso pattern di naming
2. **Prevedibilità**: È facile prevedere il nome di una classe dato il suo scopo
3. **Manutenibilità**: Facilita la comprensione e la manutenzione del codice
4. **Automazione**: Supporta l'automazione e la generazione di codice

## Regole di Implementazione

1. Utilizzare sempre il suffisso "Page" per le pagine Filament
2. Utilizzare sempre il suffisso "Resource" per le risorse Filament
3. Utilizzare sempre il suffisso "Widget" per i widget Filament
4. Seguire le convenzioni di naming per le viste Blade
5. Estendere le classi base appropriate (`XotBasePage`, `XotBaseResource`, ecc.)

## Verifica della Conformità

Prima di ogni commit, verificare che:

1. Tutte le classi nella cartella `app/Filament/Clusters/*/Pages` terminino con "Page"
2. Tutte le classi nella cartella `app/Filament/Resources` terminino con "Resource"
3. Tutte le classi nella cartella `app/Filament/Widgets` terminino con "Widget"
4. Tutte le viste Blade seguano la convenzione di naming
