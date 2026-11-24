---
<<<<<<< .merge_file_BFYS3h
<<<<<<< .merge_file_tFEKDH
title: "ADR del modulo Media"
type: index
module: Media
status: active
created: 2026-11-18
updated: 2026-11-24
qmd: "Media adr architecture decision records madr formato"
=======
=======
>>>>>>> .merge_file_gZB4Nz
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
<<<<<<< .merge_file_BFYS3h
>>>>>>> .merge_file_ynlwkW
=======
>>>>>>> .merge_file_gZB4Nz
---

# ADR del modulo Media

<<<<<<< .merge_file_BFYS3h
<<<<<<< .merge_file_tFEKDH
Il **perche'** delle scelte di Media sugli upload: quanto puo' pesare un file e chi lo decide, come passano le foto da
telefono, dove stanno i temporanei, chi puo' vedere un allegato e cosa resta nel file salvato (privacy). Una decisione per
file, con le alternative scartate.

Leggili prima di: cambiare un limite di upload, aggiungere un campo che riceve foto, toccare il percorso o le policy degli
upload temporanei, cambiare la visibilita' degli allegati, toccare il trattamento delle immagini salvate o "semplificare" la
ri-codifica con un'altra libreria.

## Metodo Harness

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Un ADR deve rendere
leggibili contesto, driver, alternative, decisione, conseguenze e una conferma ripetibile; non e' un diario ne' una
spiegazione retroattiva inventata.

Le decisioni vanno verificate contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e collega il
precedente come `superseded` o `deprecated`.

Il nome del file e' l'argomento in kebab-case, senza date ne' numeri (la data sta nella frontmatter). Questo README e' l'unico
indice della cartella: ogni ADR compare qui come `[titolo](file.md)`; lo stato di ciascuno e' in [INDEX.md](INDEX.md).

Regola canonica del formato: [action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md); standard
condivisi: [Xot ADR](../../../Xot/docs/adr/README.md); template: [0000-template.md](0000-template.md). Guard:
`Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php`.
=======
=======
>>>>>>> .merge_file_gZB4Nz
Il **perche'** delle scelte di Media sugli upload: quanto puo' pesare un file e chi lo decide, come passano le foto da telefono, dove stanno i temporanei, chi puo' vedere un allegato e cosa resta nel file salvato (privacy).

Leggili prima di: cambiare un limite di upload, aggiungere un campo che riceve foto, toccare il percorso o le policy degli upload temporanei, cambiare la visibilita' degli allegati, toccare il trattamento delle immagini salvate o "semplificare" la ri-codifica con un'altra libreria.

## Metodo Harness

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Un ADR deve rendere leggibili contesto, driver, alternative, decisione, conseguenze e una conferma ripetibile; non e' un diario ne' una spiegazione retroattiva inventata.

Le decisioni vanno verificate contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e collega il precedente come `superseded` o `deprecated`.

Il nome del file e' l'argomento in kebab-case, senza date ne' numeri (la data sta nella frontmatter). Questo README e' l'unico indice della cartella: ogni ADR compare qui come `[titolo](file.md)`.

Regola canonica del formato: [action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md); standard condivisi: [Xot ADR](../../../Xot/docs/adr/README.md).
>>>>>>> laraxot/dev
<<<<<<< .merge_file_BFYS3h
>>>>>>> .merge_file_ynlwkW
=======
>>>>>>> .merge_file_gZB4Nz

## Formato

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
<<<<<<< .merge_file_BFYS3h
<<<<<<< .merge_file_tFEKDH
status: proposed | accepted | superseded | deprecated
=======
=======
>>>>>>> .merge_file_gZB4Nz
<<<<<<< HEAD
status: accepted | superseded | deprecated
=======
status: proposed | accepted | superseded | deprecated
>>>>>>> laraxot/dev
<<<<<<< .merge_file_BFYS3h
>>>>>>> .merge_file_ynlwkW
=======
>>>>>>> .merge_file_gZB4Nz
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

<<<<<<< .merge_file_BFYS3h
<<<<<<< .merge_file_tFEKDH
## Driver
Facoltativa: vincoli, rischi e obiettivi che pesano sulla scelta.

=======
=======
>>>>>>> .merge_file_gZB4Nz
<<<<<<< HEAD
=======
## Driver
Facoltativa: vincoli, rischi e obiettivi che pesano sulla scelta.

>>>>>>> laraxot/dev
<<<<<<< .merge_file_BFYS3h
>>>>>>> .merge_file_ynlwkW
=======
>>>>>>> .merge_file_gZB4Nz
## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.
<<<<<<< .merge_file_BFYS3h
<<<<<<< .merge_file_tFEKDH
=======
=======
>>>>>>> .merge_file_gZB4Nz
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
<<<<<<< .merge_file_BFYS3h
>>>>>>> .merge_file_ynlwkW
=======
>>>>>>> .merge_file_gZB4Nz

## Conferma
Facoltativa: controllo ripetibile (test, guard source-level, review). La presenza dell'ADR non prova l'implementazione.

## Verifica
Comandi e test che esistono davvero; i path `Modules/...php` citati devono esistere.
```

<<<<<<< .merge_file_BFYS3h
<<<<<<< .merge_file_tFEKDH
Sono obbligatorie `## Contesto`, `## Decisione`, `## Alternative scartate`, `## Conseguenze`. Almeno un ADR per pacchetto e'
"sostanziale": ha anche `## Driver` e `## Conferma`.
=======
Almeno un ADR per pacchetto e' "sostanziale": ha anche `## Driver` e `## Conferma`.
>>>>>>> laraxot/dev
>>>>>>> .merge_file_ynlwkW
=======
Almeno un ADR per pacchetto e' "sostanziale": ha anche `## Driver` e `## Conferma`.
>>>>>>> laraxot/dev
>>>>>>> .merge_file_gZB4Nz

## Decisioni

- [Metadati delle foto tolti sul server con GD](strip-image-metadata-server-side.md) — ri-codifica JPEG/PNG senza Exif, GPS e testo; Imagick misurato e scartato.
- [Limite di upload effettivo letto nella richiesta web](effective-upload-limit-in-web-request.md) — minimo tra PHP (con margine), regola Livewire e campo.
- [Foto da fotocamera ridotte nel browser, campo opt-in](camera-photo-browser-resize-opt-in.md) — `CameraPhotoUpload` e `camera-image.js`, mai resize globale.
<<<<<<< .merge_file_BFYS3h
<<<<<<< .merge_file_tFEKDH
- [Upload temporanei con percorso scopato e policy](upload-temporanei-con-percorso-scopato-e-policy.md) — percorsi `tmp/` per scopo (originale, conversione, responsive) e permessi espliciti su `media.*` e `temporary_upload.*`.
- [Upload temporanei con percorso scopato e policy (copia con prefisso numerico)](0001-upload-temporanei-con-percorso-scopato-e-policy.md) — stesso titolo e stessa decisione del precedente, senza la sezione `## Verifica`; da unificare.
- [La visibilita' dei media segue il record owner](media-visibility-follows-owner.md) — ownership e policy del dominio ospitante decidono, non Media.
=======
=======
>>>>>>> .merge_file_gZB4Nz
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
- [Upload temporanei con percorso scopato e policy](upload-temporanei-con-percorso-scopato-e-policy.md) — percorsi `tmp/` per scopo (originale, conversione, responsive) e permessi espliciti su `media.*` e `temporary_upload.*`.
- [La visibilita' dei media segue il record owner](media-visibility-follows-owner.md) — ownership e policy del dominio ospitante decidono, non Media.
>>>>>>> laraxot/dev
<<<<<<< .merge_file_BFYS3h
>>>>>>> .merge_file_ynlwkW
=======
>>>>>>> .merge_file_gZB4Nz
