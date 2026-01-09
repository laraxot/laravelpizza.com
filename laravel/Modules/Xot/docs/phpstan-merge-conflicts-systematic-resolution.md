# Roadmap: Risoluzione Sistematica Merge Conflicts e PHPStan Errors

**Data**: 2025-01-22  
**Status**: 🔴 CRITICO - 489 file PHP con merge conflicts  
**Priorità**: MASSIMA - Blocca completamente PHPStan  
**Metodologia**: Super Mucca - Approccio Sistematico

---

## 🔴 Situazione Critica

**Problema Identificato**: 489 file PHP con merge conflicts (`<<<<<<< HEAD`) che bloccano completamente l'esecuzione di PHPStan.

**Impatto**:
- ❌ PHPStan non può essere eseguito
- ❌ Impossibile analizzare errori di qualità codice
- ❌ Blocco completo del workflow di sviluppo

---

## ⚔️ La Litigata Interna

### 👹 Voce A - Pragmatica (Risolvere Tutto Velocemente)

> "Risolvi tutti i merge conflicts velocemente, prendi sempre la versione più recente e vai avanti."

**Argomenti a favore**:
- ✅ Veloce
- ✅ Sblocca PHPStan immediatamente

**Argomenti contro**:
- ❌ Potrebbe perdere codice importante
- ❌ Non capisce il contesto delle modifiche
- ❌ Potrebbe introdurre bug sistemici
- ❌ Non rispetta la metodologia Super Mucca

---

### 🦸 Voce B - Tecnica (Analisi Approfondita di Tutto)

> "Analizza ogni merge conflict, capisci le modifiche, scegli la versione migliore per tutti i 489 file."

**Argomenti a favore**:
- ✅ Mantiene codice corretto
- ✅ Capisce il contesto
- ✅ Evita perdita di funzionalità

**Argomenti contro**:
- ❌ Richiede tempo eccessivo (settimane)
- ❌ Blocca il lavoro per troppo tempo
- ❌ Potrebbe essere eccessivo per conflitti minori

---

### 🧘 Voce C - Zen (Strategia Intelligente e Sistematica)

> "Risolvi i conflitti bloccanti PHPStan velocemente ma correttamente, poi analizza PHPStan errors in modo sistematico modulo per modulo."

**Argomenti a favore**:
- ✅ Sblocca PHPStan velocemente
- ✅ Mantiene qualità del codice
- ✅ Approccio sistematico e organizzato
- ✅ Rispetta metodologia Super Mucca
- ✅ Permette progresso incrementale

**Argomenti contro**:
- ❌ Richiede bilanciamento tra velocità e qualità

---

## 🏆 Il Vincitore: Voce C (Zen - Strategia Intelligente e Sistematica)

### Perché Ha Vinto

1. **Sblocca PHPStan Velocemente**
   - I merge conflicts bloccano completamente l'analisi
   - Risolvere i conflitti è prerequisito per qualsiasi analisi

2. **Mantiene Qualità**
   - Usa pattern corretti (chiavi string per array Filament)
   - Mantiene PHPDoc e type hints corretti
   - Rispetta architettura Laraxot

3. **Approccio Sistematico**
   - Risolve conflitti bloccanti prima
   - Poi analizza PHPStan errors in modo organizzato
   - Modulo per modulo per tracciabilità

4. **Rispetta Metodologia Super Mucca**
   - Capisce il problema (merge conflicts bloccanti)
   - Documenta la strategia
   - Procede con calma e organizzazione

---

## 📋 Piano di Azione Sistematico

### Fase 1: Identificazione File Bloccanti (PRIORITÀ CRITICA)

**Obiettivo**: Identificare tutti i file PHP che bloccano PHPStan.

**Comando**:
```bash
cd /var/www/_bases/base_laravelpizza/laravel
find Modules -name "*.php" -type f -path "*/app/*" -exec grep -l "<<<<<<< HEAD" {} \; > merge-conflicts-php-files.txt
```

**Criteri di Priorità**:
1. **File Base/Core** (Xot): Risolti prima (bloccano tutto)
2. **File Resources/Pages**: Risolti secondo (usati da molti moduli)
3. **File Moduli Specifici**: Risolti terzo (isolati)

### Fase 2: Risoluzione Merge Conflicts Bloccanti

#### 2.1 File Base/Core (Xot) - COMPLETATO ✅
- ✅ `Modules/Xot/app/Filament/Pages/XotBasePage.php`
- ✅ `Modules/Xot/app/Filament/Resources/Pages/XotBaseViewRecord.php`
- ✅ `Modules/Xot/app/Actions/ParsePrintPageStringAction.php`
- ✅ `Modules/Xot/app/Console/Commands/OptimizeFilamentMemoryCommand.php`
- ✅ `Modules/Xot/app/Services/ArtisanService.php`
- ✅ `Modules/Xot/app/Filament/Resources/ExtraResource.php`
- ✅ `Modules/Xot/app/Filament/Resources/LogResource/Pages/ListLogs.php`

#### 2.2 File Resources/Pages Xot - IN CORSO
- ⏳ `Modules/Xot/app/Filament/Traits/NavigationLabelTrait.php` - DA RISOLVERE
- ⏳ `Modules/Xot/app/Filament/Resources/LogResource/Pages/EditLog.php` - DA RISOLVERE
- ⏳ `Modules/Xot/app/Filament/Resources/ModuleResource/Pages/ListModules.php` - DA RISOLVERE
- ⏳ `Modules/Xot/app/Filament/Resources/ModuleResource/Pages/EditModule.php` - DA RISOLVERE
- ⏳ `Modules/Xot/app/Filament/Resources/CacheLockResource/Pages/ListCacheLocks.php` - DA RISOLVERE
- ⏳ `Modules/Xot/app/Filament/Resources/CacheLockResource/Pages/EditCacheLock.php` - DA RISOLVERE
- ⏳ `Modules/Xot/app/Filament/Resources/CacheResource/Pages/ListCaches.php` - DA RISOLVERE
- ⏳ `Modules/Xot/app/Filament/Resources/CacheResource/Pages/EditCache.php` - DA RISOLVERE

#### 2.3 File Moduli Specifici
- ✅ `Modules/Gdpr/app/Filament/Resources/ConsentResource/Pages/ListConsents.php`
- ✅ `Modules/Gdpr/app/Filament/Resources/TreatmentResource/Pages/ListTreatments.php`
- ✅ `Modules/Notify/app/Filament/Resources/MailTemplateResource/Pages/ListMailTemplates.php`
- ⏳ `Modules/Notify/app/Filament/Resources/NotificationResource.php` - DA RISOLVERE

### Fase 3: Esecuzione PHPStan (Dopo Risoluzione Conflitti)

```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/phpstan analyse Modules --level=10 --no-progress > phpstan-output.txt 2>&1
```

### Fase 4: Analisi Errori PHPStan

1. **Categorizzare Errori**:
   - Type errors
   - Property/Method not found
   - Array key types
   - Mixed types
   - Casting issues

2. **Prioritizzare**:
   - Errori bloccanti (syntax, fatal)
   - Errori type safety (livello 10)
   - Warning e suggerimenti

3. **Creare Roadmap Dettagliata**:
   - Per modulo
   - Per categoria errore
   - Con soluzioni proposte

### Fase 5: Implementazione Correzioni

1. **Modulo per Modulo**:
   - Completare tutti gli errori di un modulo
   - Verificare con PHPStan, PHPMD, PHPInsights
   - Commit dopo ogni modulo

2. **Pattern Riusabili**:
   - Documentare pattern comuni
   - Creare guide per errori ricorrenti

---

## 🔧 Pattern di Risoluzione Merge Conflicts

### Pattern 1: Filament getTableColumns()

**Conflitto Tipico**:
```php
return [
    'id' => TextColumn::make('id'),
];
```

**Soluzione Corretta**:
```php
/**
 * @return array<string, Column>
 */
public function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id'),
    ];
}
```

**Perché**: Chiavi string obbligatorie per PHPStan L10 e Filament v4.

### Pattern 2: Type Assertions

**Conflitto Tipico**:
```php
if (! is_array($matches) || empty($matches[0])) {
```

**Soluzione Corretta**:
```php
Assert::notEmpty($matches[0], 'No valid matches found');
```

**Perché**: Assert è più robusto e chiaro per PHPStan.

### Pattern 3: String Type Narrowing

**Conflitto Tipico**:
```php
if (! is_string($module_name)) {
```

**Soluzione Corretta**:
```php
$module_name = Request::input('module', '');
if (! is_string($module_name)) {
    $module_name = '';
}
```

**Perché**: Type narrowing esplicito per PHPStan L10.

### Pattern 4: Use Statements

**Conflitto Tipico**:
```php
use Filament\Tables;
```

**Soluzione Corretta**:
```php
use Filament\Tables\Columns\TextColumn;
```

**Perché**: Import specifici sono più chiari e evitano conflitti di namespace.

---

## ✅ Checklist Pre-Implementazione

- [x] Identificati file con merge conflicts (489 file PHP)
- [x] Risolti conflitti GDPR (ListConsents, ListTreatments)
- [x] Risolti conflitti Xot base (ParsePrintPageStringAction, OptimizeFilamentMemoryCommand, ArtisanService, XotBasePage, XotBaseViewRecord, ExtraResource, ListLogs)
- [x] Risolti conflitti Notify (ListMailTemplates)
- [ ] Risolvere conflitti NavigationLabelTrait
- [ ] Risolvere conflitti LogResource/Pages/EditLog
- [ ] Risolvere conflitti ModuleResource/Pages/*
- [ ] Risolvere conflitti CacheLockResource/Pages/*
- [ ] Risolvere conflitti CacheResource/Pages/*
- [ ] Risolvere conflitti NotificationResource
- [ ] Eseguire PHPStan dopo risoluzione conflitti
- [ ] Analizzare output PHPStan
- [ ] Creare roadmap dettagliata per errori
- [ ] Implementare correzioni modulo per modulo
- [ ] Verificare con PHPStan, PHPMD, PHPInsights
- [ ] Commit dopo ogni modulo completato

---

## 📊 Statistiche Attuali

- **File PHP con merge conflicts**: 489
- **File risolti**: 9
- **File rimanenti**: ~480
- **Priorità critica**: ~20 file (bloccano PHPStan)

---

## 📚 Riferimenti

- [Filament Methods Return Types](./filament-methods-return-types.md) - Chiavi string obbligatorie
- [PHPStan Code Quality Guide](./phpstan-code-quality-guide.md) - Pattern e best practices
- [Super Mucca Methodology](./super-mucca-methodology.md) - Metodologia completa
- [Merge Conflicts Resolution - GDPR Module](../../Gdpr/docs/phpstan-merge-conflicts-roadmap.md) - Roadmap GDPR

---

**Ultimo aggiornamento**: 2025-01-22  
**Versione**: 1.0.0  
**Status**: 🔴 In Corso - Risoluzione Sistematica Merge Conflicts
