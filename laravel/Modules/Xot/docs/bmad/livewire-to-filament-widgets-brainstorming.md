---
title: "Brainstorming: Livewire verso Filament Widgets"
type: brainstorming
module: Xot
status: complete
created: 2026-10-20
updated: 2026-10-20
techniques: [5-whys, scamper, reverse-brainstorming, six-thinking-hats, starbursting]
related:
  - ./livewire-to-filament-widgets-objective.md
  - ./livewire-to-filament-widgets-architecture.md
  - ./livewire-to-filament-widgets-inventory.md
  - ./livewire-to-filament-widgets-filament-blueprint.md
  - ./stories/livewire-to-filament-widgets-fleet.story.md
tags: [docs, xot, bmad]
qmd: "brainstorming bmad xot"
---

# Brainstorming BMAD

## 5 Whys: perché cambiare

1. Perché i custom Livewire sono difficili da governare? Perché duplicano
   stato, schema, autorizzazioni, discovery e convenzioni del panel.
2. Perché la duplicazione è costosa? Perché lo stesso intento UI viene
   implementato in punti diversi e i fix non si propagano.
3. Perché il panel deve avere un linguaggio comune? Perché Resource, Page,
   Widget e Action devono condividere auth, tenancy, traduzioni e layout.
4. Perché un Widget è il confine giusto per una dashboard? Perché espone una
   unità visiva componibile, lazy, responsive e registrabile dal panel.
5. Perché non convertire tutto? Perché uno switcher, un logout, un toast, una
   pagina pubblica o un comando non hanno semantica di widget. La migrazione
   deve seguire lo scopo, non il nome della classe.

## SCAMPER: idee utili e vincoli

- **Substitute:** sostituire solo l'orchestrazione UI con `XotBase*Widget`;
  lasciare la logica di dominio agli Actions Queueable.
- **Combine:** unire schema e widget attraverso `XotBaseSchemaWidget`, senza
  duplicare campi nelle view.
- **Adapt:** usare `XotBaseTableWidget` per liste, `ChartWidget` per trend,
  `StatsOverviewWidget` per KPI, `InfolistWidget` per dettaglio.
- **Modify:** rendere espliciti loading, empty, error, polling, column span e
  policy invece di lasciarli impliciti nel componente.
- **Put to another use:** riusare widget in panel/page/partial FO quando il
  contratto dati e l'autorizzazione sono gli stessi.
- **Eliminate:** alias legacy, registrazioni automatiche e file duplicati solo
  dopo la prova sui caller.
- **Reverse:** prima di cancellare chiedere “quale flusso si rompe se questo
  file sparisce?” e costruire una matrice caller → sostituto → test.

## Reverse brainstorming: come fallire

- convertire ogni `Livewire\Component` in widget, inclusi componenti non UI;
- cambiare il redirect o la policy mentre si cambia il rendering;
- mettere query e business rules nel widget;
- confondere `@livewire(FQCNWidget::class)` con un vecchio alias HTTP;
- considerare i docs come prova di stato senza verificare il working tree;
- cancellare test perché “il componente non esiste più” senza sostituire il
  comportamento verificato;
- lanciare PHPStan completo in parallelo da più agenti;
- modificare lo stesso caller da due lane.

## Six Thinking Hats: decisione

- **Bianco:** la baseline reale è la scansione del codice, non il conteggio
  dei documenti; esistono ancora classi e caller residui.
- **Rosso:** il rischio percepito maggiore è perdere flussi auth, lingua,
  tenancy e redirect.
- **Nero:** il widget non deve diventare un contenitore di dominio o un nuovo
  punto di bypass delle policy.
- **Giallo:** una sola famiglia `XotBase*` riduce drift, facilita test e rende
  la discovery del panel prevedibile.
- **Verde:** ogni componente può avere una destinazione diversa; la matrice
  rende possibile migrare per wave senza big bang.
- **Blu:** il gate è: inventario → decisione → sostituzione → verifica caller →
  ritiro → scan globale.

## Insight operativi

1. Il primo deliverable è una classificazione, non un rename.
2. Un widget è una superficie di presentazione; un Action è il caso d'uso.
3. La compatibilità dei caller è parte della migrazione, non un lavoro finale.
4. Il criterio “zero `app/Http/Livewire`” è valido solo dopo aver chiuso le
   eccezioni documentate e i mount reali.
5. L'ordine random è ammesso solo dentro una wave con file disgiunti; le
   dipendenze e i gate restano ordinati.

## Decisione proposta

Adottare una migrazione incrementale a wave, con `XotBase*` come standard,
Actions per il dominio e una matrice di classificazione come source of truth.

## Sintesi swarm: 2026-10-20

Il brainstorming parallelo ha confermato che la causa radice è l'assenza di
una classificazione affidabile dei caller e del confine BO/FO, non Livewire in
quanto tecnologia. I rischi prioritari sono:

| Rischio | Contromisura |
|---|---|
| rimozione di un mount FO, auth o dinamico | matrice di caller + smoke HTTP/Livewire prima del ritiro |
| widget scoperto nel panel sbagliato | provider/panel owner, namespace e `canAccessPanel` verificati |
| perdita di policy, middleware o tenant | test guest/auth/admin e due tenant, incluso cambio tenant nella stessa sessione |
| capability pericolosa esposta come UI | non convertire comandi Artisan/`.env`; allowlist, policy o ritiro |
| regressione a11y o test strutturali falsamente verdi | test di mount/render reale, tastiera/focus/ARIA e smoke browser |

Regola sintetica emersa: **convertire il boundary e lo scopo, non rinominare la
tecnologia**. Filament continua a usare Livewire internamente; ciò che viene
ritirato è il componente HTTP custom quando il panel possiede già il contratto
Widget.

## Refresh baseline: 2026-10-20 pomeriggio

Rimisurazione `find` su `Http/Livewire` + `app/Livewire`: **28** classi
applicative (non 63). I gemelli Filament esistono già per UI dark-mode, Lang
switcher, Job status/schedule e User Auth*. Quindi W0–W1 sono soprattutto
`REUSE` + chiusura caller, non creazione di widget nuovi.

Religione (perché): una sola famiglia di superfici panel (`XotBase*Widget`)
condivide discovery, policy, tenancy, traduzioni e layout. Custom Livewire
panel-side è debito: due stack per lo stesso intento.

Politica: vietare nuovi custom Livewire nel panel; FO (Folio/Volt/Blade, toast,
pagine legali, CMS page show) resta `KEEP` finché non esiste un piano FO
esplicito. Zero = zero residui **non giustificati**, non zero Livewire runtime.

Piano: vedi [inventory](./livewire-to-filament-widgets-inventory.md) e
[fleet story](./stories/livewire-to-filament-widgets-fleet.story.md)
(`ready-for-dev`).

## Update planning: 2026-10-20 (ordine utente: niente custom Livewire, solo Widget)

### 5 Whys (rinfresco sul senso)

1. **Perche'** l'utente dice "niente Livewire, solo Filament Widget"? Perche' la
   UI del **panel** deve avere un solo contratto: discovery, policy, tenancy,
   traduzioni Lang, layout colonne: gia' offerti da `XotBase*Widget`.
2. **Perche'** un custom `Livewire\Component` sotto `Http/Livewire` e' debito?
   Perche' reinventano mount/state/auth e **non** entrano nella discovery del
   panel: due stack per lo stesso intento UI.
3. **Perche'** non si "elimina Livewire"? Perche' ogni Widget Filament **e'**
   Livewire sotto il cofano. Si ritira il **custom HTTP**, non il runtime.
4. **Perche'** non tutto diventa Widget? Perche' lo scopo decide: CMS
   `Page\Show`, toast FO, switcher chrome, pagina pubblica non-panel non sono
   card di dashboard. Destinazioni: Folio/Volt/Blade o `KEEP` documentato.
5. **Perche'** `TermsOfService` HTTP e' un caso speciale? Perche' il nome
   `*Service` confonde PHPStan/ratchet Services, ma lo **scopo** e' mostrare
   testo legale da config. Il gemello `TermsOfServiceWidget` esiste gia' e
   documenta la sostituzione → verdetto **`REUSE` + ritiro HTTP**, non
   "KEEP FO" generico. Stesso pattern per `PrivacyPolicy`.

### Starbursting (domande aperte del planning)

| Domanda | Risposta di planning |
|---------|----------------------|
| **Who** possiede i testi legali? | Ownership formale ancora User; Gdpr story 12.1 parla di pagine, non di inventare widget in Gdpr |
| **What** si ritira per primo? | Caller verso gemelli gia' presenti (W0–W1 `REUSE`) |
| **When** si cancella l'HTTP? | Solo con `rg` caller a zero + test del widget verde |
| **Where** vive il nuovo codice? | `Modules/<M>/app/Filament/Widgets/...` su base Xot |
| **Why** Actions? | Widget = presentazione; mutazioni/query in QueueableAction |
| **How** si parallellizza? | Ordine random solo tra lane disgiunte nella stessa wave |

### Insight actionable (feed alla fleet)

1. Correggere inventory: `TermsOfService` / `PrivacyPolicy` → `REUSE` (gemelli User).
2. W0 amplia: UI + Lang + legal twins User (solo chiusura caller).
3. Vietare nuovi file sotto `app/Http/Livewire` per panel (ratchet docs + pest arch in wave successiva).
4. Parallel plan e fleet story devono usare la **stessa** numerazione wave.
5. Implementazione parte solo quando si apre esplicitamente una wave (questa sessione = brainstorm + planning).

## Reverse brainstorm refresh: sessione planning

Tecnica: Reverse Brainstorming (solo planning). Domanda guida: *come
farebbe fallire la fleet se volessimo rompere la migrazione?* Ogni riga
ha Impact (danno se si materializza) e Feasibility of failure (quanto è
facile che accada senza disciplina). Contromisure pensate per le wave
della [fleet story](./stories/livewire-to-filament-widgets-fleet.story.md).

Religione verificata su codice/docs (non inventata):

- panel: niente nuovi custom Livewire; solo `XotBase*Widget` + Spatie
  Actions;
- runtime Livewire interno a Filament ≠ residuo;
- FO Folio/Volt/Blade resta quando lo scopo non è widget di panel;
- `TermsOfService` / `PrivacyPolicy` hanno gemelli
  `TermsOfServiceWidget` / `PrivacyPolicyWidget` → **`REUSE`**, non
  `KEEP` FO generico (inventory riga ancora da correggere);
- baseline applicativa: **28** classi (`find` Http/Livewire + app/Livewire,
  esclusi test).

### Come può fallire la migrazione

| # | Modo di fallimento | Impact | Feasibility of failure | Contromisura |
|---|--------------------|--------|------------------------|--------------|
| 1 | Classificare `TermsOfService`/`PrivacyPolicy` come `KEEP` FO e lasciare HTTP vivo nonostante i gemelli `XotBaseWidget` | H | H | Prima di W2: correggere inventory → `REUSE`; chiudere caller; ritiro HTTP solo con `rg` a zero + smoke widget |
| 2 | Trattare Livewire runtime Filament (o mount `@livewire(FQCNWidget)`) come “residuo da azzerare” e rompere panel/theme | H | M | Gate “zero” = zero custom `Http/Livewire` **non giustificati**; mount FQCN Widget = validi; non contare vendor |
| 3 | Convertire FO puro (`Cms\Page\Show`, `UI\Toast`, Geo search) in widget panel senza contratto dati/auth | H | M | Matrice scopo→destinazione; `KEEP` FO esplicito finché non c’è piano FO; no big-bang rename |
| 4 | Creare widget nuovi dove il gemello esiste già (W0–W1) e duplicare stato/policy | M | H | Wave `REUSE`-first: inventario gemelli (~168) prima di `php artisan make`; lane = chiusura caller |
| 5 | Mettere query/mutazioni/business rules nel widget invece di QueueableAction | H | H | Checklist review: widget = presentazione; Action = caso d’uso; rifiutare PR con Eloquent “grasso” nel widget |
| 6 | Ritirare alias/tag/file mentre esistono caller (stringa, FQCN, route, CMS, test) | H | H | Matrice caller obbligatoria; ritiro solo dopo verifica; smoke mount dinamici |
| 7 | Cambiare redirect/policy/middleware/tenancy “di passaggio” durante lo swap UI | H | M | Diff UI-only; test guest/auth/admin + due tenant; non toccare Auth redirects in W1 |
| 8 | Parallelizzare lane che condividono lo stesso caller/provider (merge conflict + doppio fix) | M | H | [parallelization-plan](./livewire-widget-parallelization-plan.md): ownership disgiunta; random solo intra-wave sicura |
| 9 | Dichiarare “done” perché i docs dicono zero mentre il working tree ha ancora 28 HTTP | H | M | Gate scan `find` riproducibile; docs non battono il tree; coordinatore W4 |
| 10 | Forzare Job Broad/Crud con capability Artisan/`.env` come UI libera nel panel | H | L | Allowlist + policy; altrimenti `RETIRE` o non-esporre; non `MIGRATE` cieco |
| 11 | Cancellare test Livewire senza sostituire asserzioni sul widget/FQCN | M | H | Portare test su Widget; vietare delete-only; Pest arch ratchet anti nuovi `Http/Livewire` panel |
| 12 | Ritirare `XotBaseComponent` / RegisterLivewire prima che le foglie siano chiuse | H | M | W3 seriale solo a foglie chiuse; non toccare provider Xot in W0–W2 |

### Insight actionable (feed alle wave fleet)

1. **Correggere subito la SoT inventory:** `TermsOfService` + `PrivacyPolicy`
   → `REUSE` (gemelli User verificati su disco); includere la chiusura
   caller in W1–W2, non lasciarli in un generico “legal KEEP FO”.
2. **W0–W1 = REUSE + caller, non create:** DarkMode, Lang, Job status/schedule,
   Auth* twins: ogni lane misura “caller residui = 0”, non “widget creato”.
3. **Definire il gate “zero” in story acceptance:** formula esplicita =
   `find` custom applicativi − `KEEP` documentati − mount FQCN Widget validi
   = 0; runtime Filament escluso dal conteggio.
4. **Action boundary obbligatorio per ogni `MIGRATE`:** se la storia crea o
   sposta mutazione, deve citare l’Action Spatie; altrimenti resta bloccata
   in review (previene widget-god).
5. **W3/W4 non partono in parallelo alle foglie:** RegisterLivewire /
   `XotBaseComponent` + scan PHPStan globale solo dopo W0–W2 verdi e
   ownership file disgiunta verificata.

### Cosa NON è fallimento

- Lasciare Folio/Volt/Blade FO quando lo scopo non è card di panel.
- Vedere Livewire nelle stack Filament in debug/profiler.
- Tenere Toast chrome FO come `KEEP` finché non c’è piano chrome esplicito.
