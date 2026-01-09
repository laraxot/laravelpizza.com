# Convenzioni di Naming per Documentazione

## Data: 2025-01-27

## REGOLA CRITICA: SEMPRE MINUSCOLO IN DOCS

### Principio Fondamentale
Tutti i file e le cartelle all'interno delle directory `docs/` DEVONO utilizzare **esclusivamente caratteri minuscoli**.

### Pattern Corretti

#### ✅ CORRETTO - File
- `my-document.md`
- `translation-guide.md`
- `phpstan-fixes.md`
- `git-conflicts-resolution.md`
- `table-layout-enum-usage.md`

#### ✅ CORRETTO - Cartelle
- `examples/`
- `standards/`
- `components/`
- `filament/`
- `phpstan/`

#### ✅ CORRETTO - Unica Eccezione
- `README.md` (solo questo file può avere maiuscole)

### Pattern Errati

#### ❌ ERRATO - File
- `MyDocument.md`
- `TranslationGuide.md`
- `PHPStanFixes.md`
- `GitConflictsResolution.md`
- `TableLayoutEnumUsage.md`

#### ❌ ERRATO - Cartelle
- `Examples/`
- `Standards/`
- `Components/`
- `Filament/`
- `PHPStan/`

## Motivazione

### 1. **Coerenza**
- Mantenere uniformità in tutto il progetto
- Evitare confusione tra sviluppatori
- Standardizzazione cross-platform

### 2. **Compatibilità**
- Evitare problemi su sistemi case-sensitive (Linux)
- Compatibilità con diversi filesystem
- Prevenire errori di autoloading

### 3. **Manutenibilità**
- Nomi più leggibili e intuitivi
- Facilità di ricerca e navigazione
- Riduzione di errori di digitazione

### 4. **Best Practice**
- Seguire convenzioni standard del settore
- Rispettare principi di clean code
- Mantenere professionalità del codice

## Implementazione

### Controllo Automatico
```bash
# Trova file con nomi non conformi
find . -path "*/docs/*" -name "*[A-Z]*" ! -name "README.md"

# Trova cartelle con nomi non conformi
find . -path "*/docs/*" -type d -name "*[A-Z]*"
```

### Processo di Correzione
1. **Identificazione**: Trovare file/cartelle non conformi
2. **Rinomina**: Convertire in minuscolo con kebab-case
3. **Aggiornamento**: Modificare tutti i riferimenti
4. **Verifica**: Controllare che tutto funzioni
5. **Documentazione**: Aggiornare link e riferimenti

### Esempi di Rinomina
```bash
# File
MyDocument.md → my-document.md
TranslationGuide.md → translation-guide.md
PHPStanFixes.md → phpstan-fixes.md

# Cartelle
Examples/ → examples/
Standards/ → standards/
Components/ → components/
```

## Checklist di Conformità

- [ ] Tutti i file in docs/ sono minuscoli
- [ ] Tutte le cartelle in docs/ sono minuscoli
- [ ] Solo README.md ha maiuscole
- [ ] Tutti i link interni sono aggiornati
- [ ] Tutti i riferimenti sono corretti
- [ ] Nessun file orfano rimasto

## Regole Specifiche

### 1. **Kebab-Case per File**
- Usare trattini per separare parole
- Esempio: `table-layout-enum-usage.md`

### 2. **Snake_Case per Cartelle**
- Usare underscore per separare parole
- Esempio: `quality_assurance/`

### 3. **Nomi Descritivi**
- Evitare abbreviazioni non chiare
- Usare nomi che descrivono il contenuto
- Mantenere coerenza semantica

### 4. **Evitare Caratteri Speciali**
- Solo lettere, numeri, trattini e underscore
- Evitare spazi, punti esclamativi, ecc.
- Non usare caratteri accentati

## Collegamenti

- [Regole di Traduzione](../translation-rules.md)
- [Standard di Documentazione](../documentation-standards.md)
- [Best Practice Filament](../filament-best-practices.md)

---

*Ultimo aggiornamento: 2025-01-27*
*Stato: ATTIVO - REGOLA CRITICA* 