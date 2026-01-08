# Processo di Normalizzazione Documentazione

## Scopo

Questo documento descrive il processo sistematico per normalizzare i nomi dei file `.md` secondo le regole del progetto PTVX, seguendo i principi **DRY + KISS** con focus sulla **business logic**.

## Regole Fondamentali

### Naming File .md

1. **Solo minuscolo**: Tutti i file devono essere in minuscolo con trattini (`kebab-case`)
2. **Nessuna data nel nome**: Le date non devono essere nel nome del file
3. **Eccezioni**: Solo `README.md` e `CHANGELOG.md` possono avere maiuscole
4. **Posizionamento**: File `.md` solo dentro cartelle `docs/` esistenti
5. **No nuove cartelle docs**: Usare solo cartelle `docs/` esistenti
6. **Verifica duplicati**: Prima di creare, verificare che non esista già un file sullo stesso argomento

### Esempi Corretti

```
✅ CORRETTO:
- bugfix-icons-missing.md
- translation-refactor-summary.md
- business-logic-analysis.md
- performance-calculation.md

❌ ERRATO:
- BugfixIconsMissing.md (maiuscole)
- bugfix-icons-missing-2025-01-27.md (data nel nome)
- bugfix_icons_missing.md (underscore invece di trattini)
- bugfix-icons-missing-2025.md (anno nel nome)
```

## Processo di Normalizzazione

### Fase 1: Identificazione

1. **Trovare file con date**:
   ```bash
   find Modules/*/docs -name "*.md" | grep -E "\d{4}-\d{2}-\d{2}|\d{4}_\d{2}_\d{2}"
   ```

2. **Trovare file con maiuscole** (esclusi README.md e CHANGELOG.md):
   ```bash
   find Modules/*/docs -name "*.md" | grep -E "[A-Z]" | grep -v README.md | grep -v CHANGELOG.md
   ```

3. **Trovare potenziali duplicati**:
   ```bash
   # File con stesso nome ma con/senza data
   find Modules/*/docs -name "*2025*.md" -exec basename {} \; | sed 's/-2025.*//' | sort | uniq -d
   ```

### Fase 2: Analisi

Per ogni file identificato:

1. **Verificare se esiste versione senza data**:
   - Se esiste: confrontare contenuti
   - Se identici: eliminare file con data
   - Se diversi: valutare quale mantenere o unire

2. **Verificare se il file è archivio**:
   - Se è in cartella `archive/`: può mantenere data se necessario
   - Se è documentazione attiva: rimuovere data

3. **Verificare collegamenti**:
   - Cercare riferimenti al file nel codice e in altri file `.md`
   - Aggiornare tutti i collegamenti dopo rinomina

### Fase 3: Esecuzione

#### Caso 1: File Duplicato (contenuto identico)

```bash
# Esempio: bugfix-icons-missing-2025-01-27.md è identico a bugfix-icons-missing.md
# Azione: Eliminare file con data
rm bugfix-icons-missing-2025-01-27.md
```

#### Caso 2: File con Data (nessun duplicato)

```bash
# Esempio: translation-refactor-complete-summary-2025-08-08.md
# Azione: Rinominare rimuovendo data
mv translation-refactor-complete-summary-2025-08-08.md translation-refactor-complete-summary.md
```

#### Caso 3: File con Maiuscole

```bash
# Esempio: BUSINESS_LOGIC_ANALYSIS.md
# Azione: Rinominare in minuscolo con trattini
mv BUSINESS_LOGIC_ANALYSIS.md business-logic-analysis.md
```

### Fase 4: Aggiornamento Contenuti

Dopo ogni rinomina:

1. **Aggiornare data nel contenuto** (se necessario):
   - Mantenere la data nel corpo del documento se è rilevante
   - Formato: `**Data**: 27 Gennaio 2025` (non nel nome file)

2. **Aggiornare collegamenti**:
   - Cercare riferimenti al vecchio nome
   - Aggiornare con nuovo nome

3. **Verificare collegamenti**:
   ```bash
   # Trovare riferimenti al vecchio nome
   grep -r "vecchio-nome-file" Modules/*/docs
   ```

### Fase 5: Documentazione

1. **Aggiornare CHANGELOG.md** (se esiste):
   - Documentare le rinomine eseguite
   - Mantenere traccia delle modifiche

2. **Verificare README.md del modulo**:
   - Aggiornare collegamenti se necessario
   - Mantenere coerenza con nuova struttura

## Esempi Pratici

### Esempio 1: Duplicati Identici

**Situazione**:
- `bugfix-icons-missing-2025-01-27.md` (100 righe)
- `bugfix-icons-missing.md` (100 righe, identico)

**Azione**:
```bash
# Verificare che siano identici
diff bugfix-icons-missing-2025-01-27.md bugfix-icons-missing.md
# Se identici, eliminare file con data
rm bugfix-icons-missing-2025-01-27.md
```

### Esempio 2: File con Data (versione unica)

**Situazione**:
- `translation-refactor-complete-summary-2025-08-08.md` (contenuto completo)
- `translation-refactor-complete-summary.md` (vuoto o non esiste)

**Azione**:
```bash
# Rinominare file rimuovendo data
mv translation-refactor-complete-summary-2025-08-08.md translation-refactor-complete-summary.md
# Se il file contiene data nel corpo, mantenerla ma non nel nome
```

### Esempio 3: File con Maiuscole

**Situazione**:
- `BUSINESS_LOGIC_ANALYSIS.md`
- `business-logic-analysis.md` (non esiste)

**Azione**:
```bash
# Convertire in minuscolo con trattini
mv BUSINESS_LOGIC_ANALYSIS.md business-logic-analysis.md
```

## Checklist Pre-Normalizzazione

Prima di rinominare un file, verificare:

- [ ] File non è in cartella `archive/` (può mantenere data se storico)
- [ ] Non esiste già versione senza data con contenuto identico
- [ ] Se esistono entrambe le versioni, confrontare contenuti
- [ ] Identificare tutti i collegamenti al file
- [ ] Verificare che rinomina non rompa riferimenti

## Checklist Post-Normalizzazione

Dopo aver rinominato un file:

- [ ] File rinominato correttamente (minuscolo, no date)
- [ ] Contenuto del file aggiornato (data nel corpo se necessario)
- [ ] Tutti i collegamenti aggiornati
- [ ] Collegamenti verificati (nessun 404)
- [ ] CHANGELOG.md aggiornato (se esiste)
- [ ] README.md del modulo aggiornato (se necessario)

## Automazione Futura

Per processi futuri, considerare script di automazione:

```bash
#!/bin/bash
# Script per normalizzazione automatica (da implementare)
# find Modules/*/docs -name "*2025*.md" | while read file; do
#   newname=$(echo "$file" | sed 's/-2025[^.]*//')
#   mv "$file" "$newname"
# done
```

**Nota**: Usare con cautela, verificare sempre prima di applicare automaticamente.

## Riferimenti

- [Regole Naming File](../file-naming-rules.md)
- [Piano Consolidamento Documentazione](../../../../docs/consolidamento-documentazione-2025.md)
- [Filosofia DRY + KISS](../../../../docs/philosophy-guide.md)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Stato**: Processo attivo  
**Priorità**: Alta (conformità regole progetto)


