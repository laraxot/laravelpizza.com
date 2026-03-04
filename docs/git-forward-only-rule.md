# Git Forward-Only Rule

## 🔥 Regola Assoluta: Mai Tornare Indietro

### La Legge

**MAI TORNARE INDIETRO DI VERSIONE - SOLO AVANTI**

Questa non è una raccomandazione, è una **legge del progetto**.

## ❌ Cosa è VIETATO Assolutamente

- `git reset --hard` su commit pushati
- `git push --force` su branch condivisi (develop, main, release/*)
- Cancellare commit dalla storia
- `git rebase -i` su commit pubblici
- Modificare commit già pushati
- Riscrivere la storia del repository

## ✅ Cosa è OBBLIGATORIO

- Nuovi commit per correggere errori
- `git revert` per annullare modifiche (crea nuovo commit di revert)
- Progressione forward-only
- Storia preservata SEMPRE
- Tracciabilità totale
- Documentare correzioni con commit message chiari

## Il Perché

### Filosofia: Progresso Lineare
Come il tempo, il codice procede solo in avanti. Gli errori sono parte del viaggio di apprendimento.

### Scopo: Tracciabilità
- **Audit Trail**: Chi ha fatto cosa e quando
- **Debug**: Capire QUANDO è nato un bug
- **Compliance**: Requisiti legali/normativi
- **Team Awareness**: Tutti vedono l'evoluzione

### Religione: Storia Sacra
Il passato non si cancella. Ogni commit è un documento storico immutabile.

### Zen: Accettazione
Gli errori sono maestri. Non si nascondono, si documentano e si correggono andando avanti.

### Politica: Governance
- Accountability totale
- Trust nel team
- Integrità del repository
- Trasparenza assoluta

## Workflow Corretto

### Scenario 1: Ho committato un bug

```bash
# ❌ SBAGLIATO
git reset --hard HEAD~1
git push --force

# ✅ CORRETTO
# Correggo il bug
vim file-with-bug.php
git add file-with-bug.php
git commit -m "fix: corregge bug introdotto in commit abc123"
git push
```

### Scenario 2: Ho committato password/segreti

```bash
# ❌ SBAGLIATO (e pericoloso!)
git reset --hard HEAD~1
git push --force

# ✅ CORRETTO
# 1. Rimuovo il segreto dal codice
vim file-with-secret.php
git add file-with-secret.php
git commit -m "security: remove leaked credentials from config"
git push

# 2. IMMEDIATAMENTE: Ruota il segreto compromesso
# 3. Documenta l'incidente
# 4. Se necessario, pulisci la storia con BFG Repo-Cleaner (solo dopo!)
```

### Scenario 3: Commit su branch sbagliato

```bash
# ❌ SBAGLIATO
git reset --hard HEAD~1

# ✅ CORRETTO
# Sposta il commit sul branch giusto
git checkout correct-branch
git cherry-pick wrong-branch
git push

# Annulla sul branch sbagliato
git checkout wrong-branch
git revert HEAD
git push
```

### Scenario 4: Voglio "annullare" modifiche

```bash
# ❌ SBAGLIATO
git reset --hard abc123

# ✅ CORRETTO
# Usa revert per creare un nuovo commit che annulla
git revert HEAD~2..HEAD
git push
```

## Eccezioni Rarissime

Le UNICHE 3 eccezioni accettabili:

1. **Branch feature personale NON pushato**: OK fare rebase/squash
   ```bash
   # OK solo se NON hai ancora pushato
   git rebase -i HEAD~5
   ```

2. **Segreti leaked**: Richiede pulizia + rotazione
   ```bash
   # Dopo aver fatto il commit di rimozione
   # E DOPO aver ruotato le credenziali
   # Usa BFG Repo-Cleaner per pulire la storia
   ```

3. **Corruzione repository**: Disaster recovery con backup

## Benefici

1. **Tracciabilità Completa**: Storia di ogni modifica
2. **Debug Facilitato**: Capire quando è nato un problema
3. **Team Trust**: Tutti si fidano della storia condivisa
4. **Compliance**: Soddisfa audit e requisiti legali
5. **Learning Culture**: Gli errori diventano lezioni documentate
6. **Rollback Sicuro**: Posso sempre tornare indietro con `git revert`

## Commit Message Format

Quando correggi un errore precedente, sempre referenziare:

```bash
# Template
git commit -m "fix: corregge [problema] introdotto in commit [SHA]"

# Esempi
git commit -m "fix: corregge syntax error introdotto in commit abc123"
git commit -m "fix: ripristina validazione email rimossa in commit def456"
git commit -m "refactor: migliora performance di metodo in commit ghi789"
```

## Mantra

> "Il codice va avanti, la storia resta.
> Ogni errore è un maestro, ogni commit è una lezione.
> Non cancellare, correggi. Non nascondere, documenta.
> Forward. Always forward. Never backward."

## Conseguenze Violazione

Violare questa regola significa:
- ❌ Perdita di tracciabilità
- ❌ Impossibilità di fare audit
- ❌ Perdita di trust nel team
- ❌ Rischio di perdere modifiche di altri
- ❌ Confusione nella storia del repository

## Questa è la Via

**Forward. Always forward. Never backward.**

Non è un consiglio, è un **comandamento**.
Non è una preferenza, è una **legge**.
Non è una best practice, è **l'unica pratica**.

---

**Ultima revisione**: Novembre 2025
**Status**: Regola Assoluta e Immutabile
