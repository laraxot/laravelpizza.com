# Analisi Qualità - Modulo Performance

**Data Analisi**: 2025-01-22  
**Analista**: AI Assistant  
**Status**: In Progress

---

## Aggiornamento verifica 2026-07-01

- **PHPStan** (`level: max`): **0 errori** confermati (invariato).
- **PHPMD**: rimosse tutte le `UnusedLocalVariable` rilevate (16 occorrenze) nelle pipeline di calcolo Individuale/Organizzativa. Attenzione particolare data la criticità del codice (calcolo importi/bonus performance):
  - `Actions/Individuale/UpdateImportoTotaleByValutatoreIdAction.php` e `UpdateRestiPondByValutatoreIdAction.php` — rimosso `$normalizationFactor` (approccio di normalizzazione abbandonato, superato dal calcolo per-scheda `$punteggioNormalizzato`/formula con `delta`; verificato che non fosse più referenziato altrove).
  - `Actions/Individuale/UpdateQuotaTeoricaAction.php` e `Actions/Organizzativa/UpdateQuotaTeoricaAction.php` — `$html` (tabella di debug mai stampata, solo `// echo $html` commentato): ora effettivamente loggata via `Log::debug()` invece di restare dead code, preservando il side-effect del loop (`$row->{$field}` "forza mutator/accessor" — commento originale, non toccato il comportamento).
  - `Actions/Organizzativa/CheckSumAction.php`, `UpdateImportoTotaleAction.php`, `UpdateRestiPondAction.php`, `UpdateTotStabiAction.php` — rimosse variabili tabella (`$tbl_categoria_coeff`, `$conn`, `$res`) mai lette, verificando prima che non fossero usate più avanti nel metodo.
  - `Actions/Organizzativa/UpdateTotValutatoreIdAction.php` — `$res` da `TotValutatoreId::create()` mai usato, rimossa assegnazione.
  - `Actions/TrovaEsclusiAction.php` — destructuring `[$ha_diritto, $motivo]` con `$ha_diritto` mai usato: sostituito con `[, $motivo]` (idiomatico, nessun cambio di comportamento).
  - `Models/Traits/FunctionTrait.php` — `$msg` costruito solo per un `dddx()` commentato, rimosso.
  - `Models/Traits/MutatorTrait.php` — `$aszdur` (frammento SQL per parsing formato ora:minuti) mai usato nella query effettiva (che usa `CAST(...)` diretto): rimosso, verificato che la query non lo referenzia.
  - **Nessuna formula di calcolo modificata**: tutti i fix sono rimozioni di variabili provabilmente morte (mai lette dopo l'assegnazione), verificate singolarmente per non alterare importi/risultati.
- **PHPInsights**: non esaminato in dettaglio in questa sessione oltre a quanto già presente in questo documento; nessun `--fix` automatico eseguito (rischio regressioni PHPStan riscontrato nel modulo Lang).
- **Test**: nessun test mancante creato per le rimozioni di dead code (nessun cambio di comportamento pubblico). Esecuzione `pest` bloccata in questo sandbox da un problema di infrastruttura pre-esistente (manca `database/database.sqlite`), non imputabile al codice — non eseguito `migrate`/`migrate:fresh` per rispettare la regola "dati sacri".

## 📊 Risultati Strumenti Qualità

### PHPStan Livello 10 ✅
- **Errori**: **0** ✅
- **Status**: Perfetto
- **Note**: Tutti i file passano PHPStan livello 10

### PHPMD ⚠️
- **Violations**: ~15 (StaticAccess warnings + 1 ElseExpression)
- **Categorie**: cleancode, codesize, design
- **Status**: Accettabile (warnings su Facades Laravel, accettati)

**Violations Identificate**:
1. `GeneratePdfAction.php` - StaticAccess a `View` (1)
2. `GetHaDirittoMotivoAction.php` - StaticAccess a `Str`, `Carbon` (3)
3. `CheckSumAction.php` (Individuale) - ElseExpression (1)
4. `UpdateImportoTotaleByValutatoreIdAction.php` (Individuale) - StaticAccess a `PerformanceFondo` (1)
5. `UpdateQuotaTeoricaAction.php` - StaticAccess a `Assert`, `PerformanceFondo` (2)
6. `UpdateRestiPondByValutatoreIdAction.php` - StaticAccess a `DB` (1)
7. `UpdateTotValutatoreIdAction.php` - StaticAccess a `IndividualeTotValutatoreId`, `DB` (3)
8. `CheckSumAction.php` (Organizzativa) - StaticAccess a `Assert`, `PerformanceFondo` (2)
9. `UpdateImportoTotaleByValutatoreIdAction.php` (Organizzativa) - StaticAccess a `DB` (1)

**Analisi**: 
- Le violazioni StaticAccess sono principalmente su Facades Laravel (`View`, `DB`, `Str`) e classi static (`Assert`, `Carbon`, `PerformanceFondo`). Per Laravel, l'uso di Facades è accettato.
- **ElseExpression**: 1 violazione in `CheckSumAction.php` - da valutare se semplificare

### PHPInsights
- **Status**: Errore (richiede composer.lock)
- **Note**: Da eseguire manualmente dopo fix composer.lock

## 🔍 Problemi Identificati

### 1. ElseExpression (LOW Priority)

**File**: `Actions/Individuale/CheckSumAction.php:47`  
**Problema**: Uso di `else` che può essere semplificato  
**Priorità**: BASSA (code smell minore)

## 📋 Piano di Azione

### Priorità CRITICA
- Nessuna (PHPStan perfetto ✅)

### Priorità ALTA
- [ ] Eseguire PHPInsights completo (dopo fix composer.lock)
- [ ] Analizzare Architecture score
- [ ] Verificare comment coverage

### Priorità MEDIA
- [ ] Valutare semplificazione `else` in `CheckSumAction.php`
- [ ] Documentare pattern comuni
- [ ] Creare guide best practices

## 🔗 Collegamenti

- [Performance README](../README.md)
- [Xot Quality Analysis](../../Xot/docs/quality-analysis/current-status.md)

## 📝 Note

- PHPStan livello 10: **PERFETTO** ✅
- PHPMD: Warnings accettabili (Facades Laravel)
- PHPInsights: Richiede fix composer.lock
- Business logic: Complessa ma ben strutturata


