---
title: "Audit approfondito modulo UI"
type: audit
status: review
updated: 2026-11-16
module: UI
qmd: "audit UI design system vocabolario visivo dashboard fake data test modelli assenti phpstan-ignore label hardcoded PHPStan Pest"
---

# Audit approfondito — UI

## Scopo (il perché)

UI è il **vocabolario visivo condiviso**: la stessa cosa ha lo stesso aspetto e comportamento
in tutti i moduli (colonne, widget, layout tabella, blocchi, icone). Non ha dominio HR e non
ha Resource proprie: è una libreria consumata da Xot, User, Incentivi, Indennita*
([purpose.md](../purpose.md)). Il rischio qui è la **deriva**: componenti demo, dati finti e
stringhe letterali che si propagano a tutti i consumatori.

## Metodo

Source-first, 2026-11-16: `find`/`grep` su `app/`, `tests/`, `database/`; lettura di
`Filament/Pages/Dashboard.php`, `Models/Policies/UiBasePolicy.php`, `Filament/Components/Schema/PersonForm.php`,
`Services/*`, 3 test di modello; PHPStan sul solo modulo. Nessuna UI inventata, nessun DB toccato.

## Inventario misurato

| Area | N | Nota |
|---|---:|---|
| PHP in `app/` | 133 | |
| Test PHP | 87 | 54 file con `test()/it()/describe()`; rapporto test/app 0,65 |
| Models | 4 + `BaseModel` | `Category`, `Collection`, `FieldOption` (3 migration 2026-07-15) |
| Policy | 1 | `UiBasePolicy` (astratta, solo `before()`) |
| Resource Filament | 0 | |
| Widget | 12 (+3 file `.disabled`, `.disabled2`, `.fila5`) | |
| Actions | 11 | `Actions/{Block,Datetime,Icon,Panel}` |
| Services | 5 | `UIService` (wrapper di `AssetAction`), `ThemeService`, `ComponentService` (classe vuota), `Map/NullMapService`, `Map/NullGeocodingService` |
| Migration | 3 | |
| Lang IT | 123 file | |
| Marker conflitto | 0 | |
| `->label('...')` letterali non commentati | 9 (+1 vuoto) | 8 in `Filament/Components/Schema/PersonForm.php` |
| `@phpstan-ignore` | 48 | tutti `class.notFound`/`property.nonObject` in 3 test (`tests/Unit/Models/{Asset,Component,Theme}ModelTest.php`) |
| `dd/dddx` attivi | 0 | 3 in commenti |
| `migrate:fresh`/`RefreshDatabase` | 0 attivi | solo docblock `tests/TestCase.php:23` ("no RefreshDatabase") |

## Finding

### P1-UI1 — la dashboard del pannello `ui::admin` mostra dati inventati

`app/Filament/Pages/Dashboard.php:28-45`: `StatWithIconWidget::make(['label' => 'Unique views', 'value' => '192.1k'])`
(valore e label fissi, in inglese) più 4× `TestWidget` che incapsulano `TestChartWidget` con
`qid` 5, 7 e 9 cablati. È un demo promosso a produzione: un admin vede una metrica falsa. Fix:
dashboard vuota (o solo widget reali) e spostare `TestWidget`/`TestChartWidget` in `tests/Fixtures`.

### P1-UI2 — copertura "fantasma": 3 test su modelli che non esistono

`tests/Unit/Models/AssetModelTest.php:6-30`: l'Asset **non è nel modulo** (nessun `Models/Asset.php`,
factory né migration) e il test si auto-salta con `class_exists()`; i 48 `@phpstan-ignore` servono
a far tacere PHPStan sul corpo. Idem Component e Theme. Il rapporto 0,65 test/app è quindi gonfiato
e il "PHPStan a 0" nasconde 48 ignore. Il commento cita `no-phpstan-probe-models.md` (giusto non creare
un modello-sonda). Soluzione DRY/KISS: cancellare i 3 file finché il modello non esiste.

### P2

- `Filament/Components/Schema/PersonForm.php:36-76`: 8 `->label('Full Name'…)` e `helperText('schema.org: …')`
  in inglese, nessun consumatore in `app/` (grep) → o si traduce via Lang e lo si usa, o si elimina.
  Regola: nessuna label letterale.
- `Services/ComponentService.php`: classe vuota. `UIService` delega a `AssetAction` (i 3 Service sono
  citati in 6 punti fuori da UI): tenere o inlinare l'Action. `Null*Service`: legittimi (null-object per mappe).
- `Filament/Widgets/UserCalendarWidget.php.{disabled,disabled2,fila5}`: residui di versioni; cancellare.
- `Models/Policies/UiBasePolicy.php`: `before()` concede a `super-admin` e `ui::admin`, **nessun metodo**
  `viewAny/view/...` e non estende `XotBasePolicy`, quindi senza `DeniesUndeclaredFilamentAbilities`:
  la sua unica sottoclasse è un fixture di test. Oggi nessuna Resource UI → nessuna esposizione, ma
  la prima `Resource` su `Category/Collection/FieldOption` senza policy sarebbe aperta a tutti
  (Filament consente le abilità non dichiarate). Estendere `XotBasePolicy`.
- `Category`, `Collection`, `FieldOption`: 3 modelli con migration ma senza policy né Resource.
  Verificare se sono consumati (`rg "Modules\\UI\\Models"`) prima di tenerli.
- `extends` Filament diretto: 0; `extends ServiceProvider` plain: 0 (ok).

## Gate

```bash
cd laravel
php -d memory_limit=3G ./vendor/bin/phpstan analyse Modules/UI --no-progress   # 0 errori (2026-11-16)
./vendor/bin/pest Modules/UI/tests --no-coverage                                 # NON eseguito
```

- PHPStan `Modules/UI`: **0 errori** (exit 0, 17:07).
- Pest: **skip documentato**. `10.100.200.53:3306` irraggiungibile e `TestDatabaseGuard`
  (`Xot/tests/Support/TestDatabaseGuard.php:63`) rifiuta DB non `*_test`; i test appesi al connect MySQL
  non terminano (timeout 150 s osservato su User). `tests/TestCase.php:23` dichiara SQLite condiviso.

## Piano

[epics.md](../epics.md) · [decision-log.md](../decision-log.md) · [piano-miglioramento.md](../piano-miglioramento.md)

## Riferimenti

- [audit.md](../audit.md) · [story](../stories/module-bmad-audit.story.md) · [ECC](../../ecc/ui-ecc-audit.md)
