---
qmd: "binary assets"
issues: []
discussions: []
title: "Asset binari"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
<<<<<<< .merge_file_1r5EPN
<<<<<<< .merge_file_jqLCY1
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_GP1E7X
<<<<<<< HEAD
updated: 2026-08-24
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_1r5EPN
>>>>>>> .merge_file_uGYzPA
=======
>>>>>>> .merge_file_GP1E7X
---

# Asset binari

Gli asset binari sono file normali del repository.

Regole:
- non aggiungere filtri o backend di storage esterno in `.gitattributes`;
- non committare file pointer al posto del contenuto reale;
- se un asset manca, recuperare il binario originale e committarlo direttamente;
- prima del push verificare che immagini, font, archivi e PDF siano contenuti reali.
