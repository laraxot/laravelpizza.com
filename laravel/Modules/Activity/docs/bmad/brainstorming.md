---
title: Brainstorming
module: Activity
type: note
status: draft
updated: 2026-10-08
tags: [docs, activity, bmad]
qmd: "activity   brainstorming bmad activity"
---

---
title: "Activity: brainstorming BMAD"
type: concept
tags: [brainstorming, activity, decisioni, debito-tecnico, event-sourcing]
created: 2026-09-28
updated: 2026-09-28
qmd: "Activity brainstorming decisioni aperte event sourcing audit log debito migrazioni"
related:
  - ./brainstorming/module-opportunities.md
  - ./architecture/module-map.md
  - ../architecture.md
  - ./architecture/module-map.md
  - ./epics/module-roadmap.md
issues: []
discussions: []
---

# Activity: brainstorming BMAD

> **SUMMARY**: decisioni prese (con l'evidenza nel codice), problemi aperti
> verificati, e scelte scartate con il motivo.

## Shard

- [module-opportunities.md](./brainstorming/module-opportunities.md): brainstorming preesistente del modulo.
- [module-map.md](./architecture/module-map.md): mappa file -> responsabilita del modulo.

I problemi aperti verificati sono elencati direttamente in [Problemi aperti](#problemi-aperti-verificati-2026-09-28) sotto, perche non esiste uno shard `open-problems.md` in questo modulo.

## Decisioni prese (verificate nel codice)

### D1: I moduli non chiamano il recorder, dispatchano l'evento

Il docblock di `app/Contracts/ActivityRecorderContract.php` lo impone esplicitamente:
*"Modules should dispatch ActivityRecorded events instead of calling this directly"*.
Conseguenza: `ActivityRecorderContract` resta l'**interfaccia** del modulo
(user-facing), ma l'invocazione dall'esterno passa per `app/Events/ActivityEvent.php`.

### D2: Estendere le classi Spatie, non reimplementarle

`Activity extends Spatie\Activitylog\Models\Activity`,
`StoredEvent extends EloquentStoredEvent`, `Snapshot extends EloquentSnapshot`.
Il modulo non duplica lo schema: aggiunge solo cast (`SchemalessAttributes` su
`properties` e `meta_data`) e trait Xot (`HasXotFactory`).

### D3: Il log viewer e a DTO, non a array

Sette classi in `app/Datas/` coprono l'intera catena
(risoluzione -> lista -> albero -> tail -> parsing -> filtro -> stato).
`BuildLogViewerStateAction` e il punto di confluenza: niente array anonimi.

### D4: Ogni Action ha una responsabilita singola

Le 29 Action sono raggruppate in tre famiglie con prefissi di directory che
dicono il dominio (`Log/`, `Query/`, `Schema/`). `AuthorizeLogAccessAction` esiste
perche l'accesso al log e un problema di sicurezza, non un filtro UI.

### D5: Verifica di scrivibilita prima di scrivere

`CheckActivityLogWritableAction` e `IsActivityLogSchemaWritableAction` esistono
perche in questo monorepo le tabelle possono non essere scrivibili (ambiente
condiviso, `10.100.200.15`): il modulo fallisce in modo esplicito invece di
silenziare la scrittura.

## Problemi aperti (verificati 2026-09-28)

### P1: Cinque migrazioni creano la stessa tabella `activity`

`2023_03_31_103350`, `2023_03_31_103351`, `2024_01_01_000001`, `2024_01_01_000002`,
`2026_06_10_141000`, piu `2026_02_13_171410` che interviene su `causer_id`.
Il risultato e che lo stato finale della tabella dipende dall'ordine di
esecuzione. **Non risolto**: consolidare richiederebbe una migration di
normalizzazione su dati gia presenti in ambienti diversi.

### P2: Doppio contratto con lo stesso nome

`app/Contracts/ActivityRecorderContract.php` e
`app/Models/Contracts/ActivityRecorderContract.php` esistono entrambi, insieme a
`app/Contracts/ActivityRecorderInterface.php`. Due moduli che importano
l'interface sbagliata compilano senza errori. **Non risolto**: la rimozione
richiede un'analisi degli import in tutto il monorepo.

### P3: `app/Enums/` e `app/Adapters` non allineati

`app/Enums/` e **vuota**; `app/Adapters/` contiene `ActivityRecorder` e
`ActivityLogger` che non implementano nessuna delle due interfacce dichiarate
(nessun `implements` visibile nei contratti). **Da verificare**: le interfacce
potrebbero essere soddisfatte implicitamente.

### P4: Clone annidato `Activity/Activity/`

Il modulo contiene una copia di se stesso (350 file PHP, 8.1 MB) committata nel
proprio repo git (`git ls-files Activity` = 1242). PHPStan e Pint la analizzano
raddoppiando il modulo. **Fuori scope**: la rimozione e una decisione di history,
non una pulizia.

### P5: HTTP layer vuoto

`app/Http/Controllers/`, `app/Http/Requests/`, `app/Http/Livewire/`,
`app/Http/Middleware/` contengono solo `.gitkeep`. Il `RouteServiceProvider` e
`EventServiceProvider` esistono ma il layer HTTP non e ancora materializzato.

## Scelte scartate

### S1: Esporre un controller REST per il log viewer
Scartato: il consumo previsto e via Filament. Un controller aggiungerebbe una
superficie HTTP non richiesta.

### S2: Sostituire Spatie Activity con una tabella propria
Scartato: `spatie/laravel-activitylog` e gia nel monorepo e i moduli dipendono
da `Activity` per nome. Il costo di migrazione supera il beneficio.

### S3: Unificare le cinque migrazioni in un `migrate:fresh`
Scartato e **vietato**: `migrate:fresh` e `--force` sono banditi dallo standing
order (dati sacri, host `10.100.200.15`).# Brainstorming - Modulo Activity

## Idee iniziali

- [IDEA 1]
- [IDEA 2]
- [IDEA 3]

## Problemi da risolvere

- [PROBLEMA 1]
- [PROBLEMA 2]

## Soluzioni proposte

- [SOLUZIONE 1]
- [SOLUZIONE 2]

## Domande aperte

- [DOMANDA 1]
- [DOMANDA 2]
