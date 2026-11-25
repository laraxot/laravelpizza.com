# Playbook — manuali utente con screenshot reali

Contesto: repo `/mnt/nas07/var/www/_bases/base_laravelpizza_fila5`, app Laravel 12 modulare
(nwidart) + Filament + Folio/Volt. Ogni modulo ha la sua cartella `laravel/Modules/<M>/docs/manuals/`.

## App in esecuzione

- Front office + pannelli: `http://127.0.0.1:8000` (php artisan serve già attivo)
- Login admin (super-admin): `marco.sottana@gmail.com` / `password` (la password `marco`
  del seeder NON funziona: verificato Hash::check=false — sospetto bug DemoUserSeeder)
- Altri demo: `cittadino@example.test`/`password123`, `waiter1@example.test`/`waiter123`
- Pannello Filament di ogni modulo: `http://127.0.0.1:8000/<modulo-minuscolo>/admin`
  (es. `/activity/admin`, `/notify/admin`, `/user/admin`, `/xot/admin`, `/media/admin`,
  `/ui/admin`, `/geo/admin`, `/lang/admin`, `/job/admin`, `/gdpr/admin`, `/seo/admin`,
  `/tenant/admin`, `/meetup/admin`, `/cms/admin`, `/AI/admin`, `/rating/admin`).
  Il main panel Xot è `/admin`.
- `php artisan route:list | grep filament` per scoprire le URL esatte del modulo.

## Screenshot — usare SEMPRE questo tool

```
node tools/visual/shot.mjs --url /activity/admin --auth --state /tmp/admin-state.json \
  --out laravel/Modules/Activity/docs/manuals/assets/activity-admin-dashboard.png
```

- `--auth` esegue il login Livewire (banner GDPR "Got it", campi `#form.email` / password, bottone "Sign in").
- `--state /tmp/admin-state.json` riusa la sessione salvata (più veloce); se scaduta, rifare `--auth --save-state`.
- `--viewport 375x812` per mobile, `--fullpage` per pagine lunghe, `--wait MS` per Livewire.
- Schermate FO pubbliche: senza `--auth`, URL localizzati `/it/...` o `/en/...`.
- In alternativa `SHOT_PASSWORD=password node tools/visual/shot.mjs ...` (login fresco).
- Playwright risolve da node_modules di base vicini; Chrome: `/usr/bin/google-chrome-stable`.
- MAI inventare screenshot: solo ciò che lo strumento cattura davvero. Se una pagina è
  irraggiungibile/rotta, documentare il fatto nel manuale invece di inscenare.

## Formato manuale (seguire ESATTAMENTE gli esistenti)

Modello: `laravel/Modules/Notify/docs/manuals/manuale-utente.md` e
`laravel/Modules/User/docs/manuals/manuale-utente.md`.

- File: `docs/manuals/manuale-utente.md` (se esiste già, AGGIORNARE — non duplicare;
  `user-manual.md` è una variante inglese/alternativa, valutare coerenza).
- Frontmatter: `title`, `type: user-manual`, `status: active`, `screenshot: assets/<file>.png`,
  `created`, `updated` (data di oggi), `qmd`.
- Subito dopo il frontmatter: blockquote "> Screenshot reale ... verificato il <data>" + `![...](assets/...)`.
- Sezioni: Scopo · Matrice attori (Ospite/Utente autenticato/Grupo/Admin/Super-admin/Operatore)
  · Flussi reali · Prerequisiti · Limiti · Link a codice/docs.
- Screenshot referenziati con path relativi `assets/<nome>.png`.
- NOMI FILE: mai date/timestamp nel nome ( Convenzione ); date solo nel contenuto.
- .md minuscolo-con-trattini; niente .txt o .md extra nella root del modulo.

## Regole di progetto (violazioni = lavoro sbagliato)

- `declare(strict_types=1);` in ogni PHP toccato.
- Docblock `@see Modules/<M>/docs/<file-kebab>.md` su ogni classe/metodo creato/modificato;
  il file docs deve esistere (nella stessa modifica).
- Mai estendere Filament diretto: XotBase (`Modules\Xot\Filament\...`).
- `belongsToManyX`, non `belongsToMany`. Log: no `Log::info/debug` (solo error/warning).
- Niente stringhe hardcoded nei temi (`pub_theme::`/`module::` keys only).
- Test nel modulo: `laravel/Modules/<M>/tests/{Unit,Feature}` (Pest). Suite bloccante CI: `Modules/Meetup/tests`.
- Quality gate dopo fix PHP: `cd laravel && ./vendor/bin/phpstan analyse Modules/<M> --memory-limit=-1`
  (phpstan.neon ha excludePaths `./*/tests/*`), `./vendor/bin/pint <path>`,
  `php artisan test` mirato o `vendor/bin/pest Modules/<M>/tests`.
- **Multi-repo**: `cd laravel/Modules/<M> && git status` — ogni modulo è una repo git
  indipendente: commitare E pushare nel repo del modulo (branch `dev`), poi verificare
  anche il monorepo root se il modulo è tracciato lì. `git remote -v` per il remote owner.
- Git forward-only: niente reset/revert/force-push. Errori → nuovi commit fix.
- Se trovi un bug: fix + test che lo riproduce + documenta nel manuale se visibile all'utente.
- Se trovi codice morto/mancante/scadente: migliora (DRY/KISS), senza riscrivere tutto.
- Un altro agente (codex) potrebbe lavorare in parallelo su altri moduli: prima di
  toccare un modulo controlla `git -C laravel/Modules/<M> status --short` e le mtime;
  se ci sono modifiche non committate fresche (<1h) di un altro agente, NON sovrascrivere:
  saltare quel modulo e segnalarlo nel report finale.

## Report atteso da ogni agente

Per ogni modulo: file creati/modificati, screenshot acquisiti (lista), bug trovati e fixati,
test/phpstan eseguiti con esito, commit hash nel repo modulo, note/limiti.
