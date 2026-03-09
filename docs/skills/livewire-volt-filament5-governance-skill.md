# Skill Operativa: Livewire Volt Filament 5 Governance

## Quando usarla

Usare questa skill quando il task riguarda:

- page files Folio con Volt;
- componenti Livewire single-file;
- integrazione Filament 5 nel tema;
- font/plugin Filament;
- dubbi su cosa debba stare in Folio, Volt, Blade include o Filament.

## Workflow

1. Identificare se il file e' page file Folio, componente Volt, Blade include o componente Filament.
2. Verificare se il path e' montato da `FolioServiceProvider` o `VoltServiceProvider`.
3. Tenere Folio per routing, Volt per interazione, Action per business logic.
4. Se il componente vive nel tema, controllare quali package Filament 5 sono realmente dichiarati nel composer del tema.
5. Se la richiesta riguarda font in Filament, valutare plugin dedicato prima di script/link custom.
6. Se si tocca PHP, eseguire quality gate completo.

## Anti-pattern

- scrivere business logic pesante nel page file o nel template Volt;
- usare plugin/pattern Filament senza verificare che il package sia davvero presente;
- confondere font del panel Filament con font del sito pubblico.
