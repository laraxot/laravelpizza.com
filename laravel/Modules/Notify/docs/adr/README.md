---
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
title: "ADR del modulo Notify"
type: index
tags: [adr, decisioni, notify]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Notify

Il **perche'** delle scelte di Notify: una decisione per file, con le alternative scartate. Il nome del file e' l'argomento, senza
date ne' numeri (la data sta nella frontmatter). Formato e regole: `Modules/Xot/docs/rules/action-behavioral-contract.md` e
[ADR di Xot](../../../Xot/docs/adr/README.md).

Quando leggerli: prima di aggiungere un webhook o un fornitore (email, SMS), di far scrivere al modulo dati che appartengono al
progetto, di leggere configurazione con `env()` o di far inviare notifiche fuori dalle Action di consegna.

## Metodo

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Un ADR rende leggibili
contesto, alternative, decisione, conseguenze e una verifica ripetibile; non e' un diario ne' una spiegazione retroattiva inventata.

Le decisioni si verificano contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e segna il precedente
`superseded` o `deprecated`, collegandolo al nuovo.
>>>>>>> laraxot/dev

## Formato

```markdown
---
<<<<<<< HEAD
title: "ADR — <decisione in una riga>"
type: decision
status: accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
=======
title: "ADR - <decisione>"
type: decision
status: proposed | accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
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
```

## Decisioni


## Decisioni precedenti (formato libero, non ancora ADR)

- [notification-logs-migration-consolidation](../wiki/decisions/notification-logs-migration-consolidation.md)
- [sms-actions-consolidation-](../wiki/decisions/sms-actions-consolidation-.md)
- [sms-actions-consolidation](../wiki/decisions/sms-actions-consolidation.md)
=======

## Verifica
Comandi o test che esistono e falliscono se la decisione viene violata; solo cio' che si puo' ripetere.
```

Un ADR "sostanziale" aggiunge `## Driver della decisione` e `## Conferma` (come i due ADR sulla configurazione e sulla consegna).

## Decisioni

- [I webhook in ingresso si autenticano con un token nel percorso](webhooks-authenticate-with-a-token-in-the-path.md) — `hash_equals`, 401 se il token non e' configurato, 200 a Mailjet anche per eventi sconosciuti.
- [Gli esiti delle email sono un evento Laravel](mail-delivery-outcomes-are-events.md) — `MailDeliveryEventReceived`, il progetto decide cosa farne.
- [Configurazione Notify centralizzata](notify-config-is-centralized.md) — niente `env()` sparsi: la configurazione passa dall'adapter del modulo.
- [Notify centralizza template e consegna delle notifiche](notify-owns-delivery-contract.md) — le Action possiedono l'orchestrazione dei canali; le route espongono solo endpoint tecnici.

## Decisioni precedenti (formato libero, non ancora ADR)

- [Consolidamento migrazioni notification_logs](../wiki/decisions/notification-logs-migration-consolidation.md) — lo schema del modello `NotificationLog` vince sulle due migrazioni duplicate.
- [Consolidamento delle Action SMS](../wiki/decisions/sms-actions-consolidation.md) — nota deprecata.
- [Consolidamento delle Action SMS (copia con trattino finale)](../wiki/decisions/sms-actions-consolidation-.md) — nota deprecata.
>>>>>>> laraxot/dev
