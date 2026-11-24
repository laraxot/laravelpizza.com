---
<<<<<<< HEAD
title: "Architecture Decision Records"
type: index
tags: [adr, decisioni]
created: 2026-11-18
updated: 2026-11-24
---

# Architecture Decision Records

Il **perche'** delle scelte di questo pacchetto: una decisione per file, con le alternative scartate.
Il nome del file e' l'argomento, senza date ne' numeri (la data sta nella frontmatter).

## Formato

=======
title: "ADR — Xot"
type: index
tags: [adr, decisioni, harness]
created: 2026-11-18
updated: 2026-11-24
qmd: "xot adr indice decisioni formato standard actions services harness pest arch testcase"
---

# ADR di Xot

Il **perché** delle forme di codice che Xot impone a tutti i moduli: Actions invece di Services, basi `XotBase*`,
regole di architettura eseguibili, binding del TestCase, harness degli agenti. Leggili **prima** di "semplificare"
qualcosa che sembra strano o di scegliere tra due forme di codice.

Questo README è l'**unico indice** della cartella e lo **standard ADR** richiamato dagli altri moduli e temi
(`Xot/docs/adr/README.md`). Non esiste un `INDEX.md` né un template a parte: il formato è qui sotto. Perché esiste
l'harness: [guida](../concepts/agent-harness-guide.md); regola completa su ADR e contratti:
[action-behavioral-contract](../rules/action-behavioral-contract.md).

## Quando scrivere un ADR

Solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Non per un dettaglio di
implementazione locale né per un'ipotesi non verificata. Un ADR non è un diario né una spiegazione retroattiva
inventata: rende leggibili contesto, alternative, decisione, conseguenze e una verifica ripetibile.

Le decisioni vanno confrontate con codice e test correnti. Una modifica sostanziale crea un nuovo ADR e segna il
precedente `superseded` (con `superseded_by:`) o `deprecated`; la decisione vecchia non si riscrive in silenzio.
Il lavoro di scrittura si traccia nella story BMAD del modulo owner (`docs/stories/`).

## Formato

- **Nome file**: argomento in kebab-case, minuscolo. Mai numeri iniziali (`0001-x.md`, `00010-x.md`), mai date
  (`2026-11-24`), mai suffissi `-1`/`-2`. La data sta nella frontmatter. Una decisione, un file: niente copie
  "alias" della stessa scelta.
- **Frontmatter** con almeno `title`, `type: decision` (riga esatta), `status` (minuscolo: `proposed`,
  `accepted`, `superseded`, `deprecated`), `created`, `updated`.
- **Cinque sezioni obbligatorie**, come intestazioni `##` esatte: `## Contesto`, `## Decisione`,
  `## Alternative scartate` (vale anche `## Alternative considerate` se l'elenco comprende l'opzione scelta),
  `## Conseguenze`, `## Verifica`.
- **ADR sostanziale**: ogni pacchetto ne ha almeno uno che aggiunge `## Driver della decisione` (o `## Driver`) e
  `## Conferma` (criteri di accettazione in revisione) alle cinque sezioni.
- **`## Verifica`** nomina il comando o il test che fallisce se il codice viola la decisione, con path reali: i file
  `Modules/...php` e `Themes/...php` citati lì devono esistere (lo controlla `PackagesHaveContractsAndAdrTest`). Se
  non esiste ancora un controllo automatico, lo dice ("solo revisione: …") invece di inventarlo.
- **Indice**: ogni ADR compare in questo README con un link markdown (titolo e nome del file tra parentesi tonde);
  nessun marker di conflitto.

>>>>>>> laraxot/dev
```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: proposed | accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
---

# ADR: <decisione>

## Contesto
<<<<<<< HEAD
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.
```

## Decisioni

- [no-shared-empty-route-file](no-shared-empty-route-file.md) — vietato `require` di `Modules/Xot/routes/empty.php`; stub locale minimo se non ci sono rotte
- [architecture-tests-pest-arch](architecture-tests-pest-arch.md) — regole di architettura con Pest arch(): ambito esplicito, debito dichiarato, cinque trappole chiuse
- [architecture-rules-phparkitect](architecture-rules-phparkitect.md) — PHPArkitect con baseline (superseded dal precedente)
- [0001-actions-over-services](0001-actions-over-services.md) — Actions al posto di Services per operazioni nuove
- [pest-testcase-binding-per-file](pest-testcase-binding-per-file.md) — binding TestCase per file
- [agent-harness](agent-harness.md) — harness agenti

## Decisioni precedenti (formato libero, non ancora ADR)
=======
Fatti, misure, vincoli, incidenti; chiude con la domanda a cui la decisione risponde.

## Driver della decisione
Vincoli e forze che pesano sulla scelta.

## Alternative scartate
Ogni alternativa seria e il motivo per cui non è stata scelta.

## Decisione
Cosa si fa in concreto e dove sta nel codice (path reali).

## Conseguenze
Buono, cattivo, debito che resta, cosa misurare.

## Conferma
Criteri con cui una revisione accetta o respinge il lavoro.

## Verifica
Test, audit o comando ripetibile che dimostra il rispetto della decisione.
```

## Decisioni in vigore

Codice e architettura

- [actions-over-services](actions-over-services.md) — la logica applicativa è una Spatie QueueableAction; i Services di AI, Geo, Job sono debito
- [queueable-actions-over-jobs](queueable-actions-over-jobs.md) — QueueableAction come unico ingresso di business, niente Job che duplicano un'Action
- [xot-base-extension-points](xot-base-extension-points.md) — i moduli estendono i punti base Xot invece delle classi del framework
- [filament-widgets-over-standalone-livewire](filament-widgets-over-standalone-livewire.md) — niente componenti Livewire standalone: Filament Widget, Resource, Page
- [architecture-tests-pest-arch](architecture-tests-pest-arch.md) — regole di architettura con Pest `arch()`: ambito esplicito, debito dichiarato, cinque trappole chiuse
- [laravel-bootstrap-provider-registry](laravel-bootstrap-provider-registry.md) — bootstrap Laravel 13 minimale e discovery dei moduli (proposed: il codice non lo applica ancora)
- [route-entrypoints-canonical-empty](route-entrypoints-canonical-empty.md) — entrypoint no-op condiviso per i moduli senza route
- [no-ticket-logic-in-page-slug-middleware](no-ticket-logic-in-page-slug-middleware.md) — niente logica di dominio ticket in `PageSlugMiddleware` del Cms
- [auth-register-livewire-tenant-url-defaults](auth-register-livewire-tenant-url-defaults.md) — la registrazione pubblica non eredita il default tenant del pannello
- [translation-key-protocol](translation-key-protocol.md) — chiavi Laravel con namespace, file, collezione, chiave e tipo esplicito

Test, dati e migrazioni

- [pest-over-phpunit](pest-over-phpunit.md) — Pest come formato e runner dei test applicativi
- [pest-testcase-binding-per-file](pest-testcase-binding-per-file.md) — il TestCase del modulo si lega in ogni file di test, mai con `uses()->in()`
- [one-model-one-migration](one-model-one-migration.md) — un modello persistente, una migrazione owner di creazione
- [dati-sacri-migrazioni-e-test](dati-sacri-migrazioni-e-test.md) — mai migrazioni distruttive né `--force`, mai il reset del database nei test, test solo con `.env.testing`

Documentazione, contratti e harness

- [owner-local-documentation](owner-local-documentation.md) — decisioni e contratti nella documentazione del modulo o tema owner
- [contract-docblock-reference](contract-docblock-reference.md) — `@contract` nel docblock delle Action con effetti collaterali
- [behavioral-contract-governance](behavioral-contract-governance.md) — contratti owner-local con invarianti a ID e group Pest omonimo
- [agent-harness](agent-harness.md) — harness minimo: ADR e contratti in ogni pacchetto, test-sensore source-level, guard PreToolUse, lezioni
- [bashscripts-e-claude-fuori-dal-versionamento](bashscripts-e-claude-fuori-dal-versionamento.md) — `bashscripts` e `.claude` non si versionano nel root

## Superate

- [architecture-rules-phparkitect](architecture-rules-phparkitect.md) — PHPArkitect con baseline (superseded da `architecture-tests-pest-arch`)

## Decisioni precedenti (formato libero, da portare ad ADR quando si toccano)
>>>>>>> laraxot/dev

- [module-admin-role-policy-bypass](../wiki/decisions/module-admin-role-policy-bypass.md)
- [security-middleware-csrf-order](../wiki/decisions/security-middleware-csrf-order.md)
