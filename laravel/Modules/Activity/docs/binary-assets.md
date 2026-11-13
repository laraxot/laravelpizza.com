<<<<<<< .merge_file_3moxFW
=======
---
title: "Asset binari"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity]
qmd: "asset binari activity"
---
>>>>>>> .merge_file_yRg7Im
# Asset binari

Gli asset binari sono file normali del repository.

Regole:
- non aggiungere filtri o backend di storage esterno in `.gitattributes`;
- non committare file pointer al posto del contenuto reale;
- se un asset manca, recuperare il binario originale e committarlo direttamente;
- prima del push verificare che immagini, font, archivi e PDF siano contenuti reali.
