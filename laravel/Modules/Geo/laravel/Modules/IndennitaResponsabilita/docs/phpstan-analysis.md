---
title: Report Analisi PHPStan - IndennitaResponsabilita
status: action required
priority: high
agent: Gemini CLI
model: gemini-2.0-flash-thinking-exp-01-21
updated: 2026-05-27
---

# 🕵️ Report Analisi PHPStan - Modulo IndennitaResponsabilita

## Stato Attuale
- **Livello Analisi:** 10 (Max)
- **Errori Rilevati:** 33
- **Data:** 27-05-2026

## 📋 Dettaglio Errori

### 1. Funzioni Unsafe (`UpdateModuleDocumentation.php`)
- **Errore:** `Function mkdir is unsafe to use...`
- **Causa:** PHPStan richiede l'uso della libreria `thecodingmachine/safe` per le funzioni di sistema che possono restituire `FALSE`.
- **Proposta:** Aggiungere `use function Safe\mkdir;`, `use function Safe\file_get_contents;`, etc., o gestire esplicitamente il caso `false`.

### 2. Eventi (`DatiSalvati.php`)
- **Errore:** `Class ... implements unknown interface ShouldBroadcast.`, `Access to an undefined property $form.`
- **Causa:** Interfaccia mancante e proprietà non dichiarata nel modello/evento.
- **Proposta:** Verificare l'import di `ShouldBroadcast` e dichiarare esplicitamente le proprietà `$form` e `$nuoviDati`.

### 3. Componenti Filament (`ProgressIndicator.php`)
- **Errore:** `Class ... extends unknown class Filament\Forms\Components\Component.`
- **Causa:** Import errato o pacchetto Filament non configurato correttamente per il bootstrap.
- **Proposta:** Verificare se deve essere `Filament\Schemas\Components\Component` (Pattern Laraxot v5).

### 4. Resources (`MailTemplateResource.php`, `ListStabiDirigentes.php`)
- **Errore:** Return type mismatch.
- **Causa:** `getEloquentQuery` restituisce un Builder generico; `getHeaderActions` include `ActionGroup`.
- **Proposta:** 
    - In `MailTemplateResource`, tipizzare il ritorno come `Builder<MailTemplate>`.
    - In `ListStabiDirigentes`, aggiornare il PHPDoc in `@return array<string, Action|ActionGroup>`.

### 5. Modelli e Trait (`whereRaw`)
- **Errore:** `literal-string` expected.
- **Causa:** Concatenazione dinamica in `whereRaw`.
- **Proposta:** Usare bindings o il pattern `@phpstan-ignore argument.type`.

## 🚀 Prossimi Passi
1. Applicazione dei fix seguendo i pattern Laraxot.
2. Validazione con PHPStan.
3. Update BMAD Story.

---
*Firmato: Gemini CLI (Model: gemini-2.0-flash-thinking-exp-01-21)*
