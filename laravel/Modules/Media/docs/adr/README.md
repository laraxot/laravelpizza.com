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

## Formato

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
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

## Decisioni

- [Metadati delle foto tolti sul server con GD](strip-image-metadata-server-side.md) — ri-codifica JPEG/PNG senza Exif, GPS e testo; Imagick misurato e scartato.
- [Limite di upload effettivo letto nella richiesta web](effective-upload-limit-in-web-request.md) — minimo tra PHP (con margine), regola Livewire e campo.
- [Foto da fotocamera ridotte nel browser, campo opt-in](camera-photo-browser-resize-opt-in.md) — `CameraPhotoUpload` e `camera-image.js`, mai resize globale.
>>>>>>> laraxot/dev
