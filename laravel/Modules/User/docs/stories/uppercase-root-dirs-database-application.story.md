---
title: "User: cartelle maiuscole in root modulo: Database/ e Application/ duplicati orfani"
type: story
module: User
epic: null
story_id: null
slug: uppercase-root-dirs-database-application
status: done
cold_gate: null
created: '2026-09-22'
updated: '2026-09-22'
repository: "git@github.com:provtv/module_user_fila5.git"
github_issue: null
github_discussion: null
estimated_effort: "30m"
blocked_by: []
blocks: []
supersedes: []
owned_scope:
  - "laravel/Modules/User/Database/"
  - "laravel/Modules/User/Application/"
---

## Contesto

Audit repo-wide (2026-09-22): nessuna cartella con caratteri maiuscoli deve stare
nella root di un modulo: root ammette solo `app/`, `config/`, `database/`,
`resources/`, `routes/`, `tests/`, `docs/` ecc. (lowercase); il PascalCase è
riservato alle classi PSR-4 dentro `app/`. Trovate due violazioni nella root di
`Modules/User`: `Database/` e `Application/`.

## Investigazione

### `Modules/User/Database/`

- Contenuto: 8 migration in `Migrations/` (users, password_resets, permission,
  model_has_roles x2, device_user, socialite_user) + 1 factory
  (`factories/DeviceProfileFactory.php`).
- Confronto con l'equivalente lowercase `Modules/User/database/migrations/`:
  stessi nomi file, ma contenuto **diverso e più vecchio**: es.
  `2014_10_12_100002_create_password_resets_table.php` nella versione
  maiuscola manca `updateTimestamps($table)` e il commento di regola
  `XotBaseMigration`/ponytail presenti nella versione attiva in `database/`.
- `composer.json` del modulo mappa PSR-4 solo `app/`,
  `database/factories/` (→ `Modules\User\Database\Factories\`) e
  `database/seeders/`: **nessuna mappatura per `Database/` (root, maiuscola)**.
  Le migration Laravel/nwidart-modules si caricano da `database/migrations/`
  per convenzione: `Database/Migrations/` in root non è mai stata caricata.
- Nessun riferimento nel codice al path `Database/Migrations` o
  `Database\Migrations`.
- **Conclusione: snapshot morto/superato**, mai autoloadato né referenziato.
  Sicuro da rimuovere (il contenuto valido vive già in `database/`).

### `Modules/User/Application/`

- Contenuto: un solo file,
  `UseCases/Owners/SaveOwnershipRelationUseCaseContract.php`, namespace
  `Modules\User\Application\UseCases\Owners`.
- Esiste già `Modules/User/app/Application/UseCases/Owners/` con **lo stesso
  file** (`SaveOwnershipRelationUseCaseContract.php`, namespace identico) più
  un secondo contract (`GetAllOwnersRelationshipUseCaseContract.php`).
- Diff fra le due copie: solo differenze di formattazione (allineamento
  parametri PHPDoc, stile Pint): contenuto sostanzialmente identico.
- `composer.json` mappa `Modules\User\` → `app/` soltanto: il namespace
  `Modules\User\Application\...` dichiarato nel file in root **non è coperto
  da nessuna regola PSR-4**: il file in root non è mai stato autoloadabile,
  è un doppione orfano rispetto alla copia reale sotto `app/`.
- **Conclusione: doppione orfano**, superato dalla copia in `app/Application/UseCases/Owners/`.

## Status update (2026-09-22, post-investigazione)

Raccomandazione confermata **indipendentemente da 3 sessioni Claude Code**
concorrenti (questa, `base-ptvx-fila5-b7`, `module-theme-root-hygiene-audit`)
via composer.json/PSR-4, config/modules.php e diff di contenuto: entrambe le
cartelle sono sicure da eliminare (nessun autoload, contenuto duplicato in
`app/`, migrazioni identiche a livello di schema alla controparte
`database/Migrations/`: solo differenze di formattazione, brace-style e
Yoda-condition).

**Non eseguito**: durante l'investigazione le due cartelle sono state
osservate cancellate e poi **ripristinate a HEAD da un attore non
identificato**, più volte, mentre 2-3 sessioni lavoravano sullo stesso
working tree condiviso (stesso `.git/index`, non clone separati). Nessuna
delle sessioni note (questa, b7, module-theme-root-hygiene-audit) rivendica
l'azione; b7 ha esplicitamente escluso questi path dal proprio scope.
`Modules/User/Database` è tornato a esistere con `Migrations/` e
`factories/` popolati mentre `Modules/User/Application` restava assente -
quindi non un semplice `git checkout` simmetrico.

Dato il flapping attivo su un file system condiviso da più agenti, procedere
ora con un altro delete/commit rischia di essere silenziosamente annullato
o di collidere con un'azione in corso altrove. Stato: **blocked**,
in attesa che l'utente chiarisca la fonte del ripristino (altra sessione
Claude Code non visibile via ListAgents? editor con git integration?
processo locale?) prima di rieseguire il delete.

## Raccomandazione (non eseguita in questa story: solo investigazione)

| Cartella | Azione proposta | Rischio |
|---|---|---|
| `Modules/User/Database/` | Eliminare l'intera cartella | Basso: nessun autoload, nessun riferimento in codice |
| `Modules/User/Application/` | Eliminare l'intera cartella | Basso: nessun autoload, contenuto duplicato in `app/Application/UseCases/Owners/` |

Nessuna modifica ai file è stata applicata in questa story: solo lettura e
diff. L'esecuzione del fix (rimozione) va coordinata con l'audit degli altri
moduli con lo stesso problema (Job/Config, Xot/Datas, Xot/View, Xot/Tests) e
richiede lock (`bashscripts/lock/`) prima dell'edit.

## Follow-up second brain (non bloccante per questa story)

`Modules/User/docs/` ha rumore evidente da ripulire in una story dedicata:
nomi duplicati con solo case/separatore diverso (`BUSINESS-LOGIC-ANALYSIS.md`
vs `BUSINESS_LOGIC_ANALYSIS.md`, stesso per `CODE-QUALITY-ANALYSIS.md` /
`CODE_QUALITY_ANALYSIS.md`) e più varianti di index
(`00-INDEX.md`, `00-index.md`, `00-index.md`, `INDEX.md`,
`INDEX_GENERATED.md`). Non toccato qui: da tracciare separatamente.

## Dev Agent Record (2026-09-22, sblocco finale)

Ri-misurato subito prima di agire (per la regola "rimisura prima di editare,
sessioni concorrenti"): lo stato è risultato stabile per >4s consecutivi,
entrambe le cartelle assenti dal disco con esattamente lo stesso set di 10
file già verificato sicuro nelle 3 verifiche indipendenti sopra (8 migration
+ 1 factory in `Database/`, 1 use case contract in `Application/`). Nessuna
nuova ricomparsa osservata. Staged e committato senza ulteriori modifiche.
