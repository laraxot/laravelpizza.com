---
title: "Ingressi della cartella docs di Notify rivisti sul codice"
type: story
status: done
created: 2026-10-14
updated: 2026-10-14
module: Notify
tags: [docs, organizzazione, indice, bmad, verifica-codice, famiglie-radice]
qmd: "notify docs ingressi README 00-INDEX famiglie radice 3465 file stale SMS consolidamento NotificationTrackingController test vuoto Mail alwaysTo DOC-010 DOC-002"
related:
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
  - ../../../../../bmad-output/docs-architecture/module-theme-docs-contract.md
---

# Ingressi della cartella docs di Notify rivisti sul codice

Fase BMAD: documentazione e qualita' (DOC-010 e DOC-002 del piano `bmad-output/stories/docs-organization/`).

## Richiesta

Ordine del 2026-10-14: studiare il modulo vero, capire quali dei 3.465 file `.md` sono documentazione viva e quali cronaca
di sessioni, correggere gli ingressi solo con fatti verificati, dichiarare directory canoniche, evidence e legacy e le
famiglie della radice con conteggi, senza spostare, rinominare o cancellare nulla.

## Analisi (cosa fa davvero il modulo)

`Modules/Notify` (`laraxot/module_notify_fila5`) invia notifiche su piu' canali e gestisce i template. Verificato il
2026-10-14 con `ls`/`grep` su `laravel/Modules/Notify`:

- Canali nel codice: email (Spatie mail templates, SMTP, Mailtrap, Duocircle), SMS (Twilio, Nexmo, Plivo, Netfun, SmsFactor,
  Agiletelecom, Gammu), WhatsApp (360dialog, Facebook, Twilio, Vonage), Telegram (Botman, Nutgram, Official), push FCM
  (10 Action); 49 file PHP in `app/Actions`, 14 modelli, 6 Resource Filament, 15 pagine di prova nel cluster `Test`.
- `routes/web.php` e `routes/api.php` non registrano nulla.
- `NotificationTrackingController` esiste, senza rotta; il test `NoOrphanHttpControllersTest` che dovrebbe vietarlo costruisce
  il path con `dirname(__DIR__, 4)`, che da `tests/Unit/Architecture` e' `Modules/` e non `Modules/Notify`: asserzione
  vuota (ragionamento sul path, test non eseguito).
- `SendSmsAction` delega a un namespace `SmsEngines` inesistente e lancia sempre `RuntimeException` (ammesso nel docblock).
- `NotifyServiceProvider::boot()` esegue `Mail::alwaysTo()` se la config tenant `mail.fallback_to` e' una stringa.
- La decisione di consolidamento SMS ("run #4", `.php.bak`) non corrisponde al codice: nessun `.bak` tracciato in `app/`.
- Il log della wiki dava come rimosso `app/Contracts/SmsActionContract.php`: oggi il file esiste in tre posizioni.

Famiglie della radice (1.551 `.md`, per nome file): cronaca di sessione e completamento 263; email e template 119;
architettura e standard 113; Filament/UI/Tailwind 107; analisi e audit 102; PHPStan 82; Git/merge/composer 76;
refactoring 71; SMS 71; database/DTO 58; roadmap e prodotto 56; piani e guide 48; agenti AI 42; traduzioni 40;
notifiche e tracking 39; Telegram/WhatsApp/push 27; indici 17; verifica 11; non classificati 209. 413 gruppi di nomi
differiscono solo per maiuscole, `_`/`-` o suffisso `-N` (1.106 file); 21 nomi terminano con `-.md`; 34 file hanno chiavi
duplicate nel frontmatter; 848 contengono emoji.

## Modifiche

- `README.md`: frontmatter (`status: active`, `qmd`, `updated`, `related`), ownership e dipendenze, mappa del codice,
  limiti verificati; elenco modelli da 9 a 14; il secondo blocco frontmatter a meta' file (merge di `readme.md`) reso
  commento; riferimenti a `Ptv` e a file inesistenti ridotti a testo; link a `GetPdfContentByRecordAction` riportato al
  codice in Xot; cifra "95% copertura" marcata senza fonte.
- `00-INDEX.md`: `status: active`; tolta la versione "2.1.0" senza fonte; sezione di orientamento con tabella delle directory
  (canoniche, evidence, legacy) e famiglie della radice; descrizioni corrette (roadmap.md, email-templates.md,
  send-notification-bulk-action.md, monitoring.md, ponytail audit, cleanup plan, security analysis); link a
  `composer-packages-reference.md` e `phpstan-cluster.md` riportati ai file esistenti; pseudo-frontmatter duplicato
  reso commento; sezione "Duplicati e ingressi non canonici".
- `docs-organizer stale --fix` (status `stale` e nota in testa, contenuto intatto): `INDEX.md`, `index.md`, `roadmap.md`,
  `send-notification-bulk-action.md`, `monitoring.md`, `ponytail-audit-over-engineering.md`, `wiki/00-INDEX.md`,
  `wiki/00-index.md`, `wiki/INDEX.md`, `wiki/index.md`, `wiki/decisions/sms-actions-consolidation-consolidamento-contracts-ponytail-audit.md`.
- `wiki/README.md` e `wiki/readme.md` (copie identiche): tolte le chiavi duplicate `title` e `qmd` e il titolo "FixCity LLM Wiki".
- `wiki/log.md`: voce 2026-10-14; link a file inesistenti ridotti a testo.
- Nessun file cancellato, spostato o rinominato; nessun `dups --fix`.

## Verifica

Misura con `python3 bashscripts/tools/docs/docs-organizer.py --busy-minutes 0 links laravel/Modules/Notify/docs --by-name`
(dry-run, eventi `unresolved`), sui file toccati e sugli ingressi:

| File | prima | dopo |
|---|---|---|
| `README.md` | 5 | 0 (1 verso questa story, ora esistente) |
| `00-INDEX.md` | 3 | 0 (1 verso questa story, ora esistente) |
| `wiki/log.md` | 3 | 0 (1 verso questa story, ora esistente) |
| `readme.md` (copia di servizio di `README.md`, stesse correzioni sui link) | 4 | 0 |
| `INDEX.md`, `index.md`, `roadmap.md`, `send-notification-bulk-action.md`, `ponytail-audit-over-engineering.md`, `wiki/00-INDEX.md`, `wiki/00-index.md`, `wiki/INDEX.md`, `wiki/index.md` | 2, 2, 7, 2, 2, 10, 10, 9, 19 (63) | invariati: marcati `stale`, link non riscritti |

Modulo intero: 7.698 eventi `unresolved` prima, 7.683 dopo. Gli ingressi canonici (`README.md`, `readme.md`, `00-INDEX.md`, `wiki/log.md`)
passano da 15 a 0 (misura finale con questa story presente). I link dell'indice sono stati controllati con uno script
(esistenza su disco di ogni `](./...)`): nessuno mancante tranne quelli dichiarati nel testo. PHPStan e Pest NON rieseguiti.

## Decisioni

- `00-INDEX.md` resta il solo indice; nessun indice con nome alternativo.
- Le pagine false vengono marcate `stale` con la prova, non riscritte e non cancellate.
- Le 413 famiglie di varianti di grafia e le 21 date-tagliate richiedono la migration map di DOC-004/006: non toccate.
- Difetto di `docs-organizer.py`: `links`, `frontmatter` e `dups` scartano in silenzio i file con mtime < 10 minuti
  (riga 549); subito dopo una passata `--fix` la misura vede una frazione del perimetro. `--annotate` non si limita a un file.

## Aperto

- Correggere o eliminare `NotificationTrackingController` e il test con il path errato (`dirname(__DIR__, 3)`).
- Decidere se `SendSmsAction` (sempre in errore) vada ripristinata o ritirata; allineare `SmsActionFactory` e docs.
- Rimuovere i file di lavoro in `app/` (`*.php.up` x6, `*.test`, `*.wip`) e le migrazioni `create_mail_templates_table` duplicate (9).
- Riscrivere o annotare i 7.683 link non risolti (per lo piu' in `wiki/` 912 file, `ai-agents/` 288, `project_docs/` 130).
- 258 file della radice senza `status` e 34 con chiavi duplicate nel frontmatter: tool `frontmatter` + intervento manuale.
