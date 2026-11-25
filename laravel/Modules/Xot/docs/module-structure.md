---
title: "Struttura dei moduli: layout, root hygiene, namespace"
type: rule
status: active
module: Xot
qmd: "struttura modulo root hygiene app-only namespace PSR-4 code-workspace README CHANGELOG routes web api empty.php lang resources svg module.json composer.json"
updated: 2026-11-25
---

# Struttura dei moduli

## Layout

```
laravel/Modules/<Modulo>/
  app/            tutto il PHP di produzione (Actions, Datas, Enums, Filament, Http, Models, Providers, ...)
  config/         config.php obbligatorio
  database/       migrations/ factories/ seeders/
  docs/           documentazione del modulo (vedi docs-conventions.md)
  lang/           traduzioni (i moduli traducono da lang/; i temi da resources/lang)
  public/         asset pubblici del modulo
  resources/      views/, svg/ (icone), assets/
  routes/         web.php e api.php, sempre presenti
  tests/          Unit/ Feature/ Arch/ (Pest)
  module.json  composer.json  README.md  CHANGELOG.md  _module_<nome>_fila5.code-workspace
```

- **Tutto il PHP sta sotto `app/`**: nessuna cartella di codice in root. nwidart mappa `app/` sul namespace `Modules\<Modulo>\`, quindi un file in
  `Modules/Meetup/app/Models/Event.php` e' `Modules\Meetup\Models\Event`; il namespace non contiene mai il segmento `app` ne' `App`.
- Una classe per file, nome del file = nome della classe, cartelle PascalCase **nel namespace** (la root del modulo no, vedi sotto). Sensibilita' a maiuscole/minuscole:
  vedi [git-sync-and-case-sensitivity.md](git-sync-and-case-sensitivity.md).
- Un modulo ha almeno due provider, elencati in `module.json` **e** in `composer.json` (dettagli in [serviceprovider-minimal-structure.md](serviceprovider-minimal-structure.md)).
- Le icone SVG stanno in `resources/svg/` e si richiamano per nome del set; mai SVG inline nelle Blade.
- Asset pubblici: `public_html/assets/<modulo>` e' un symlink relativo a `laravel/Modules/<Modulo>/public` (vedi [themes-views-and-assets.md](themes-views-and-assets.md)).

## Igiene della root (guardia `tests/Unit/ModuleRootHygieneTest.php`)

Per ogni modulo con repository git propria (`Modules/<Mod>/.git`):

1. nessuna cartella con maiuscole in root;
2. nessuna cartella di tooling (`bashscripts`, `graphify-out`, `tools`, ...);
3. un solo `*.code-workspace`, chiamato `_module_<nome>_fila5.code-workspace`, con `<nome>` ricavato dal remote git del modulo;
4. `README.md` e `CHANGELOG.md` presenti, al massimo 6 `.md` in totale in root;
5. `.github/skills` assente e ignorato (`/.github/skills/` nel `.gitignore` del modulo);
6. `docs/graphify` assente e ignorato;
7. `resources/lang` assente e ignorato nei moduli (non nei temi, che caricano da li');
8. `*.lock` ignorato e mai tracciato (i lock degli agenti `bashscripts/lock/lock.sh` stanno accanto al file bloccato).

Story: [bmad/stories/0103-module-root-hygiene.story.md](bmad/stories/0103-module-root-hygiene.story.md).

## Route

`XotBaseRouteServiceProvider` carica sempre `routes/web.php` (middleware `web`) e `routes/api.php` (prefisso `api`) del modulo. Un modulo senza rotte lascia i due file
**presenti e minimi** (`declare(strict_types=1);` e un commento): e' vietato un `require` di un file rotte condiviso "vuoto" sotto un altro modulo (non esiste
`Modules/Xot/routes/empty.php`, e un `require` verso di esso e' un sintomo di merge sbagliato). Guardia: `tests/Unit/Architecture/NoSharedEmptyRouteFileTest.php`
([ADR 0029](adr/0029-no-shared-empty-route-file.md)).

## Tre pannelli Filament per modulo

Ogni modulo con interfaccia admin ha un `Providers/Filament/AdminPanelProvider` (estende `XotBasePanelProvider`, `protected string $module = '<Modulo>'`) e una pagina
`Filament/Pages/Dashboard` basata su `XotBaseDashboard`; le Resource, le Page e i Widget estendono le basi Xot ([xotbase-extension-rules.md](xotbase-extension-rules.md)).
Niente componenti Livewire autonomi nei moduli: i widget Filament li sostituiscono ([ADR 0008](adr/0008-filament-widgets-over-standalone-livewire.md),
guardia `tests/Unit/NoLivewireDirectoriesInModulesTest.php`).

## Guardie

`tests/Unit/ModuleRootHygieneTest.php`, `tests/Unit/Architecture/NoSharedEmptyRouteFileTest.php`, `tests/Unit/NoLivewireDirectoriesInModulesTest.php`,
`tests/Unit/CaseCollisionsDoNotGrowTest.php`, `tests/Unit/Deploy/ModulePublicAssetsLinksTest.php`.
