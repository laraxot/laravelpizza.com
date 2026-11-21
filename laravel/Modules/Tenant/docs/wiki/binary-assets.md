---
title: "binary-assets.md"
type: concept
status: active
module: "Tenant"
tags: [docs, tenant, bmad]
created: 2026-10-06
updated: 2026-10-06
---

# Asset binari

Gli asset binari sono file normali del repository.

Regole:
- non aggiungere filtri o backend di storage esterno in `.gitattributes`;
- non committare file pointer al posto del contenuto reale;
- se un asset manca, recuperare il binario originale e committarlo direttamente;
- prima del push verificare che immagini, font, archivi e PDF siano contenuti reali.
