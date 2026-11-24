---
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
title: "Architecture Decision Records"
type: index
tags: [adr, decisioni]
created: 2026-11-18
updated: 2026-11-18
---

# Architecture Decision Records

Il **perche'** delle scelte di questo pacchetto: una decisione per file, con le alternative scartate.
Il nome del file e' l'argomento, senza date ne' numeri (la data sta nella frontmatter).
=======
=======
>>>>>>> laraxot/dev
title: "ADR del modulo Notify"
type: index
tags: [adr, decisioni, notify]
created: 2026-11-18
updated: 2026-11-24
=======
>>>>>>> laraxot/dev
title: "ADR del modulo Notify"
type: index
module: Notify
status: active
<<<<<<< HEAD
tags: [adr, decisioni, notify]
created: 2026-11-18
updated: 2026-11-24
qmd: "Notify adr architecture decision records madr formato"
=======
created: 2026-11-18
updated: 2026-11-24
qmd: "Notify adr architecture decision records madr formato"
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
---

# ADR del modulo Notify

<<<<<<< HEAD
Il **perche'** delle scelte di Notify: una decisione per file, con le alternative scartate. Il nome del file e' l'argomento in
kebab-case, senza date ne' numeri (la data sta nella frontmatter). Formato e regole: `Modules/Xot/docs/rules/action-behavioral-contract.md`
e [ADR di Xot](../../../Xot/docs/adr/README.md). Elenco con stato: [INDEX.md](INDEX.md).
=======
<<<<<<< HEAD
Il **perche'** delle scelte di Notify: una decisione per file, con le alternative scartate. Il nome del file e' l'argomento, senza
date ne' numeri (la data sta nella frontmatter). Formato e regole: `Modules/Xot/docs/rules/action-behavioral-contract.md` e
[ADR di Xot](../../../Xot/docs/adr/README.md).
>>>>>>> laraxot/dev

Quando leggerli: prima di aggiungere un webhook o un fornitore (email, SMS), di far scrivere al modulo dati che appartengono al
progetto, di leggere configurazione con `env()` o di far inviare notifiche fuori dalle Action di consegna.

## Metodo

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Un ADR rende leggibili
<<<<<<< HEAD
contesto, alternative, decisione, conseguenze e una verifica ripetibile; non e' un diario ne' una spiegazione retroattiva inventata:
se la decisione non e' dimostrabile dal codice o da una story/doc del repo, non si scrive.

Le decisioni si verificano contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e segna il precedente
`superseded` o `deprecated`, collegandolo al nuovo (`superseded by <file>`).

## Formato

Frontmatter: `title`, `type: decision`, `status` (`proposed` | `accepted` | `superseded` | `deprecated`), `created`, `updated`,
`module`, `qmd`, `issues`. Template: [0000-template.md](0000-template.md); guard:
`Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`.

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: proposed | accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
=======
contesto, alternative, decisione, conseguenze e una verifica ripetibile; non e' un diario ne' una spiegazione retroattiva inventata.

Le decisioni si verificano contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e segna il precedente
`superseded` o `deprecated`, collegandolo al nuovo.
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev

## Formato

```markdown
---
<<<<<<< HEAD
<<<<<<< HEAD
title: "ADR — <decisione in una riga>"
type: decision
status: accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
=======
=======
>>>>>>> laraxot/dev
title: "ADR - <decisione>"
type: decision
status: proposed | accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
```

## Decisioni


## Decisioni precedenti (formato libero, non ancora ADR)

- [notification-logs-migration-consolidation](../wiki/decisions/notification-logs-migration-consolidation.md)
- [sms-actions-consolidation-](../wiki/decisions/sms-actions-consolidation-.md)
- [sms-actions-consolidation](../wiki/decisions/sms-actions-consolidation.md)
=======
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev

## Verifica
Comandi o test che esistono e falliscono se la decisione viene violata; solo cio' che si puo' ripetere.
```

Un ADR "sostanziale" aggiunge `## Driver della decisione` e `## Conferma` (come i due ADR sulla configurazione e sulla consegna).

## Decisioni

- [I webhook in ingresso si autenticano con un token nel percorso](webhooks-authenticate-with-a-token-in-the-path.md) — `hash_equals`, 401 se il token non e' configurato, 200 a Mailjet anche per eventi sconosciuti.
- [Gli esiti delle email sono un evento Laravel](mail-delivery-outcomes-are-events.md) — `MailDeliveryEventReceived`, il progetto decide cosa farne.
- [Configurazione Notify centralizzata](notify-config-is-centralized.md) — niente `env()` sparsi: la configurazione passa dall'adapter del modulo.
<<<<<<< HEAD
- [Notify centralizza template e consegna delle notifiche](notify-owns-delivery-contract.md) — le Action possiedono l'orchestrazione dei canali; le route espongono solo endpoint tecnici (stato `proposed`).

## Decisioni precedenti (formato libero, non ancora ADR)

- [Consolidamento migrazioni notification_logs](../wiki/decisions/notification-logs-migration-consolidation.md) — lo schema del modello `NotificationLog` vince sulle due migrazioni duplicate
- [Consolidamento delle Action SMS](../wiki/decisions/sms-actions-consolidation.md) — nota deprecata.
- [Consolidamento delle Action SMS (copia con trattino finale)](../wiki/decisions/sms-actions-consolidation-.md) — nota deprecata.
=======
- [Notify centralizza template e consegna delle notifiche](notify-owns-delivery-contract.md) — le Action possiedono l'orchestrazione dei canali; le route espongono solo endpoint tecnici.

## Decisioni precedenti (formato libero, non ancora ADR)

- [Consolidamento migrazioni notification_logs](../wiki/decisions/notification-logs-migration-consolidation.md) — lo schema del modello `NotificationLog` vince sulle due migrazioni duplicate.
- [Consolidamento delle Action SMS](../wiki/decisions/sms-actions-consolidation.md) — nota deprecata.
- [Consolidamento delle Action SMS (copia con trattino finale)](../wiki/decisions/sms-actions-consolidation-.md) — nota deprecata.
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
=======
Un ADR registra una scelta difficile da invertire, sorprendente o frutto di un trade-off reale, e il suo perche'.
Non e' un diario ne' una spiegazione retroattiva: se la decisione non e' dimostrabile dal codice o da una story/doc del repo, non si scrive.
Il nome del file e' l'argomento in kebab-case, senza date (la data sta nella frontmatter).

## Formato (MADR breve)

Frontmatter: `title`, `type: decision`, `status` (`proposed` | `accepted` | `superseded` | `deprecated`), `created`, `updated`, `decision-makers`, `module`, `qmd`.

Sezioni obbligatorie, in quest'ordine:

```markdown
## Contesto
## Driver della decisione
## Alternative scartate
## Decisione
## Conseguenze
## Conferma
```

Template condiviso: `laravel/Modules/Xot/docs/adr/0000-template.md`. Guard: `Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`.
Chi cambia una decisione scrive un nuovo ADR e segna il precedente `superseded by <file>`.

## ADR presenti

- [notify-config-is-centralized](notify-config-is-centralized.md)
- [notify-owns-delivery-contract](notify-owns-delivery-contract.md) (stato `proposed`)

Elenco con stato: [INDEX.md](INDEX.md).
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
