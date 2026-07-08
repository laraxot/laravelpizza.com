# Task: Consolidare Documentazione Duplicata - Xot

**Modulo**: Xot
**Priorita'**: Media
**Completamento**: 30%

---

## Descrizione

Il modulo Xot ha 806 file di documentazione. Molti sono duplicati, archivi storici o violano le convenzioni di naming (CLAUDE.md richiede lowercase-with-hyphens).

## Problemi Identificati

### 1. File duplicati
- Molteplici versioni di guide PHPStan (level 6, 7, 8, 9, 10)
- Documenti consolidati che ripetono contenuto di altri file
- Cartelle `archive/`, `consolidated/`, `_docs/` con contenuto ridondante

### 2. Naming violations
- File con CamelCase o UPPERCASE (violazione CLAUDE.md)
- File con underscore invece di hyphens
- File `.docs-directory-violation-reminder.md` indicano violazioni note

### 3. Lingue miste
- Alcuni docs in italiano, altri in inglese
- Nessuna separazione chiara per lingua

## Approccio

1. Identificare file duplicati e rimuovere copie obsolete
2. Rinominare file violanti le convenzioni
3. Unificare docs storici in un archivio organizzato
4. Mantenere solo i docs correnti e rilevanti nella root di docs/

## Criteri di Completamento

- [ ] Nessun file doc con naming violation
- [ ] Rimossi duplicati evidenti
- [ ] Struttura docs/ organizzata e navigabile
- [ ] Indice aggiornato in README.md del modulo
