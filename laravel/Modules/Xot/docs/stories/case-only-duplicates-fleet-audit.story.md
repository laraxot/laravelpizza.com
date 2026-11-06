---
id: case-only-duplicates-fleet-audit
title: Percorsi duplicati per sola differenza di maiuscole, audit di flotta e piano di bonifica
type: story
status: ready-for-dev
module: Xot (owner trasversale)
created: 2026-11-04
related:
  - ../../../Cms/docs/stories/docs-organization-cms.story.md
  - ../../../Notify/docs/stories/docs-ingressi-notify.story.md
  - ../../../User/docs/stories/user-nested-conflict-marker-cleanup.story.md
  - ../../../Cms/docs/stories/cms-tests-truth-and-types.story.md
qmd: "percorsi duplicati maiuscole minuscole case-only database Migrations migrations Factories tests registertest audit flotta"
---

# Percorsi duplicati per sola differenza di maiuscole

## Fase BMAD

Analisi. Nessun file e' stato cancellato o rinominato: questa story registra l'evidenza e l'ordine di lavoro.

## Perche' esiste

Dopo il giro di `merge_remote_repo_2.sh laraxot` (2026-11-04) i marker di conflitto committati erano spariti
da tutti i 19 repo. La verifica piu' a fondo ha trovato un problema diverso e piu' vecchio: nei repo tracciati
convivono percorsi che differiscono solo per le maiuscole (`database/Migrations` e `database/migrations`,
`RegisterTest.php` e `registertest.php`). Su Linux sono file distinti; su un filesystem che ignora le maiuscole
(macOS, Windows, alcuni mount) uno copre l'altro e il checkout perde contenuto.

## Metodo

Script bash di sola lettura: per ogni repo `git ls-files`, raggruppamento per `tolower(percorso)`, gruppi con piu'
di un percorso. Per i PHP, `cmp` tra le due varianti. Il conteggio dei repo scansionati va sempre stampato:
un primo tentativo con `for p in $REPOS` in zsh non spezzava la variabile, non scansionava nulla e restituiva
"0 problemi", cioe' un falso verde.

## Risultati (2026-11-04)

Moduli e temi: 1.053 gruppi. Piu' 15 in `bashscripts`.

| Modulo | Gruppi | Doc (md) | Codice e altro | PHP identici | PHP divergenti |
|---|---|---|---|---|---|
| Notify | 649 | 614 | 35 | 18 | 2 |
| Lang | 89 | 84 | 5 | 0 | 3 |
| User | 84 | 84 | 0 | 0 | 0 |
| Geo | 62 | 24 | 38 | 0 | 1 |
| Cms | 62 | 2 | 60 | 28 | 23 |
| Xot | 41 | 10 | 31 | 18 | 1 |
| Media | 37 | 32 | 5 | 0 | 5 |
| UI | 12 | 12 | 0 | 0 | 0 |
| Zero | 5 | 5 | 0 | 0 | 0 |
| Tenant | 4 | 2 | 2 | 2 | 0 |
| Gdpr | 4 | 2 | 2 | 0 | 1 |
| Job | 2 | 2 | 0 | 0 | 0 |
| Activity | 2 | 2 | 0 | 0 | 0 |

Altri controlli della stessa verifica, tutti verdi sul codice applicativo:

- `php -l` su 10.215 file PHP tracciati: 217 errori, tutti in `bashscripts` (85 + 85 template di skill duplicati in
  `ai/wiki/skills` e `ai/.agents/skills`, 45 snapshot di tooling, 2 script scratch in `tools/`). Zero in
  `laravel/Modules` e `laravel/Themes`.
- Marker di conflitto in qualunque file tracciato: 0. Residui `.merge_file_*` su disco: 0.

## Cosa non e' un problema

- `database/Migrations` e `database/Factories` (maiuscole): il framework carica solo `database/migrations`
  (`XotBaseServiceProvider::loadMigrationsFrom`) e Composer mappa `Database\Factories` su `database/factories/`.
  Le varianti maiuscole sono codice morto su Linux. Esistono dal 2026-09-24 (non sono una regressione recente).
  `migrate:status` sul modulo Cms non mostra migrazioni da eseguire.
- Nessuna classe in `app/` esiste due volte con lo stesso nome completo, tranne `Xot/app/Http/Http/Controllers/XotBaseController.php`
  (identico, ma il percorso `Http/Http` e' un'anomalia a parte).

## Rischi reali

1. **Test eseguiti due volte.** 22 gruppi in `tests/` (per esempio Cms `RegisterTest.php` e `registertest.php`,
   entrambi modificati il 2026-11-01): Pest carica la cartella, quindi girano entrambe le varianti. Viola la regola
   del nome file test in PascalCase.
2. **36 coppie PHP con contenuto diverso**: Cms 23, Media 5, Lang 3, Notify 2, Geo 1, Xot 1, Gdpr 1. Qui cancellare
   la variante sbagliata perde lavoro.
3. **Viste Blade** `resources/views/Components` contro `components` in Cms (8 gruppi nella cartella e altri sotto):
   Laravel risolve solo il minuscolo, il maiuscolo e' inerte ma confonde chi modifica il file sbagliato.
4. **Lingue**: `Xot/lang/en/labels/backend/takeaway/Ingredient.php` contro `ingredient.php`, contenuto diverso.

## Regola di decisione per gruppo

- Cartelle radice del modulo: solo minuscolo (regola gia' in vigore). Classi, test e componenti PascalCase: nome PascalCase.
- Identici: tenere la variante canonica, rimuovere l'altra con `git rm` in un commit separato.
- Divergenti: confrontare `git log -1` di entrambe e il diff; portare a mano nel percorso canonico solo cio' che
  manca, poi rimuovere l'altro. Mai scegliere "ours/theirs" alla cieca: e' la causa delle regressioni viste in Gdpr.
- Un gruppo alla volta per modulo, con il lock del protocollo multi-agente, `php -l`, PHPStan sui file toccati e
  controllo a runtime dove c'e' una vista o una Action.

## Ordine di lavoro

1. Cms `tests/` (22 gruppi nel fleet, la maggior parte in Cms): fermare l'esecuzione doppia.
2. Cms `database/` (Migrations, Factories, Seeders): identici o divergenti per file, poi rimozione del maiuscolo.
3. Cms `resources/views/Components`.
4. Media, Lang, Gdpr, Geo, Notify, Xot: i 13 PHP divergenti residui.
5. Documentazione (873 gruppi md, di cui 614 in Notify): ultima, non rompe nulla a runtime; coordinare con le story
   `docs-organization-*` gia' aperte nei moduli.

## Cosa non fare

- Nessuna cancellazione di massa e nessun `git mv` su filesystem case-insensitive in un passaggio solo
  (`git mv A a` fallisce): rinomina in due passi.
- Non toccare `bashscripts` in questa story: i 217 errori di sintassi sono template e snapshot, non codice del prodotto.

## Verifica

- Rieseguire lo script di audit e confrontare i conteggi per modulo con la tabella sopra.
- `php -l` e PHPStan sui file toccati; `php artisan migrate:status` sul modulo.
- Pest non e' eseguibile in questa macchina (manca `laravel/.env.testing`, dato dell'utente): la verifica dei test
  duplicati resta da fare in sviluppo.
