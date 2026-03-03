# Filament 5 Ecosystem Benchmark (Meetup) - 2026-03-02

## Perché serve al modulo Meetup
Il modulo Meetup dipende direttamente da Filament 5, Livewire 4, Folio/Volt e routing localizzato: il confronto con altri base Fila5 riduce rischio di fix non portabili.

## Benchmark sintetico
- Cluster aggiornato: `base_fixcity_fila5`, `base_laravelpizza`.
- Cluster intermedio: `base_techplanner_fila5`.
- Cluster arretrato Fila5: `base_ptv_fila5_mono`.

## Regole operative
1. Per bug su widget/dashboard: confrontare con pattern `filament/filament >= 5.2`.
2. Per bug su pagina frontoffice: validare comportamento su `laravel/folio` stable.
3. Evitare dipendenze da comportamenti di `dev-master` Folio.

## Riferimento
- [Filament 5 Bases Study](../../Xot/docs/filament-5-bases-study-2026-03-02.md)
