# Roadmap: Risoluzione Merge Conflicts e PHPStan Errors - Modulo GDPR

**Data**: 2025-01-22  
**Status**: 🔴 Bloccante - Merge Conflicts da Risolvere  
**Priorità**: CRITICA - Blocca esecuzione PHPStan  
**Metodologia**: Super Mucca - La Litigata Interna

---

## 🔴 Problema Critico Identificato

PHPStan non può essere eseguito a causa di **merge conflicts** (markers `<<<<<<< HEAD`) in file PHP che bloccano il parsing.

**File Bloccanti Identificati**:
1. ✅ `Modules/Gdpr/app/Filament/Resources/ConsentResource/Pages/ListConsents.php` - RISOLTO
2. ✅ `Modules/Gdpr/app/Filament/Resources/TreatmentResource/Pages/ListTreatments.php` - RISOLTO
3. ✅ `Modules/Xot/app/Actions/ParsePrintPageStringAction.php` - RISOLTO
4. ✅ `Modules/Xot/app/Console/Commands/OptimizeFilamentMemoryCommand.php` - RISOLTO
5. ✅ `Modules/Xot/app/Services/ArtisanService.php` - RISOLTO (versione refactored con CommandRegistry)
6. ✅ `Modules/Xot/app/Filament/Pages/XotBasePage.php` - RISOLTO
7. ⏳ Altri file PHP con merge conflicts da identificare e risolvere

---

## ⚔️ La Litigata Interna

### 👹 Voce A - Pragmatica (Risolvere Velocemente)

> "Risolvi i merge conflicts velocemente, prendi la versione più recente e vai avanti."

**Argomenti a favore**:
- ✅ Veloce
- ✅ Sblocca PHPStan immediatamente

**Argomenti contro**:
- ❌ Potrebbe perdere codice importante
- ❌ Non capisce il contesto delle modifiche
- ❌ Potrebbe introdurre bug

---

### 🦸 Voce B - Tecnica (Analisi Approfondita)

> "Analizza ogni merge conflict, capisci le modifiche, scegli la versione migliore."

**Argomenti a favore**:
- ✅ Mantiene codice corretto
- ✅ Capisce il contesto
- ✅ Evita perdita di funzionalità

**Argomenti contro**:
- ❌ Richiede molto tempo
- ❌ Potrebbe essere eccessivo per conflitti minori

---

### 🧘 Voce C - Zen (Strategia Intelligente)

> "Risolvi i conflitti bloccanti velocemente ma correttamente, poi analizza PHPStan errors in modo sistematico."

**Argomenti a favore**:
- ✅ Sblocca PHPStan velocemente
- ✅ Mantiene qualità del codice
- ✅ Approccio sistematico
- ✅ Rispetta metodologia Super Mucca

**Argomenti contro**:
- ❌ Richiede bilanciamento tra velocità e qualità

---

## 🏆 Il Vincitore: Voce C (Zen - Strategia Intelligente)

### Perché Ha Vinto

1. **Sblocca PHPStan Velocemente**
   - I merge conflicts bloccano completamente l'analisi
   - Risolvere i conflitti è prerequisito per qualsiasi analisi

2. **Mantiene Qualità**
   - Usa pattern corretti (chiavi string per array Filament)
   - Mantiene PHPDoc e type hints corretti

3. **Approccio Sistematico**
   - Risolve conflitti bloccanti prima
   - Poi analizza PHPStan errors in modo organizzato

4. **Rispetta Metodologia Super Mucca**
   - Capisce il problema (merge conflicts bloccanti)
   - Documenta la strategia
   - Procede con calma

---

## 📋 Piano di Azione

### Fase 1: Risoluzione Merge Conflicts Bloccanti (PRIORITÀ CRITICA)

#### 1.1 File GDPR (Completato ✅)
- ✅ `ListConsents.php` - Risolto con chiavi string e PHPDoc corretto
- ✅ `ListTreatments.php` - Risolto con chiavi string e PHPDoc corretto

#### 1.2 File Xot (Da Risolvere)

**1.2.1 `ParsePrintPageStringAction.php`**
- **Conflitto**: Linee 35-58
- **Strategia**: Mantenere versione con Assert e type hints corretti
- **Pattern**: Usare `Assert::notEmpty()` invece di controlli manuali

**1.2.2 `OptimizeFilamentMemoryCommand.php`**
- **Conflitto**: Linee 139-147
- **Strategia**: Mantenere versione con controllo `isset($matches[1])` per sicurezza
- **Pattern**: Aggiungere type narrowing per PHPStan

**1.2.3 `ArtisanService.php`**
- **Conflitto**: Molto complesso, molti conflitti annidati
- **Strategia**: Analizzare struttura, mantenere versione più recente e completa
- **Pattern**: Usare `is_string()` con type narrowing, mantenere struttura switch

### Fase 2: Esecuzione PHPStan (Dopo Risoluzione Conflitti)

```bash
cd /var/www/_bases/base_laravelpizza/laravel
./vendor/bin/phpstan analyse Modules --level=10 --no-progress > phpstan-output.txt 2>&1
```

### Fase 3: Analisi Errori PHPStan

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

### Fase 4: Implementazione Correzioni

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

---

## ✅ Checklist Pre-Implementazione

- [x] Identificati file con merge conflicts
- [x] Risolti conflitti GDPR (ListConsents, ListTreatments)
- [ ] Risolvere conflitti Xot (ParsePrintPageStringAction, OptimizeFilamentMemoryCommand, ArtisanService)
- [ ] Eseguire PHPStan dopo risoluzione conflitti
- [ ] Analizzare output PHPStan
- [ ] Creare roadmap dettagliata per errori
- [ ] Implementare correzioni modulo per modulo
- [ ] Verificare con PHPStan, PHPMD, PHPInsights
- [ ] Commit dopo ogni modulo completato

---

## 📚 Riferimenti

- [Filament Methods Return Types](../../Xot/docs/filament-methods-return-types.md) - Chiavi string obbligatorie
- [PHPStan Code Quality Guide](../../Xot/docs/phpstan-code-quality-guide.md) - Pattern e best practices
- [Super Mucca Methodology](../../Xot/docs/super-mucca-methodology.md) - Metodologia completa

---

**Ultimo aggiornamento**: 2025-01-22  
**Versione**: 1.0.0  
**Status**: 🔴 In Corso - Merge Conflicts da Risolvere
