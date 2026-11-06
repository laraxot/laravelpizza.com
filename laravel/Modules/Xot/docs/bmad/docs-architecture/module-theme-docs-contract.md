---
title: "Module and theme docs contract"
type: rule
status: active
updated: 2026-10-13
tags: [documentation, modules, themes, bmad, quality]
qmd: "module theme docs contract README 00 INDEX stories wiki"
---

# Contratto per moduli e temi

Ogni `laravel/Modules/*/docs/` e `laravel/Themes/*/docs/` deve avere:

- `README.md`: unico ingresso root attivo, identità, ownership, quick start e limiti;
- un eventuale `00-INDEX.md`, `00-index.md` o `INDEX.md`: solo se già esistente,
  come alias o indice storico esplicitamente collegato al README;
- `wiki/` per regole e concetti riusabili;
- `stories/` quando esistono attività BMAD del perimetro;
- `investigation/` per diagnosi non ancora risolte;
- un decision log locale quando il perimetro ha decisioni indipendenti.

Le directory e gli indici già presenti possono essere mantenuti. Il README deve
però dichiarare quali sono canonici, quali sono evidence e quali sono legacy. Non
creare un nuovo indice con un nome alternativo per risolvere un indice incompleto.

## Definition of done documentale

1. il documento ha front matter (`title`, `type`, `status`, `owner`, `updated`, `tags`, `qmd`);
2. i link relativi usati dall'indice esistono oppure sono marcati esplicitamente;
3. la story collega acceptance criteria, file owner e verifica;
4. le affermazioni di parity o WCAG hanno evidence, non solo percentuali;
5. ogni duplicato nuovo viene fermato o collegato a un canonico.
