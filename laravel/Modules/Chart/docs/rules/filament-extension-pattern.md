# Pattern di Estensione per Componenti Filament

## Regola Fondamentale

**NON estendere MAI direttamente le classi Filament, ma utilizzare sempre le classi base corrispondenti con il prefisso "XotBase" dal modulo Xot.**

## Mappatura delle Classi

| Classe Filament | Classe Base da Utilizzare |
|-----------------|---------------------------|
| `\Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |
| `\Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `\Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `\Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `\Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `\Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `\Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |

## Esempi di Implementazione

### Esempio Errato
```php
// ❌ SCORRETTO
namespace Modules\Notify\Filament\Pages;

use Filament\Pages\Page;

class TestSmtpPage extends Page
{
    // Implementazione...
}
```

### Esempio Corretto
```php
// ✅ CORRETTO
namespace Modules\Notify\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class TestSmtpPage extends XotBasePage
{
    // Implementazione...
}
```

## Motivazione

1. **Personalizzazione Centralizzata**: Le classi XotBase forniscono funzionalità specifiche per <nome progetto>
2. **Aggiornamenti Semplificati**: Quando Filament viene aggiornato, è possibile adattare solo le classi XotBase
3. **Funzionalità Aggiuntive**: Le classi XotBase includono metodi e proprietà aggiuntivi
4. **Gestione delle Dipendenze**: Le classi XotBase gestiscono dipendenze specifiche del progetto
5. **Consistenza del Codice**: Garantisce che tutti i componenti seguano lo stesso pattern

## Errori Comuni da Evitare

### ❌ ERRORE GRAVE: Documentazione in Posizione Sbagliata
```php
// ❌ ERRORE GRAVE - Documentazione widget specifico in cartella generica
/var/www/html/_bases/base_<nome progetto>/docs/widgets/appointment-widget.md

// ✅ CORRETTO - Documentazione widget specifico nella cartella del modulo
/var/www/html/_bases/base_<nome progetto>/laravel/Modules/SaluteMo/docs/appointment-widget.md
```

### ❌ ERRORE GRAVE: Estensione Diretta Filament
```php
// ❌ ERRORE GRAVE
class MyWidget extends Widget
{
    // Implementazione...
}

// ✅ CORRETTO
class MyWidget extends XotBaseWidget
{
    // Implementazione...
}
```

## Regole Critiche per Documentazione

### ⚠️ REGOLA CRITICA: POSIZIONAMENTO DOCUMENTAZIONE

**ERRORE GRAVE**: Posizionare documentazione specifica di un modulo nella cartella docs generica.

### Struttura Corretta:
- **Documentazione Generica**: `/var/www/html/_bases/base_<nome progetto>/docs/`
- **Documentazione Modulo**: `/var/www/html/_bases/base_<nome progetto>/laravel/Modules/{ModuleName}/docs/`

### Quando Usare Quale:
- **Widget/Resource specifici** → **OBBLIGATORIO** cartella docs del modulo
- **Regole generali** → cartella docs generica

## Checklist di Verifica

Prima di implementare qualsiasi componente Filament:

1. **Estende XotBase?** ✅
2. **Documentazione nella cartella corretta?** ✅
3. **Namespace corretto?** ✅
4. **Strict types dichiarato?** ✅
5. **PHPDoc completo?** ✅

## Penalità per Violazioni

- **Prima violazione**: Correzione immediata
- **Violazioni ripetute**: Rischio di perdita di fiducia
- **Violazioni gravi**: Possibile interruzione del lavoro

## Processo di Correzione

Se viene rilevato un errore:

1. **Eliminare immediatamente** il file dalla posizione errata
2. **Ricreare il file** nella posizione corretta
3. **Aggiornare le regole** per evitare ripetizioni
4. **Documentare l'errore** per apprendimento futuro
