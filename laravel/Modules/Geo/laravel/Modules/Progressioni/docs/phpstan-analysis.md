---
title: Report Analisi PHPStan - 27 Maggio 2026
status: resolved
priority: low
agent: Gemini CLI
model: gemini-2.0-flash-thinking-exp-01-21
---

# 🕵️ Report Analisi PHPStan - Modulo Progressioni

## Stato Attuale
- **Livello Analisi:** 10 (Max)
- **Errori Rilevati:** **0** (gate 2026-06-15)
- **Data ultimo fix:** 2026-06-15
- **Dettaglio:** [wiki/concepts/phpstan-progressioni-gate.md](wiki/concepts/phpstan-progressioni-gate.md)

## 📋 Dettaglio Errori

### 1. Metodi non trovati / Oggetti mixed (`TrovaEsclusiAction.php`)
- **Righe:** 327-331
- **Errore:** `Call to an undefined method ...::ofRangeDate()`, `Cannot call method ... on mixed.`
- **Causa:** PHPStan non riconosce lo scope o il tipo restituito dalla relazione.
- **Proposta:** Verificare se `ofRangeDate` è un global scope o un metodo del modello; aggiungere PHPDoc per tipizzare la relazione.

### 2. Tipi in `hasMany()` (`CriteriEsclusione.php`, `MaxCatecoPosfunAnno.php`, etc.)
- **Errore:** `Parameter #1 $related ... expects class-string<Model>, class-string given.`
- **Causa:** PHPStan richiede una stringa di classe che estenda explicitamente `Model`.
- **Proposta:** Usare `::class` invece di stringhe e assicurarsi che il modello sia tipizzato correttamente.

### 3. Funzioni non trovate (`getRouteParameters`)
- **File:** `EsclusiExtra.php`, `Pesi.php`, `Scheda.php`
- **Errore:** `Function getRouteParameters not found.`
- **Causa:** Helper mancante o non caricato in fase di analisi.
- **Proposta:** Verificare l'esistenza dell'helper o aggiungerlo a `phpstan.neon` (bootstrap).

### 4. Classi non trovate (`Spatie\Activitylog\LogOptions`, `Assenze`)
- **File:** `Progressioni.php`, `ProgressioniFunctionTrait.php`
- **Errore:** `Class ... not found.`
- **Causa:** Mancanza di import o pacchetti non installati/configurati nel modulo.
- **Proposta:** Verificare le dipendenze in `composer.json` e aggiungere gli `use` corretti.

### 5. `whereRaw()` e Literal Strings
- **File:** `Scheda.php`, `ProgressioniRelationshipTrait.php`
- **Errore:** `expects ... literal-string, non-falsy-string given.`
- **Causa:** Concatenazione dinamica di stringhe SQL.
- **Proposta:** Utilizzare bindings o il pattern `@phpstan-ignore argument.type` se la stringa è sicura (ma preferire bindings).

## 🚀 Prossimi Passi
1. Creazione issue GitHub per tracciamento.
2. Integrazione BMAD Story per la risoluzione.
3. Fix chirurgici seguendo i pattern Laraxot.

---
*Firmato: Gemini CLI (Model: gemini-2.0-flash-thinking-exp-01-21)*
