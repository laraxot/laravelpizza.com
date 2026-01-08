# 🎯 INDICE SUPREMO: Testing Business Behavior Rules

## LA REGOLA PIÙ IMPORTANTE DI TUTTO IL PROGETTO

**IL TESTING DEVE VERIFICARE IL COMPORTAMENTO BUSINESS, NON L'IMPLEMENTAZIONE!**

Questa è la regola fondamentale che ha precedenza ASSOLUTA su qualsiasi altra considerazione di testing in tutto il progetto <nome progetto>.

## MANTRA UNIVERSALE

🔥 **"COMPORTAMENTO BUSINESS, NON IMPLEMENTAZIONE"** 🔥

## INDICE DELLE REGOLE DI TESTING

### 📋 Regole Principali
1. **[Testing Business Behavior Supreme Rule](testing-business-behavior-supreme-rule.md)** - LA REGOLA SUPREMA
2. **[Testing Priority Rule](testing-priority-rule.md)** - Priorità operative
3. **[Model Testing Philosophy](model-testing-philosophy.md)** - Filosofia modelli "slim"

### 🔧 Guidelines Tecniche
- **[Laravel AI Guidelines - Testing Fundamental](../laravel/.ai/guidelines/testing-fundamental-rule.md)**
- **[Laravel AI Guidelines - Testing Business Behavior](../laravel/.ai/guidelines/testing-business-behavior.md)**
- **[Laravel AI Guidelines - Testing Priority](../laravel/.ai/guidelines/testing-priority-rule.md)**

### 📁 Regole per Modulo
- **[<nome progetto> Testing Guidelines](../laravel/Modules/<nome progetto>/docs/testing-guidelines.md)**

### ⚙️ Regole Sistema
- **[Windsurf Rules - Testing Business Behavior](../.windsurf/rules/testing-business-behavior-supreme.mdc)**
- **[Cursor Rules - Testing Business Behavior](../.cursor/rules/testing-business-behavior-supreme.mdc)**

## RESPONSABILITÀ ASSOLUTE

### ✅ SEMPRE FARE
- **Sistemare test esistenti** prima di crearne di nuovi
- **Convertire test implementativi** in test comportamentali
- **Testare comportamento business**: regole, validazioni, flussi utente
- **Focus sul valore utente**: cosa vede e sperimenta l'utente finale
- **Test resilienti**: devono sopravvivere ai refactor

### ❌ MAI FARE
- **Cancellare test esistenti** senza averli sistemati
- **Testare implementazione**: proprietà modelli, trait, configurazioni
- **Testare dettagli framework**: funzionalità di Laravel/Filament
- **Ignorare test falliti** per crearne di nuovi
- **Usare RefreshDatabase** se non strettamente necessario

## CHECKLIST UNIVERSALE

Prima di qualsiasi lavoro sui test:

- [ ] Ho letto e compreso la regola suprema sul business behavior
- [ ] Ho identificato tutti i test esistenti
- [ ] Ho convertito test implementativi in test comportamentali
- [ ] Ho fatto funzionare tutti i test esistenti
- [ ] Sto testando comportamento business, NON implementazione
- [ ] I miei test sopravviverebbero a un refactor dell'implementazione

## FILOSOFIA

### Il Test Come Documentazione
I test devono documentare il **comportamento atteso** del sistema dal punto di vista business, non come funziona internamente il codice.

### Il Test Come Protezione
I test devono proteggere da **regressioni funzionali reali**, non da cambiamenti implementativi che non alterano il comportamento.

### Il Test Come Valore
Ogni test deve avere un **chiaro valore business** e deve essere comprensibile a un business analyst.

## ESEMPI UNIVERSALI

### ✅ CORRETTO (Business Behavior)
```php
it('creates appointment when doctor and patient are available')
it('prevents double booking for same time slot')
it('sends notification when appointment is confirmed')
it('calculates correct appointment duration')
it('applies business rules for appointment cancellation')
```

### ❌ ERRATO (Implementation Details)
```php
it('model has fillable attributes')
it('uses specific trait')
it('calls internal method')
it('has correct database table name')
it('has proper relationships defined')
```

## AGGIORNAMENTI E MANUTENZIONE

Questo indice deve essere aggiornato ogni volta che:
- Si aggiungono nuove regole di testing
- Si modificano regole esistenti
- Si creano nuovi moduli con regole specifiche
- Si identificano nuovi anti-pattern

## APPLICABILITÀ

Queste regole si applicano a:
- **TUTTI i test** in tutto il progetto
- **TUTTI i moduli** Laravel
- **TUTTE le tipologie** di test (Unit, Feature, Browser)
- **TUTTI i framework** utilizzati (Pest, PHPUnit, Filament, Livewire)

---

**Questa è la REGOLA SUPREMA del progetto <nome progetto> e ha precedenza su qualsiasi altra considerazione di testing.**

**Ultimo aggiornamento**: Gennaio 2025  
**Status**: REGOLA SUPREMA E NON NEGOZIABILE  
**Applicabilità**: UNIVERSALE - tutto il progetto
