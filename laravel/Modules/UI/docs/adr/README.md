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
title: "ADR — UI"
type: index
tags: [adr, decisioni, ui]
created: 2026-11-18
updated: 2026-11-24
---

# ADR — UI

UI è un modulo di base usato da Cms, dai temi e dai pannelli: le sue decisioni riguardano soprattutto **i confini** (cosa UI può sapere degli altri moduli, cosa non autorizza) e **i blocchi di contenuto** (come si trovano, come si localizzano, come si disegnano quando sono rotti).

**Quando leggerli**: prima di importare una classe di un altro modulo in UI, di aggiungere o rinominare un blocco del page builder, di cambiare cosa mostra `x-ui::render.block`, o di far decidere a un componente UI chi può vedere un dato di dominio.

## Metodo Harness

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Un ADR deve rendere leggibili contesto, driver, alternative, decisione, conseguenze e una conferma ripetibile; non e' un diario ne' una spiegazione retroattiva inventata.

Le decisioni vanno verificate contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e collega il precedente come `superseded` o `deprecated`.

Il nome del file e' l'argomento in kebab-case, senza date ne' numeri (la data sta nella frontmatter). Questo README e' l'unico indice della cartella: ogni ADR compare qui come `[titolo](file.md)`.

Regola canonica del formato: [action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md); standard condivisi: [Xot ADR](../../../Xot/docs/adr/README.md).
>>>>>>> laraxot/dev

## Formato

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
<<<<<<< HEAD
status: accepted | superseded | deprecated
=======
status: proposed | accepted | superseded | deprecated
>>>>>>> laraxot/dev
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Driver
Facoltativa: vincoli, rischi e obiettivi che pesano sulla scelta.

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.

## Conferma
Facoltativa: controllo ripetibile (test, guard source-level, review). La presenza dell'ADR non prova l'implementazione.

## Verifica
Comandi e test che esistono davvero; i path `Modules/...php` citati devono esistere.
```

Almeno un ADR per pacchetto e' "sostanziale": ha anche `## Driver` e `## Conferma`.

## Decisioni

- [Delega opzionale a Cms per i dati dei blocchi](optional-cms-delegation-for-block-data.md) — UI chiama il resolver di Cms per nome stringa, mai con `use`, e funziona senza Cms.
- [Scoperta dei blocchi per cartella](block-discovery-by-filament-blocks-folder.md) — i blocchi sono le classi in `app/Filament/Blocks` di ogni modulo; il nome deriva dalla classe.
- [Vista mancante: tipo sì, contenuto no](missing-block-view-shows-type-not-content.md) — un blocco rotto mostra un avviso con vista e tipo, mai i suoi dati.
- [Blocchi UI localizzati dal CMS](ui-blocks-use-cms-localization.md) — la localizzazione passa dal CMS quando c'è, con fallback autonomo; il meccanismo è nell'ADR sulla delega opzionale.
- [UI è il layer condiviso e non possiede né autorizza il dominio](ui-does-not-authorize-domain-data.md) — contratti mappa/geocoding con fallback Null; query e policy restano al modulo owner (status `proposed`).
