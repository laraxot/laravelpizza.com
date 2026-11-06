---
title: "Lingue supportate in un solo posto"
status: backlog
module: Lang (owner)
created: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../../Xot/docs/stories/module-setting-pages.epic.md
  - ../../../Progressioni/docs/stories/progressioni-audit.epic.md
---

# Lingue supportate in un solo posto

## Fase BMAD

Architettura. Nata dall'audit del 2026-10-28 (epic `progressioni-audit`).

## Problema (verificato)

L'elenco delle lingue `['it','en']` e' scritto a mano in 7 punti (`LangBaseResource:26`, `TranslationFileResource:28`, `EditTranslationFile:24`, `GetAllTranslationAction:25`, `GetAllModuleTranslationAction:25`, `UI/Http/Middleware/SetLocale:26`, `Xot/Providers/RouteServiceProvider:68`), mentre `config/laravellocalization.php` dichiara en/es/it e `Lang/config/lang.php` ha `available_locales` mai usato.

## Requisiti

- Una sola fonte (config o Data) letta dai 7 punti.
- Solo dopo valutare una SettingPage di Lang (il routing la legge al boot).

## Criteri di accettazione

- [ ] grep: nessun elenco di lingue scritto nel codice fuori dalla fonte unica.

## File coinvolti

- `vedi elenco`

## Verifica

PHPStan livello 10 sui file toccati, Pint; Pest su ambiente di sviluppo (non su 10.100.200.15).
