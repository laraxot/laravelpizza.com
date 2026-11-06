---
bmad_id: MEDIA-binary-assets
domain: media-module
version: 1.0.0
tags: [media, docs]
created: 2026-10-06
updated: 2026-10-06
title: "Asset binari"
type: note
qmd: "asset binari media"
status: superseded
superseded_by: ../binary-assets.md
---

# Asset binari

Gli asset binari sono file normali del repository.

Regole:
- non aggiungere filtri o backend di storage esterno in `.gitattributes`;
- non committare file pointer al posto del contenuto reale;
- se un asset manca, recuperare il binario originale e committarlo direttamente;
- prima del push verificare che immagini, font, archivi e PDF siano contenuti reali.
