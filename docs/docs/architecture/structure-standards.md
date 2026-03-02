# Standard di Struttura nel Modulo Notify

## Directory Principali e Convenzioni di Denominazione

| Directory | Scopo | Esempio Classe |
|-----------|-------|----------------|
| `app/Datas/` | **Data Transfer Objects** (usati per trasferire dati tra componenti) | `NetfunSmsData.php` |
| `app/Actions/` | **Azioni** (business logic, usano Spatie Queueable Action) | `SendNetfunSMSAction.php` |
| `app/Services/` | **Servizi** (logica di business complessa, orchestrazione) | `SmsService.php` |
| `app/Channels/` | **Canali di notifica** (implementazioni per Laravel Notifications) | `NetfunChannel.php` |

## Importante: `app/Datas/` vs Altri Pattern

### ✅ CORRETTO: USARE `app/Datas/`

Questo è lo standard stabilito nel modulo Notify per tutti i DTOs:

```
Modules/Notify/app/Datas/NetfunSmsData.php
Modules/Notify/app/Datas/NetfunSmsRequestData.php
Modules/Notify/app/Datas/NetfunSmsResponseData.php
Modules/Notify/app/Datas/SmsData.php
Modules/Notify/app/Datas/NetfunSmsData.php
Modules/Notify/app/Datas/NetfunSmsRequestData.php
Modules/Notify/app/Datas/NetfunSmsResponseData.php
Modules/Notify/app/Datas/SmsData.php
```

### ❌ ERRATO: ALTERNATIVE COMUNI MA ERRATE

- `app/Data/` (singolare) - errore comune ma non standard nel nostro progetto
- `app/DTOs/` - standard in altri progetti ma non nel modulo Notify
- `app/DataObjects/` - non utilizzato in questo contesto

### Perché Questa Distinzione è Importante

1. **Consistenza nel codebase**: Mantenere lo stesso pattern in tutto il progetto
2. **Namespace corretti**: Il namespace deve allinearsi con la directory (`Modules\Notify\Datas`)
3. **PSR-4 Autoloading**: Laravel caricherà le classi solo se i percorsi sono corretti

## Verifica dei Percorsi Prima di Utilizzarli

1. **Usa `find_by_name` per verificare la directory corretta** 
2. **Esamina file simili esistenti per convenzioni di nomenclatura**
3. **Controlla il PSR-4 nel composer.json del modulo** 

### Verificare Sempre le Directory Esistenti

```bash
find Modules/Notify/app -type d -name "Data*"
find Modules/Notify/app -type d -name "Data*"
find Modules/Notify/app -type d -name "Data*"
```

Questo restituirà:
```
Modules/Notify/app/Datas
Modules/Notify/app/Datas/SMS
Modules/Notify/app/Datas
Modules/Notify/app/Datas/SMS
Modules/Notify/app/Datas
Modules/Notify/app/Datas/SMS
```

## Esempi di Importazioni Corrette

```php
use Modules\Notify\Datas\NetfunSmsData;  // ✅ Corretto
use Modules\Notify\Datas\SmsData;        // ✅ Corretto

use Modules\Notify\Data\NetfunSmsData;   // ❌ Errato
use Modules\Notify\DTOs\NetfunSmsData;   // ❌ Errato
use Modules\Notify\App\Datas\SmsData;    // ❌ Errato (App non è parte del namespace)
```

# Standard di Struttura per le Pagine Filament

## Regola di Naming per le Pagine

Tutte le classi nella cartella `app/Filament/Clusters/*/Pages` **devono terminare con `Page`**.

### Motivazione
- Chiarezza: è subito evidente che si tratta di una pagina Filament.
- Coerenza: tutte le pagine sono uniformi e facilmente ricercabili.
- Supporto a strumenti automatici: alcuni strumenti/autodiscovery si basano su questa convenzione.
- Manutenzione: più facile refactoring e ricerca.
- Rispetto delle convenzioni Filament e PSR-4.

### Best Practice
- Prima di committare, verificare che tutte le nuove pagine rispettino questa regola.
- In caso di refactoring, aggiornare sia il nome del file che della classe e tutti i riferimenti.
- Non usare mai nomi generici o ambigui (es. `SendNetfunSMS`), ma sempre `SendNetfunSMSPage`.

---

## Esempio

- File: `SendNetfunSMS.php` → `SendNetfunSMSPage.php`
- Classe: `class SendNetfunSMS extends XotBasePage` → `class SendNetfunSMSPage extends XotBasePage`

# Regola di Estensione delle Pagine Filament

## Non estendere mai direttamente Filament\Pages\Page

Tutte le pagine custom devono estendere una classe base personalizzata (es. `Modules\Xot\Filament\Pages\XotBasePage`) e **non** direttamente `Filament\Pages\Page`.

### Motivazione
- Centralizzazione della logica e delle convenzioni di progetto
- Facilità di manutenzione e aggiornamento
- Coerenza tra tutti i moduli
- Possibilità di override e personalizzazione globale
- Isolamento da breaking changes di Filament

### Best Practice
- Verificare sempre la classe base nelle nuove pagine
- Aggiornare la documentazione e le regole interne in caso di modifica della base
- Aggiungere test statici/CI che segnalano errori di estensione diretta

### Esempio

```php
// ❌ ERRATO
class MyPage extends \Filament\Pages\Page {}

// ✅ CORRETTO
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage {}
```
