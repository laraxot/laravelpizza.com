---
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
title: "ADR — Media"
type: index
tags: [adr, decisioni, media]
created: 2026-11-18
updated: 2026-11-24
=======
title: "ADR del modulo Media"
type: index
module: Media
status: active
created: 2026-11-18
updated: 2026-11-24
qmd: "Media adr architecture decision records madr formato"
>>>>>>> laraxot/dev
---

# ADR del modulo Media

<<<<<<< HEAD
Il **perche'** delle scelte di Media sugli upload: quanto puo' pesare un file e chi lo decide, come passano le foto da telefono, dove stanno i temporanei, chi puo' vedere un allegato e cosa resta nel file salvato (privacy).

Leggili prima di: cambiare un limite di upload, aggiungere un campo che riceve foto, toccare il percorso o le policy degli upload temporanei, cambiare la visibilita' degli allegati, toccare il trattamento delle immagini salvate o "semplificare" la ri-codifica con un'altra libreria.

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

<<<<<<< HEAD
=======
## Driver
Facoltativa: vincoli, rischi e obiettivi che pesano sulla scelta.

>>>>>>> laraxot/dev
## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.
<<<<<<< HEAD
```

## Decisioni

=======
title: "ADR — Media"
type: index
tags: [adr, decisioni, media]
created: 2026-11-18
updated: 2026-11-24
---

# ADR del modulo Media

Il **perche'** delle scelte di Media sugli upload: quanto puo' pesare un file e chi lo decide, come passano le foto da
telefono, cosa resta nel file salvato (privacy).

Leggili prima di: cambiare un limite di upload, aggiungere un campo che riceve foto, toccare il trattamento delle immagini
salvate o "semplificare" la ri-codifica con un'altra libreria.

Formato (5 sezioni, frontmatter `type: decision`): [regola canonica](../../../Xot/docs/rules/action-behavioral-contract.md).
=======

## Conferma
Facoltativa: controllo ripetibile (test, guard source-level, review). La presenza dell'ADR non prova l'implementazione.

## Verifica
Comandi e test che esistono davvero; i path `Modules/...php` citati devono esistere.
```

Almeno un ADR per pacchetto e' "sostanziale": ha anche `## Driver` e `## Conferma`.
>>>>>>> laraxot/dev

## Decisioni

- [Metadati delle foto tolti sul server con GD](strip-image-metadata-server-side.md) — ri-codifica JPEG/PNG senza Exif, GPS e testo; Imagick misurato e scartato.
- [Limite di upload effettivo letto nella richiesta web](effective-upload-limit-in-web-request.md) — minimo tra PHP (con margine), regola Livewire e campo.
- [Foto da fotocamera ridotte nel browser, campo opt-in](camera-photo-browser-resize-opt-in.md) — `CameraPhotoUpload` e `camera-image.js`, mai resize globale.
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
- [Upload temporanei con percorso scopato e policy](upload-temporanei-con-percorso-scopato-e-policy.md) — percorsi `tmp/` per scopo (originale, conversione, responsive) e permessi espliciti su `media.*` e `temporary_upload.*`.
- [La visibilita' dei media segue il record owner](media-visibility-follows-owner.md) — ownership e policy del dominio ospitante decidono, non Media.
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

- [0001-upload-temporanei-con-percorso-scopato-e-policy](0001-upload-temporanei-con-percorso-scopato-e-policy.md)
- [media-visibility-follows-owner](media-visibility-follows-owner.md)

Elenco con stato: [INDEX.md](INDEX.md).
>>>>>>> laraxot/dev
