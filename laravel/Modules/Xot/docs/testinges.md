# Testing Fixes Roadmap - Correzione Test Falliti

**Status**: In Progress
**Principio Fondamentale**: Il sito funziona, quindi se un test fallisce è il test che sbaglia

## 🎯 Principi Fondamentali

### Regola Assoluta
**IL SITO FUNZIONA → SE UN TEST FALLISCE, È IL TEST CHE SBAGLIA**

### Filosofia Testing
- **COMPORTAMENTO BUSINESS, NON IMPLEMENTAZIONE**
- Test devono verificare comportamento reale, non dettagli implementativi
- Se il sito funziona, i test devono riflettere la realtà, non creare realtà immaginarie

## 📊 Situazione Attuale

- **Test Totali**: ~2000+
- **Test Falliti**: 1373
- **Test Passati**: 618
- **Test Skipped**: 22
- **Warnings**: 51 (metadata in doc-comments)

## 🔍 Categorie di Errori Identificati

### 1. BindingResolutionException - "Target class [db] does not exist"
**File**: `Modules/Xot/tests/Unit/Services/ArtisanServiceTest.php`
**Causa**: Mock di DB facade non configurato correttamente
**Soluzione**: Correggere mock per riflettere comportamento reale

### 2. QueryException
**File**: Vari test Activity, Cms
**Causa**: Test che cercano tabelle/colonne che non esistono o hanno nomi diversi
**Soluzione**: Aggiornare test per riflettere schema database reale

### 3. BadMethodCallException
**File**: Vari test
**Causa**: Test che chiamano metodi che non esistono o sono stati rimossi
**Soluzione**: Aggiornare test per usare metodi reali

### 4. TypeError
**File**: Vari test
**Causa**: Test che passano tipi sbagliati o non gestiscono null correttamente
**Soluzione**: Correggere type hints e gestione null

### 5. Error (Generico)
**File**: Vari test Cms, Activity
**Causa**: Test che cercano classi/componenti che non esistono
**Soluzione**: Aggiornare test per usare classi/componenti reali

## 🛠️ Strategia di Correzione

### Fase 1: Test Semplici (In Progress)
1. ✅ ArtisanServiceTest.php - BindingResolutionException (COMPLETATO)
   - Problema: Mock di DB::purge() e DB::reconnect() non funzionava
   - Soluzione: Configurata connessione 'mysql' in beforeEach(), usato Request::replace() invece di shouldReceive(), aggiunto @phpstan-ignore-next-line per metodi Pest
   - Risultato: 4 test passano, PHPStan livello 10 OK
2. ⏳ Test con errori di mock semplici
3. ⏳ Test con errori di import

### Fase 2: Test con QueryException
1. Identificare tabelle/colonne reali
2. Aggiornare test per usare schema reale
3. Verificare con PHPStan

### Fase 3: Test con BadMethodCallException
1. Identificare metodi reali disponibili
2. Aggiornare test per usare metodi reali
3. Verificare con PHPStan

### Fase 4: Test Complessi
1. Test di integrazione
2. Test con dipendenze multiple
3. Test con mock complessi

## 📝 Pattern di Correzione

### Pattern 1: Mock Non Configurato
```php
// ❌ ERRATO
DB::shouldReceive('purge')->once()->with('mysql');

// ✅ CORRETTO - Verificare comportamento reale
// Se DB::purge() non esiste o funziona diversamente, aggiornare test
```

### Pattern 2: Classe Non Esistente
```php
// ❌ ERRATO
use Modules\UI\Filament\Widgets\BaseCalendarWidget; // Non esiste

// ✅ CORRETTO
use Modules\UI\Filament\Widgets\UserCalendarWidget; // Esiste
```

### Pattern 3: Metodo Non Esistente
```php
// ❌ ERRATO
$user->initializeCurrentTeam(); // Metodo rimosso

// ✅ CORRETTO
// Usare comportamento reale: currentTeam() gestisce automaticamente
$currentTeam = $user->currentTeam;
```

## ✅ Checklist per Ogni Test Corretto

- [ ] Test passa
- [ ] PHPStan livello 10: nessun errore
- [ ] PHPMD: nessun code smell
- [ ] PHPInsights: qualità accettabile
- [ ] Test verifica comportamento business, non implementazione
- [ ] Test riflette realtà del codice funzionante

## 📚 Documentazione di Riferimento

- [Testing Best Practices](testing-best-practices.md)
- [Testing Priority Rule](../Geo/docs/testing-priority-rule.md)
- [No RefreshDatabase Policy](../Activity/docs/testing/no-refresh-database-policy.md)
- [Test Fix Philosophy](../UI/docs/test-fix-philosophy.md)

## 🔄 Workflow per Ogni Test

1. **Studiare docs** più vicine al test
2. **Analizzare errore** specifico
3. **Verificare codice reale** (il sito funziona!)
4. **Correggere test** per riflettere realtà
5. **Verificare PHPStan** livello 10
6. **Eseguire test** per confermare fix
7. **Aggiornare docs** se necessario

---

**Ultimo aggiornamento**: 2025-01-22
**Prossimo step**: Correggere ArtisanServiceTest.php
