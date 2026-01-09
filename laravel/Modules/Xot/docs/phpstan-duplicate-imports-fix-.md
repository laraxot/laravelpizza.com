# PHPStan Duplicate Imports Fix - 2026-01-05

## Analisi Errori PHPStan Modulo Xot

Data analisi: 2026-01-05
PHPStan Level: max
Comando eseguito: `./vendor/bin/phpstan analyse Modules/Xot --memory-limit=-1`

## Errori Identificati

### 1. CopyAction.php - Fatal Error (Priorità MASSIMA)
**File**: `Modules/Xot/app/Actions/File/CopyAction.php`
**Riga**: 10
**Errore**: `Cannot use Illuminate\Support\Facades\Log as Log because the name is already in use`

**Causa**: Import duplicato di `Log` facade alle righe 7 e 10

```php
use Illuminate\Support\Facades\Log;  // Riga 7
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;  // Riga 10 - DUPLICATO!
```

**Correzione**: Rimuovere la riga 10

**Impatto**: FATALE - Blocca completamente l'esecuzione di PHPStan (exit code 255)

---

### 2. GetProductsArrayDummyAction.php - Duplicate Imports
**File**: `Modules/Xot/app/Actions/Dummy/GetProductsArrayDummyAction.php`
**Riga**: 10
**Errore**: `Cannot use GuzzleHttp\Promise\PromiseInterface as PromiseInterface because the name is already in use`

**Causa**: Import duplicati alle righe 7-11

```php
use GuzzleHttp\Promise\PromiseInterface;  // Riga 7
use Illuminate\Http\Client\Response;      // Riga 8
use Exception;
use GuzzleHttp\Promise\PromiseInterface;  // Riga 10 - DUPLICATO!
use Illuminate\Http\Client\Response;      // Riga 11 - DUPLICATO!
```

**Correzione**: Rimuovere le righe 10 e 11

**Impatto**: ALTO - Impedisce l'analisi corretta del file

---

### 3. ModuleResource.php - Presunto Duplicate Import
**File**: `Modules/Xot/app/Filament/Resources/ModuleResource.php`
**Riga**: 11
**Errore Segnalato**: `Cannot use Modules\Xot\Contracts\ProfileContract as ProfileContract because the name is already in use`

**Analisi**: Dopo verifica con `grep`, non è stato trovato alcun import di `ProfileContract` nel file. Possibili cause:
- Cache di PHPStan non aggiornata
- Errore già corretto in precedenza
- Falso positivo

**Azione**: Ri-eseguire PHPStan dopo le altre correzioni per verificare

---

## Piano di Correzione

### Fase 1: Correzione Errori Critici
1. ✅ Analizzare i file con errori duplicati
2. ⏳ Correggere CopyAction.php (priorità massima - errore fatale)
3. ⏳ Correggere GetProductsArrayDummyAction.php
4. ⏳ Verificare ModuleResource.php

### Fase 2: Verifica
1. ⏳ Ri-eseguire PHPStan su ogni file corretto
2. ⏳ Eseguire phpmd per verificare code quality
3. ⏳ Eseguire phpinsights per analisi completa

### Fase 3: Commit e Push
1. ⏳ Git commit per ogni file corretto
2. ⏳ Git push finale

---

## Ragionamento Autocritico

### Domanda 1: Gli errori sono davvero solo import duplicati?
**Risposta**: Sì, sono errori banali ma fatali. Probabilmente causati da merge conflicts mal risolti o copy-paste durante refactoring.

### Domanda 2: Perché ModuleResource.php non mostra ProfileContract?
**Risposta**: Tre ipotesi:
1. File modificato dopo l'esecuzione di PHPStan
2. Cache di PHPStan non aggiornata
3. Problema di parallel workers (nota: ci sono stati 2 worker killed)

**Decisione**: Correggere prima gli errori certi, poi ri-analizzare

### Domanda 3: Come prevenire questi errori in futuro?
**Risposta**:
- Configurare pre-commit hooks con PHPStan
- Usare IDE con plugin PHPStan in real-time
- Aggiungere linting automatico in CI/CD

---

## Best Practices Applicate

### DRY (Don't Repeat Yourself)
Gli import duplicati violano DRY a livello base. Ogni `use` statement deve apparire una sola volta.

### KISS (Keep It Simple, Stupid)
La correzione è semplicissima: rimuovere le righe duplicate. Non serve refactoring complesso.

### Fail Fast
L'errore fatale in CopyAction blocca tutto. Correggerlo per primo permette di procedere con le altre analisi.

---

## Note Tecniche

### PHPStan Configuration
- File configurazione: `/var/www/_bases/base_techplanner_fila4_mono/laravel/phpstan.neon`
- Level: `max` (più stretto possibile)
- Memory limit: `-1` (illimitato)

### Parallel Workers Issue
Durante l'analisi si sono verificati errori nei parallel workers:
- Exit code 255: Fatal error in CopyAction.php
- Exit code 137: Worker killed (probabilmente OOM - Out Of Memory)

**Raccomandazione**: Dopo le correzioni, monitorare l'uso di memoria durante PHPStan

---

## Prossimi Passi

1. Implementare le correzioni in ordine di priorità
2. Testare ogni file con PHPStan dopo la correzione
3. Eseguire analisi completa del modulo Xot
4. Passare al modulo successivo (Lang)

---

**Stato**: 🔴 In corso
**Errori rimanenti**: 3-4 (da verificare ModuleResource.php)
**Priorità**: MASSIMA (errore fatale blocca l'analisi completa)
