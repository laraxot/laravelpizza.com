---
title: "filament blade components"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
<<<<<<< .merge_file_f8jZTs
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_cQQnaf
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_f8jZTs
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_cQQnaf
qmd: "filament blade components"
issues: []
discussions: []
---

# Standard <nome progetto>: Componenti Blade Filament

In <nome progetto>, la **prima scelta per i componenti Blade** sono SEMPRE i [componenti nativi Filament](https://filamentphp.com/project_docs/3.x/support/blade-components/overview).
In <nome progetto>, la **prima scelta per i componenti Blade** sono SEMPRE i [componenti nativi Filament](https://filamentphp.com/docs/3.x/support/blade-components/overview).

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
- [Documentazione Filament Blade Components](https://filamentphp.com/docs/3.x/support/blade-components/overview)
<<<<<<< HEAD
- [README Notify](README.md)
=======
<<<<<<< HEAD
<<<<<<< .merge_file_f8jZTs
<<<<<<< HEAD
- [README Notify](README.md)
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_cQQnaf
- [README Notify](readme.md)
=======
- [README Notify](README.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_f8jZTs
=======
- [README Notify](readme.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_cQQnaf
- [queueable-action.md](queueable-action.md)
