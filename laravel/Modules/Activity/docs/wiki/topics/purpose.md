---
title: "Topic purpose"
type: digest
status: active
qmd: "digest ceiling 100 purpose"
---

# Topic purpose

Sintesi automatica di 3 documenti (chiave `purpose`).

## Activity — perche' esiste

_Fonte: `bmad/purpose.md`_

# Activity — perche' esiste

## Lo scopo in una frase

**Activity risponde alla domanda "chi ha cambiato cosa, quando e com'era prima" — che
in una pubblica amministrazione non e' curiosita', e' un obbligo.**

## L'evidenza

Il modulo tiene insieme **due meccanismi diversi**, ed e' importante non confonderli:

| Modello | Meccanismo | Domanda a cui risponde |
|---|---|---|
| `Activity` | activity log (Spatie) | "chi ha toccato questo record" |
| `StoredEvent`, `Snapshot` | event sourcing (Spatie) | "come si e' arrivati a questo stato" |

Solo 66 file PHP ma **694 documenti** in `docs/`: e' un modulo piccolo di codice e
grande di conseguenze.

## Perche' i due meccanismi non vanno fusi

- L'**activity log** e' una traccia *accanto* al dato: il dato vive per conto suo, il
  log lo osserva. Perderlo e' grave ma non distrugge lo stato.
- L'**event sourcing** e' il dato: lo stato *e'* la somma degli eventi, e lo snapshot e'
  solo un'ottimizzazione. Perdere gli eventi significa perdere tutto.

Trattarli allo stesso modo — per esempio applicando una politica di cancellazione
uniforme — e' l'errore da evitare. **Uno si puo' potare, l'altro no.**

## Activity: scopo del modulo

_Fonte: `purpose.md`_

# Activity: scopo del modulo

## Lo scopo in una frase **Activity risponde alla domanda "chi ha cambiato cosa, quando e com'era prima" — che in una pubblica amministrazione non e' curiosita', e' un obbligo.**

## Confini

Verificare sul codice: dipendenze verso Xot/User/Ptv/Sigma secondo la regola
«i verticali dipendono da base e framework, la base non dipende dai verticali».

## Riferimenti

- [Audit BMAD](./bmad/audit.md)
- [Piano di miglioramento](./bmad/piano-miglioramento.md)
- [ECC](./ecc/activity-ecc-audit.md)

## Activity — perche' esiste

_Fonte: `wiki/purpose.md`_

# Activity — perche' esiste

## Lo scopo in una frase

**Activity risponde alla domanda "chi ha cambiato cosa, quando e com'era prima" — che
in una pubblica amministrazione non e' curiosita', e' un obbligo.**

## L'evidenza

Il modulo tiene insieme **due meccanismi diversi**, ed e' importante non confonderli:

| Modello | Meccanismo | Domanda a cui risponde |
|---|---|---|
| `Activity` | activity log (Spatie) | "chi ha toccato questo record" |
| `StoredEvent`, `Snapshot` | event sourcing (Spatie) | "come si e' arrivati a questo stato" |

Solo 66 file PHP ma **694 documenti** in `docs/`: e' un modulo piccolo di codice e
grande di conseguenze.

## Perche' i due meccanismi non vanno fusi

- L'**activity log** e' una traccia *accanto* al dato: il dato vive per conto suo, il
  log lo osserva. Perderlo e' grave ma non distrugge lo stato.
- L'**event sourcing** e' il dato: lo stato *e'* la somma degli eventi, e lo snapshot e'
  solo un'ottimizzazione. Perdere gli eventi significa perdere tutto.

Trattarli allo stesso modo — per esempio applicando una politica di cancellazione
uniforme — e' l'errore da evitare. **Uno si puo' potare, l'altro no.**
