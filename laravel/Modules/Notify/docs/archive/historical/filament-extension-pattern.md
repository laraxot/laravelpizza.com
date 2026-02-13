# Pattern di Estensione per Componenti Filament 

Questo documento definisce il pattern di estensione standardizzato per i componenti Filament nel sistema , con particolare attenzione al principio di non estendere mai direttamente le classi Filament.
Questo documento definisce il pattern di estensione standardizzato per i componenti Filament nel sistema <nome progetto>, con particolare attenzione al principio di non estendere mai direttamente le classi Filament.

## Regola Fondamentale

**Non estendere MAI direttamente le classi Filament, ma utilizzare sempre le classi base corrispondenti con il prefisso "XotBase" dal modulo Xot.**

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

## Motivazione

1. **Personalizzazione Centralizzata**: Le classi XotBase forniscono funzionalità e comportamenti personalizzati specifici per , mantenendo la coerenza in tutta l'applicazione.
1. **Personalizzazione Centralizzata**: Le classi XotBase forniscono funzionalità e comportamenti personalizzati specifici per <nome progetto>, mantenendo la coerenza in tutta l'applicazione.

2. **Aggiornamenti Semplificati**: Quando Filament viene aggiornato, è possibile adattare solo le classi XotBase senza dover modificare tutte le implementazioni concrete.

3. **Funzionalità Aggiuntive**: Le classi XotBase possono includere metodi e proprietà aggiuntivi che estendono le funzionalità standard di Filament.

4. **Gestione delle Dipendenze**: Le classi XotBase possono gestire dipendenze specifiche del progetto, come servizi personalizzati o configurazioni.

5. **Consistenza del Codice**: Garantisce che tutti i componenti Filament nell'applicazione seguano lo stesso pattern di implementazione.

## Linee Guida Specifiche per XotBaseResource

Quando si estende `XotBaseResource`, è importante seguire queste regole per evitare errori comuni:

1. **Non ridefinire proprietà gestite dalla classe base**:
   - `protected static ?string $navigationIcon`
   - `protected static ?string $navigationGroup`
   - `protected static ?string $translationPrefix`

2. **Non ridefinire metodi standard a meno che non sia necessario**:
   - `public static function table(Table $table): Table`
   - `public static function getListTableColumns(): array`

Queste proprietà e metodi sono già configurati in `XotBaseResource` per garantire coerenza e centralizzazione della logica. Ridefinirli può portare a comportamenti imprevisti e aumentare la complessità del codice.

**Collegamenti correlati**:
- [Linee Guida XotBaseResource](../Modules/Patient/docs/xot-base-resource-guidelines.md)

## Esempio di Implementazione Corretta

```php
<?php

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class SendSmsPage extends XotBasePage implements HasForms
{
    use InteractsWithForms;
    
    // Implementazione...
}
```

## Esempio di Implementazione ERRATA

```php
<?php

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Filament\Pages\Page; // ❌ NON estendere direttamente questa classe
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class SendSmsPage extends Page implements HasForms // ❌ ERRORE
{
    use InteractsWithForms;
    
    // Implementazione...
}
```

## Vantaggi del Pattern XotBase

### 1. Personalizzazione Centralizzata

Le classi XotBase possono implementare comportamenti specifici per , come:
Le classi XotBase possono implementare comportamenti specifici per <nome progetto>, come:
- Gestione multilingua avanzata
- Integrazione con il sistema di permessi personalizzato
- Logging e auditing specifici
- Temi e stili personalizzati

### 2. Isolamento dagli Aggiornamenti

Quando Filament rilascia nuove versioni:
- Solo le classi XotBase devono essere aggiornate
- Le implementazioni concrete rimangono invariate
- Riduzione del rischio di regressioni

### 3. Estensibilità

Le classi XotBase possono fornire:
- Metodi helper aggiuntivi
- Comportamenti predefiniti
- Integrazione con altri moduli del sistema
- Validazione e trasformazione dei dati

## Implementazione del Pattern

### 1. Identificazione della Classe Base

Prima di implementare un componente Filament, identificare la classe base XotBase corrispondente.

### 2. Estensione della Classe Base

Estendere sempre la classe XotBase appropriata, mai direttamente la classe Filament.

### 3. Utilizzo delle Funzionalità Aggiuntive

Sfruttare i metodi e le proprietà aggiuntive fornite dalla classe XotBase.

## Verifica della Conformità

Prima di ogni commit, verificare che:

1. Nessuna classe estenda direttamente una classe Filament
2. Tutte le classi Filament estendano la corrispondente classe XotBase
3. Vengano utilizzate le funzionalità aggiuntive fornite dalle classi XotBase

## Conclusione

Il pattern di estensione XotBase è fondamentale per la manutenibilità e la coerenza del codice . Seguire questo pattern garantisce che l'applicazione possa evolversi in modo controllato e che le personalizzazioni siano gestite in modo centralizzato.
