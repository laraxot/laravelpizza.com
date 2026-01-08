# Strategia Risoluzione Conflitti Git - Modulo Xot

## Contesto

**Data analisi:** 2025-01-27  
**File con conflitti identificati:** 586 file PHP  
**Approccio:** Risoluzione manuale focalizzata su business logic

## Business Logic e Motivazioni

### Perché i Conflitti Esistono

I conflitti Git presenti nel codice sono **residui di merge passati non completati**. Non sono conflitti attivi (Git status mostra 0 unmerged files), ma **marker lasciati nel codice** che:

1. **Bloccano l'esecuzione**: File con marker non sono validi PHP
2. **Degradano qualità**: PHPStan e linter falliscono
3. **Confondono sviluppatori**: Codice ambiguo
4. **Violano DRY**: Spesso contengono codice duplicato

###  Principi DRY + KISS per Risoluzione

**DRY (Don't Repeat Yourself):**
- Elimino SEMPRE codice duplicato nei conflitti
- Consolido logica comune in helper/trait
- Mantengo una sola fonte di verità

**KISS (Keep It Simple, Stupid):**
- Scelgo la versione PIÙ SEMPLICE del codice
- Rimuovo complessità inutile
- Preferisco leggibilità a cleverness

## Strategia di Risoluzione

### Priorità 1: Test Files (Business Logic Critica)

**Focus:** File in `Modules/*/tests/`  
**Motivazione:** Test definiscono comportamento atteso del sistema

**Pattern di risoluzione:**
1. **Analisi conflitto**: Capire PERCHÉ esistono due versioni
2. **Business logic**: Quale versione riflette la logica attuale?
3. **DRY**: Consolidare duplicazioni
4. **KISS**: Mantenere versione più semplice

**Anti-pattern da eliminare:**
- ❌ `RefreshDatabase` trait (test LENTI, non isolati)
- ❌ Duplicazioni di setup/helper
- ❌ Codice morto o commentato

### Priorità 2: Modelli e Business Logic

**Focus:** File in `Modules/*/app/Models/`  
**Motivazione:** Core business domain

**Checklist risoluzione:**
- [ ] Preservare contratti e interfacce
- [ ] Mantenere type hints PHP 8+
- [ ] Consolidare trait duplicati
- [ ] Verificare relazioni Eloquent
- [ ] Testare con PHPStan livello 10

### Priorità 3: Services e Actions

**Focus:** File in `Modules/*/app/Services/`, `Modules/*/app/Actions/`  
**Motivazione:** Logica applicativa

**Pattern preferito:**
- Usare **Spatie QueueableActions** invece di services tradizionali
- Azioni singole, focalizzate, testabili
- Dependency Injection esplicita

### Priorità 4: Resources Filament

**Focus:** File in `Modules/*/app/Filament/Resources/`  
**Motivazione:** UI admin

**Regole architetturali:**
- SEMPRE estendere `XotBaseResource` (MAI `Resource` direttamente)
- NO metodi vuoti (`getTableColumns`, `getFormSchema`)
- Usare solo `getFormSchema()` per form custom
- NO `->label()` hardcoded (usare traduzioni)

## File da IGNORARE (Per Ora)

### Documentazione
- **Cartella:** `Modules/*/docs/`
- **Motivazione:** 2545+ file md con problemi naming
- **Strategia:** Risoluzione separata dopo codice

### Blade Templates
- **Cartella:** `Modules/*/resources/views/`
- **Motivazione:** Commenti HTML non critici
- **Strategia:** Pulizia batch automatizzata

## Pattern Comuni di Conflitti

### Pattern 1: Uso DatabaseMigrations

```php
// ❌ CONFLITTO TIPICO
// use DatabaseMigrations;
```

**Risoluzione:**
```php
// ✅ SOLUZIONE
// NO RefreshDatabase - test unitari usano SOLO mock
// Principio: Test veloci (< 100ms), isolati, deterministici
```

### Pattern 2: Duplicazione Import

```php
// ❌ CONFLITTO TIPICO
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
```

**Risoluzione:**
```php
// ✅ SOLUZIONE (rimuovo tutto ciò che tocca database)
use Tests\TestCase;
```

### Pattern 3: Duplicazione Metodi

```php
// ❌ CONFLITTO TIPICO
public function test_example() {
    $user = new User(['name' => 'Test']);
    // ...
}
```

**Risoluzione:**
```php
// ✅ SOLUZIONE (versione in-memory, NO database)
public function test_example() {
    $user = new User(['name' => 'Test', 'email' => 'test@example.com']);
    // ...
}
```

## Processo Operativo

### Fase 1: Analisi File

# Identifico conflitti

# Conto sezioni conflittuali

### Fase 2: Decisione Strategica

**Domande da porsi:**
1. Quale versione riflette la business logic ATTUALE?
2. Quale versione è PIÙ SEMPLICE (KISS)?
3. Quale versione ELIMINA duplicazioni (DRY)?
4. Quale versione segue best practices (NO RefreshDatabase)?

### Fase 3: Implementazione

1. **Backup mentale**: Capisco ENTRAMBE le versioni
2. **Scelta informata**: Seleziono versione migliore
3. **Consolidamento**: Unisco parti valide se necessario
4. **Pulizia marker**: Rimuovo TUTTI i `<<<<<<<`, `=======`, `>>>>>>>`
5. **Verifica sintassi**: `php -l file.php`
6. **Verifica PHPStan**: `./vendor/bin/phpstan analyse file.php`

### Fase 4: Documentazione

**Per ogni file risolto:**
- Aggiorno questa documentazione con pattern trovati
- Documento decisioni non ovvie
- Creo esempi per situazioni simili

## Metriche di Successo

### Target
- **File risolti:** 586 → 0
- **Test passing:** 100%
- **PHPStan:** Livello 10, zero errori
- **Performance:** Test suite < 30 secondi

### Tracking

# Conta conflitti rimanenti

## Best Practices Emerse

### Testing
- ✅ SEMPRE usare mock per dipendenze esterne
- ✅ SEMPRE usare oggetti in-memory per test unitari
- ✅ NO RefreshDatabase, DatabaseMigrations, DatabaseTransactions in test unitari
- ✅ Test < 100ms ciascuno

### Codice
- ✅ Type hints espliciti PHP 8+
- ✅ PHPDoc solo quando aggiunge valore
- ✅ Preferire composition a inheritance
- ✅ Usare Spatie QueueableActions invece di services

### Documentazione
- ✅ Nome file lowercase (eccetto README.md)
- ✅ Focalizzare su business logic, NON implementazione
- ✅ Spiegare PERCHÉ, non solo COSA
- ✅ DRY: link ad altre docs invece di duplicare

## Lezioni Apprese

### Causa Radice dei Conflitti

I conflitti sono stati causati da:
1. **Merge non completati**: Developer ha lasciato marker
2. **Refactoring paralleli**: Branch divergenti su stesso codice
3. **Mancanza review**: Nessuno ha verificato pre-merge
4. **Test insufficienti**: Codice non-eseguibile passato inosservato

### Prevenzione Futura

**Git Hooks:**
# pre-commit: blocca commit con conflitti

**CI/CD:**
- Aggiungere check per marker conflitti
- Fallire build se trovati
- Alert automatici

**Code Review:**
- Checklist include "No conflict markers"
- Revisor verifica sintassi valida
- Test automatici devono passare

## Stato Corrente

**Ultimo aggiornamento:** 2025-01-27

### Completati ✅
- [x] Analisi complessiva (586 file identificati)
- [x] Strategia definita e documentata
- [x] Risolto `Modules/Xot/tests/TestCase.php`
- [x] Eliminati file duplicati (3 file)

### In Progresso 🔄
- [ ] Risoluzione test files modulo Activity
- [ ] Risoluzione test files modulo Tenant
- [ ] Risoluzione test files modulo UI
- [ ] Risoluzione test files modulo User
- [ ] Risoluzione test files modulo Xot

### Da Fare 📋
- [ ] Risoluzione models e business logic
- [ ] Risoluzione services e actions
- [ ] Risoluzione resources Filament
- [ ] Verifica finale PHPStan livello 10
- [ ] Esecuzione test suite completa

---

**Nota:** Questa documentazione è VIVA. Aggiungo pattern, lezioni, esempi man mano che risolvo conflitti.

