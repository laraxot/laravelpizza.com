# Filament 5 Bases Study (2026-03-02)

## Scope
Studio comparativo dei progetti Filament 5 in `/var/www/_bases/` per aumentare confidenza su stack, drift versionale e pattern condivisi.

## Progetti analizzati
- `base_fixcity_fila5/laravel`
- `base_ptv_fila5_mono/laravel`
- `base_<nome progetto>_fila5/laravel`
- `base_<nome progetto>/laravel`

## Version matrix (composer.lock)
| Project | filament/filament | laravel/framework | livewire/livewire | laravel/folio | nwidart/laravel-modules |
|---|---:|---:|---:|---:|---:|
| base_fixcity_fila5 | v5.3.0 | v12.53.0 | v4.2.1 | v1.1.13 | v12.0.4 |
| base_ptv_fila5_mono | v5.0.0 | v12.47.0 | v4.0.1 | n/a | v12.0.4 |
| base_<nome progetto>_fila5 | v5.2.2 | v12.52.0 | v4.1.4 | dev-master | v12.0.4 |
| base_<nome progetto> | v5.2.3 | v12.53.0 | v4.2.0 | v1.1.13 | v12.0.4 |

## Findings
1. `base_<nome progetto>` è allineato al cluster recente Laravel 12 + Filament 5 + Livewire 4.
2. Esiste drift su `laravel/folio` (`dev-master` in un progetto, stable in altri): rischio regressioni routing CMS/Volt.
3. `nwidart/laravel-modules` è stabile su tutti i progetti Fila5 (`v12.0.4`): buona base per pattern condivisi.
4. `base_ptv_fila5_mono` è il più arretrato nel cluster Fila5 (filament `v5.0.0`): utile come benchmark retrocompatibilità.

## Operational implications for <nome progetto>
- Validare feature Folio/Volt contro progetto con `folio` stabile prima di promuovere modifiche.
- Tenere allineati pattern Filament/XotBase a baseline `v5.2+`.
- Usare questa matrice come check pre-incident durante Chaos Monkey.
