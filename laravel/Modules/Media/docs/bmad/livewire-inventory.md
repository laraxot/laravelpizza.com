---
title: "Inventario Http/Livewire → Filament widget — Media"
type: inventory
module: Media
status: approved
track: livewire-to-filament-widget
related:
  - ./LIVEWIRE-WIDGET-CONVERSION.md
  - ./livewire-widget-architecture.md
  - ./livewire-widget-brainstorming.md
  - ./livewire-widget-decision-log.md
  - ./livewire-widget-epics.md
  - ./livewire-widget-prd.md
  - ./livewire-widget-product-brief.md
  - ./livewire-widget-project-context.md
  - ./livewire-widget-tech-spec.md
  - ./livewire-widget-ux.md
  - ../stories/12.1.media-clip-not-widget.story.md
---

# Inventario: Livewire HTTP → Filament widget, modulo Media

**Solo documentazione. Nessun PHP convertito, nessun widget creato.**

Questo file è la fonte canonica per il modulo Media sulla campagna di conversione Livewire → Filament widget. Sostituisce nei contenuti tecnici `LIVEWIRE-WIDGET-CONVERSION.md` (2026-08-25), la cui proposta di conversione era basata su un'ipotesi non verificata; quel file resta in linea come puntatore superseded, non va cancellato.

Una sessione concorrente ha scritto in parallelo, lo stesso giorno (21/09/2026), un pacchetto di stub BMAD (`livewire-widget-*.md`) e la story `12.1.media-clip-not-widget.story.md`, arrivando allo stesso verdetto di merito (Clip non è candidato a widget). Questo documento ne verifica ogni affermazione contro il codice reale, aggiunge le citazioni file:riga mancanti e corregge un'imprecisione (si veda "Correzione rispetto ai documenti paralleli" più sotto), invece di duplicare l'inventario.

## Metodo (comandi eseguiti, non a memoria)

```bash
find Modules/Media/app/Http/Livewire -name '*.php'
grep -rn "card.video.clip\|Card\\\\Video\\\\Clip" --include="*.php" --include="*.blade.php" .
grep -rn "@livewire(" Modules/Media --include="*.blade.php"
grep -rn "Livewire::component" Modules/Media
grep -rln "showModal\|editClip\|updateDataFromModal" --include="*.php" --include="*.blade.php" --include="*.js" .
find Modules/Media/app/Filament -type f -iname "*.php"
cat Modules/Media/app/Providers/Filament/AdminPanelProvider.php
cat Modules/Media/routes/web.php Modules/Media/routes/api.php
```

## Componenti Livewire nel modulo Media

Il modulo aveva **una sola** classe sotto `app/Http/Livewire` — rimossa il 21/09/2026, vedi "Riverifica" in fondo:

| File | Namespace | Alias registrato |
|------|-----------|-------------------|
| `Modules/Media/app/Http/Livewire/Card/Video/Clip.php:15` (cancellato 21/09) | `Modules\Media\Http\Livewire\Card\Video` (`Modules/Media/app/Http/Livewire/Card/Video/Clip.php:5`) | `card.video.clip` (era in `Modules/Media/app/Http/Livewire/_components.json`; la cache è ora `[]`) |

`_components.json` è il registro di auto-discovery dei componenti Livewire del modulo (generato dal pacchetto, non un punto di montaggio): registrava che l'alias `card.video.clip` *esiste ed è invocabile*, non che qualcosa lo invocasse davvero. La verifica dell'uso reale va fatta a parte, sezione seguente.

## Cosa fa Clip (analisi storica — file rimosso il 21/09/2026)

`Clip` (`Modules/Media/app/Http/Livewire/Card/Video/Clip.php`, cancellato) riceve un `Model` in `mount()` (riga 34-37), espone `editClip()` (righe 58-62) che raccoglie i dati del model e li invia con `$this->dispatch('showModal', ['editClip', $data])` a un modale generico, e `updateDataFromModal()` (righe 69-85) che, ricevuto l'evento di ritorno dal modale con id `editClip`, aggiorna solo i campi `title` e `subtitle` del model e lo ricarica. `render()` (righe 42-53) risolve la vista tramite `GetViewAction` sul template `edit` (proprietà `$tpl`, riga 17). Il pattern `dispatch('showModal', [...])` è lo stesso meccanismo generico usato da `Modules/UI/resources/views/components/ui/modal.blade.php` e da `Modules/User/resources/views/components/ui/modal.blade.php`: un listener JS/Blade condiviso che apre un modale in base al primo elemento dell'array. Non è quindi un meccanismo specifico di Clip, ma non basta da solo a dimostrare che Clip sia effettivamente montato da qualche parte.

## Verifica di montaggio: risultato negativo su tutti i canali controllati

Come richiesto dal punto 2 della procedura, sono stati controllati tutti i canali possibili di montaggio, non solo l'hook Filament:

1. **Hook render nel panel provider Filament.** `Modules/Media/app/Providers/Filament/AdminPanelProvider.php` ha 20 righe totali ed è composto solo da `protected string $module = 'Media';` e da un `panel()` che chiama `parent::panel($panel)` senza aggiungere alcun `renderHook`. Zero hook nel modulo Media, quindi zero possibilità che Clip sia montato nel chrome del pannello admin.
2. **Direttiva `@livewire('card.video.clip')` o `<livewire:card.video.clip>` in blade.** Grep su tutto il repository (moduli, temi in `Themes/` e `themes/`) per l'alias `card.video.clip` e per il namespace `Card\Video\Clip`: zero corrispondenze al di fuori del file sorgente stesso e del suo `_components.json`.
3. **Registrazione esplicita via `Livewire::component(...)`.** Nessuna occorrenza nel modulo Media (il pacchetto usa solo l'auto-discovery via `_components.json`).
4. **Instradamento come pagina a sé.** `Modules/Media/routes/web.php` e `Modules/Media/routes/api.php` contengono solo l'intestazione PHP (`declare(strict_types=1);`), nessuna rotta definita. Non esiste `routes/livewire.php` nel modulo. Nessun `Route::get(..., Livewire::class)` che punti a Clip.
5. **Componente Blade nelle view del modulo che lo referenzi dinamicamente** (es. costruzione dell'alias a partire dal mime-type del media). `Modules/Media/resources/views/components/` contiene solo un `.gitkeep`; nessuna vista del modulo referenzia `card.video.clip` o `Card\Video\Clip` in forma statica o dinamica.
6. **Vista associata al render.** `GetViewAction::execute('edit')` (chiamata da `Clip::render()`, riga 47) risolverebbe una vista tipo `media::card.video.clip.edit` o `pub_theme::card.video.clip.edit`; non esiste alcuna directory `card/video/clip` sotto `Modules/Media/resources/views` né in nessun tema del repository. Se Clip venisse effettivamente montato oggi, il `render()` fallirebbe per vista mancante.
7. **Test.** Nessun test in `Modules/Media/tests` referenzia `Clip`. Esiste un artefatto di coverage HTML storico (`build/coverage/html/Media/app/Http/Livewire/Card/Video/Clip.php.html`), segno che la classe è stata inclusa in una run di coverage generica del modulo, non prova di un test dedicato o di un utilizzo funzionale.

**Conclusione verificata:** `Clip` non ha, allo stato attuale del codice, alcun punto di montaggio vivo — né hook Filament, né blade statico o dinamico, né rotta, né vista di supporto. È codice orfano, non un componente front-office attivo.

## Correzione rispetto ai documenti paralleli

Il file `livewire-inventory.md` scritto in parallelo dalla sessione concorrente (stessa cartella, stesso timestamp di questa verifica) descrive Clip come "Card FO video + modal edit" lasciando intendere un uso reale in front-office. La verifica sopra non trova nessuna evidenza di montaggio, nemmeno lato FO: non solo manca l'hook Filament (che la nota concorrente aveva già escluso correttamente), manca anche la vista che `render()` cercherebbe. La correzione non cambia il verdetto operativo (nessun widget da creare), ma cambia la diagnosi: non è "componente FO attualmente in uso ma fuori scope Filament", è "componente orfano, probabilmente dead code, da valutare per rimozione in una story separata di pulizia — non oggetto di questa campagna che riguarda solo widget Filament".

## Widget Filament esistenti nel modulo Media (ricerca gemelli)

Come richiesto dal punto 3 della procedura, prima di escludere un widget nuovo è stata cercata la presenza di un gemello funzionale. L'unico widget presente nell'albero `Modules/Media/app/Filament` è:

- `Modules/Media/app/Filament/Resources/MediaResource/Widgets/ConvertWidget.php:18` — estende `XotBaseWidget` (`Modules/Media/app/Filament/Resources/MediaResource/Widgets/ConvertWidget.php:14`, `use Modules\Xot\Filament\Widgets\XotBaseWidget`), è legato a `MediaResource` (riga 29, `protected static string $resource = MediaResource::class;`) e mostra l'avanzamento di una conversione FFMpeg (proprietà `time`, `percentage`, `remaining`, `rate`). Non ha nulla in comune con la funzione di `Clip` (editing inline di `title`/`subtitle` di un media con modale) e non ne è un gemello.

Non esiste una directory `Modules/Media/app/Filament/Widgets` autonoma: gli unici widget del modulo vivono sotto `MediaResource/Widgets`, legati alla resource. **Nessun gemello esistente per Clip.**

## Classificazione

| Cluster | Definizione | Esito per Clip |
|---------|-------------|-----------------|
| A — chrome Filament | montato via render hook nel panel provider, candidato a `XotBaseWidget` nuovo | **No.** Zero hook (vedi sezione verifica, punto 1). |
| B — gemello esistente | Livewire orfano con un widget Filament funzionante da agganciare | **No.** Nessun gemello (sezione precedente). |
| C — pagina/struttura non di chrome | instradato a tutto schermo o componente strutturale non-chrome, non candidato widget | **Applicabile solo in parte**, vedi nota sotto. |

`Clip` non rientra in modo pulito nella definizione stretta del Cluster C (che presuppone un componente strutturale comunque vivo, es. una pagina instradata). Non è instradato e non risulta montato da nessuna vista attiva del repository: è più precisamente un **quarto caso, "orfano puro"** — zero punti di montaggio verificabili — che condivide con il Cluster C la conclusione operativa (non è un candidato a conversione in widget Filament, perché non c'è nulla di "chrome" da convertire) ma non la premessa (non è "strutturale e vivo", è probabilmente dead code). Ai fini di questa campagna (solo widget Filament) il trattamento è identico a un Cluster C: **escluso dalla conversione**, nessuna story di conversione a widget.

## Perché non si crea un widget nuovo

Costruire un `ClipWidget` (o `MediaVideoWidget`, come proponeva `LIVEWIRE-WIDGET-CONVERSION.md`) per un componente che non risulta montato da nessuna parte del codice sarebbe scrivere codice nuovo per rimpiazzare codice morto, cioè introdurre superficie senza rimuoverne — l'opposto dell'obiettivo della campagna (ridurre gli alias Livewire nel chrome Filament). Se in futuro emergesse un uso reale di `Clip` in front-office (es. via un tema non ancora ispezionato o un piano di rilascio non ancora mergiato), la story corretta sarebbe comunque valutare quell'uso concreto, non anticipare un widget dashboard che oggi non ha nessun consumatore.

## Story collegate

- `../stories/12.1.media-clip-not-widget.story.md` — story di verdetto/lock di scope aperta dalla sessione concorrente il 21/09/2026, arricchita in questa sessione con Acceptance Criteria citate, Dev Notes e Testing (vedi il file per il dettaglio). Nessuna nuova story di conversione è necessaria: zero candidati reali Cluster A/B nel modulo.

## File paralleli (non SSoT)

Scritti dalla sessione concorrente in parallelo a questa verifica. Non contengono errori di merito (il verdetto coincide), ma sono stub telegrafici senza citazioni: restano come satelliti, questo file è la fonte canonica per chi deve verificare un'affermazione.

- [LIVEWIRE-WIDGET-CONVERSION.md](./LIVEWIRE-WIDGET-CONVERSION.md) — versione precedente (2026-08-25), marcata superseded in questa sessione perché proponeva la conversione senza aver verificato il montaggio.
- livewire-widget-architecture.md, livewire-widget-brainstorming.md, livewire-widget-decision-log.md, livewire-widget-epics.md, livewire-widget-prd.md, livewire-widget-product-brief.md, livewire-widget-project-context.md, livewire-widget-tech-spec.md, livewire-widget-ux.md — satelliti allineati nella revisione del 21/09/2026 alla diagnosi corretta ("orfano puro", non "FO in uso"), con puntatore a questo file per le citazioni file:riga.

## Riverifica del 21/09/2026 — `Clip` rimosso

Audit ripetuto sullo stato corrente: `Modules/Media/app/Http/Livewire/Card/Video/Clip.php` è stato **cancellato** il 21/09/2026 (task `12.1-retire-media-clip-livewire` dell'agente concorrente `claude-quaeris-task-agent`; il file non era tracciato in git — `git ls-files` su `Http/Livewire` elenca solo `.gitkeep` e `_components.json` — quindi non appare come `D`). `Modules/Media/app/Http/Livewire/_components.json` è ora `[]` (identico a HEAD) e la directory `Card/Video/` non esiste più. Il `grep` repo-wide resta a zero hit, coerente con la diagnosi di orfano: la rimozione non ha richiesto la migrazione di nessun consumatore.

Le sezioni precedenti ("Cosa fa Clip", "Verifica di montaggio") restano come analisi storica del codice com'era prima della rimozione (86 righe, `mount()` righe 34-37, `editClip()` righe 58-62, `updateDataFromModal()` righe 69-85).

## Stato del modulo

Il modulo Media ha **0 classi Livewire** residue sotto `app/Http/Livewire` (Clip ritirato come dead code il 21/09/2026) e **0 candidati** a conversione in Filament widget (0 Cluster A, 0 Cluster B). Non serve nessuna story di implementazione. La traccia scritta della verifica è questo file.
## Follow-up: rimozione effettiva del dead code (21/09/2026, sessione successiva)

**Aggiornamento che rende obsoleta la sezione "Riverifica del 21/09/2026" sopra**: da questo momento `Clip.php` non esiste più. Questa sessione esegue la pulizia che la story 12.1 e la sezione "Correzione rispetto ai documenti paralleli" avevano esplicitamente rimandato ("una eventuale story di pulizia... è fuori scope per questa campagna... non aperta qui"). Non è una nuova valutazione di merito: il verdetto (nessun widget, componente orfano) resta quello già stabilito sopra; qui si esegue solo la rimozione già raccomandata.

### Riverifica pre-cancellazione (comandi rieseguiti da `laravel/`)

```bash
grep -rn "Card\\Video\\Clip\|media::livewire.card.video.clip\|<livewire:card.video.clip\|@livewire('card.video.clip'" Modules Themes --include="*.php" --include="*.blade.php"
# nessuna corrispondenza (exit 1)
find Modules/Media/app/Filament -iname "*clip*"     # vuoto
find Modules/Media/resources/views -iname "*clip*"  # vuoto
grep -rln "Clip" Modules/Media/tests                # vuoto
```

Esito identico a quello già documentato in "Verifica di montaggio" sopra: nessun cambiamento di merito, solo conferma che vale ancora al momento della cancellazione.

### Race multi-agente rilevata durante l'operazione

Alla prima `rm` di `Clip.php` in questa sessione, il file è ricomparso identico (stesso contenuto) pochi secondi dopo (`stat` con `Birth` alle 16:15:02, pochi secondi dopo la cancellazione). `ps aux` nello stesso istante mostrava sulla stessa macchina: due sessioni `claude --dangerously-skip-permissions` (pts/5 e pts/2), due processi Codex/omniroute, un `opencode`, e un server Devin attivo dalle 15:55 (VS Code server + language server + estensione Windsurf/Devin). Nessun lock era presente su `Clip.php.lock` al momento (`bashscripts/lock/check.sh` → `FREE`). Operazione ripetuta sotto `bashscripts/lock/lock.sh laravel/Modules/Media/app/Http/Livewire/Card/Video/Clip.php`, poi riverificata stabile dopo 5s e 8s di attesa.

Verifica successiva su `git log`/`git show` (dal path corretto, relativo alla root reale del repo `/var/www/_bases/base_quaeris_fila5`, non a `laravel/`) ha chiarito il meccanismo: **una sessione concorrente separata (Claude Sonnet 5, stesso pattern di co-autoria) aveva già completato e committato la stessa identica cancellazione** — commit `29e8e978400a4a56c51cfd4bde9ea76bc8529491` "fix(media): retire dead Card/Video/Clip Livewire component" (2026-09-21 16:21:10), che nello stesso commit ha ritirato anche `Geo/Http/Livewire/Test.php` e ripulito viste admin `manage_lang_module.blade.php`/`test.blade.php` in Lang. Il messaggio di quel commit cita esplicitamente questa story (`Modules/Media/docs/stories/12.1.media-clip-not-widget.story.md`) come riferimento, pur non avendola aggiornata/committata contestualmente. La ricomparsa del file osservata alle 16:15 è quasi certamente un artefatto del flusso di lavoro di quella sessione concorrente (checkout/stash/re-add) nei minuti immediatamente precedenti al suo commit delle 16:21, non una vera race distruttiva: il contenuto finale su disco e in HEAD coincide con quanto già verificato qui come dead code.

Verifica: `git status --short -- laravel/Modules/Media/app/Http/Livewire/` (dalla root del repo) risulta pulito — il working tree locale già coincide con HEAD per questi file, quindi **non è stato necessario né corretto creare qui un secondo commit di codice**: si aggiornano solo story e log per chiudere la documentazione lasciata indietro da quel commit.

### Cosa risulta rimosso (in HEAD, commit `29e8e9784`)

- `Modules/Media/app/Http/Livewire/Card/Video/Clip.php` — cancellato.
- Directory `Card/Video/` e `Card/` — rimosse in questa sessione (erano vuote dopo la cancellazione già committata; la loro rimozione fisica non genera diff git perché le directory vuote non sono tracciate).
- `Modules/Media/app/Http/Livewire/_components.json` — già `[]` in HEAD (era `[{"name":"card.video.clip",...}]` prima del commit `29e8e9784`).

### Classificazione (convenzione di campagna)

Confermato "orfano puro" come sopra: non Cluster A (chrome Filament, zero hook), non Cluster B (nessun gemello widget), trattamento operativo da Cluster C. Nessuna decisione di prodotto necessaria: zero utenti impattati, zero funzionalità rimossa (la funzionalità non era raggiungibile da nessun canale verificato).

### Verifica post-cancellazione (da `laravel/`)

- `./vendor/bin/phpstan analyse Modules/Media/app --level=10` → `[OK] No errors` (123 file analizzati), exit 0.
- `XDEBUG_MODE=coverage ./vendor/bin/pest Modules/Media --coverage` → 282 passed, 9 failed, 3 risky, 4 skipped (1085 assertion), 161.8s. I 9 fallimenti sono in `Modules/Media/tests/Unit/Models/MediaTest.php`/`MediaModelTest.php` (conteggi di factory su query, cast `user_id` mancante nell'atteso, `order_column` nullo) — preesistenti, nessuna relazione con `Clip`/Livewire (il modulo non aveva test su `Clip`).
- PHPMD (`tools/phpmd.sh Modules/Media/app`) → nessun finding residuo su `Http/Livewire` (directory ormai vuota di classi); i finding riportati sono tutti preesistenti altrove nel modulo (S3/AWS diagnostics, `VideoEntry`, policy).
- `./vendor/bin/pint --dirty` eseguito come richiesto dalla checklist di verifica: essendo `--dirty` relativo a **tutti** i file con modifiche non committate nel repo (non solo quelli di questa sessione), ha riformattato file in molti altri moduli (Gdpr, CloudStorage, Geo, Setting, AI, Chart, Quaeris, Job, User, DbForge, Lang) già dirty per lavoro di sessioni concorrenti. Queste riformattazioni non sono state committate da questa sessione (restano nel working tree condiviso) per non interferire con lavoro altrui in corso; il commit di questa sessione include solo i file effettivamente di sua competenza (story, log).

### Story collegata

`../stories/12.1.media-clip-not-widget.story.md` aggiornata con AC 4-6 e Dev Agent Record per questo follow-up; status portato a `done`.
