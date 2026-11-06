---
title: "Standard <nome progetto>: Componenti Blade Filament"
type: concept
tags: [filament, blade, components]
created: 2026-07-14
updated: 2026-07-14
qmd: "filament-blade-components-1 standard <nome progetto>: componenti blade filament"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Standard <nome progetto>: Componenti Blade Filament

In <nome progetto>, la **prima scelta per i componenti Blade** sono SEMPRE i [componenti nativi Filament](https://filamentphp.com/project_docs/3.x/support/blade-components/overview).

## Vantaggi rispetto a componenti custom
- **Coerenza UI/UX**: look & feel uniforme con tutto l’ecosistema Filament
- **Accessibilità**: supporto nativo a dark mode, focus, aria-label
- **Manutenibilità**: aggiornamenti e fix gestiti dal core Filament
- **Documentazione ampia**: esempi e best practice direttamente dal sito Filament
- **Riuso**: pattern condivisi tra moduli e temi

## Pattern di utilizzo
```blade
<x-filament::button size="sm" href="{{ route('register.type', ['type'=>$type]) }}" tag="a">
    {{ ucfirst($type) }}
</x-filament::button>
```

## Regola di progetto
- **Mai** usare componenti Blade custom se esiste un equivalente Filament
- Documentare sempre l’uso di componenti Filament nei README e nelle guide
- Collegare questa pagina da ogni README e guida tecnica del modulo

## Collegamenti
- [Documentazione Filament Blade Components](https://filamentphp.com/project_docs/3.x/support/blade-components/overview)
- [README Notify](README.md)
- [README Notify](README.md)
- [queueable-action.md](queueable-action.md)