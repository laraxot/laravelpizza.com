---
id: DOCS-REORG-01
title: "Riorganizzazione docs di moduli e temi"
type: story
status: in-progress
epic: DOCS-GOVERNANCE
priority: P1
story_points: 13
depends_on: []
created: 2026-11-10
updated: 2026-11-10
repository: https://github.com/festionali/base_restaurant_fila5
tags: [docs, modules, themes, readme, bmad, qmd, second-brain]
related:
  - ../../../wiki/standards/module-theme-readme-dual.md
  - ../../../wiki/rules/theme-module-docs-readme-mandatory.md
  - ../../../wiki/rules/markdown-documentation-standard.md
  - ../../../wiki/how-to/module-docs-audit.md
  - ../../../Themes/Trattoria/docs/README.md
---

# Story DOCS-REORG-01 — Riorganizzazione docs di moduli e temi

Come manutentore del monorepo voglio ingressi documentali affidabili per ogni modulo e tema, così che agenti e sviluppatori trovino subito scopo, struttura, stato e codice reale senza leggere documenti stale.

## Contesto verificato

- Il tema pubblico attivo per il tenant `local/restaurant` è **Trattoria**.
- `XotData::make()` legge `config/local/restaurant/xra.php` tramite `GetTenantConfigArrayAction`; il valore risolto è `pub_theme=Trattoria`.
- `config/local/restaurant/xot.php` contiene ancora `pub_theme=TwentyOne`, ma non è la sorgente letta da `XotData`; va considerato legacy da riconciliare o documentare.
- Molti moduli hanno centinaia di documenti; il problema non è la quantità ma l'ingresso: README, indici, link relativi e dichiarazione dei documenti stale.
- `docs/wiki/standards/module-theme-readme-dual.md` e le regole collegate citano `bashscripts/tools/sync-module-theme-readmes.mjs`, che non esiste nel repository.
- Trattoria non ha `docs/README.md`, ha un `README.md` root placeholder e `docs/00-INDEX.md` con link relativi errati.
- Meetup non ha `README.md` root; Fixcity non ha né `README.md` root né `docs/README.md`.

## Scope

### Wave 1 — ingressi critici

- [x] Trattoria: root `README.md` reale e `docs/README.md`.
- [x] Trattoria: correggere `docs/00-INDEX.md` (frontmatter, link relativi, link a README).
- [x] Meetup: creare `README.md` root con rimando a `docs/README.md`.
- [x] Fixcity: creare `README.md` root e `docs/README.md` per lo stato stub del modulo.
- [ ] Allineare o marcare come legacy `config/local/restaurant/xot.php`.
- [ ] Correggere i riferimenti al tool di sync README mancante.

### Wave 2 — audit per modulo

- [ ] Audit frontmatter e link rotti sui moduli con docs > 200 file.
- [ ] Verificare che ogni `docs/README.md` descriva la struttura reale e i documenti stale.
- [ ] Aggiornare gli indici quando si aggiunge o sposta un documento.

### Wave 3 — consolidamento

- [ ] Eliminare duplicati e varianti di indice con il supporto di BMAD e git history.
- [ ] Allineare le istruzioni di build asset/tema con `public_html` e symlink reali.
- [ ] Misurare la copertura QMD e registrare i risultati.

## Criteri di accettazione

1. Ogni modulo e tema attivo ha `README.md` root e `docs/README.md` con link bidirezionali.
2. I README dichiarano scopo, struttura, stato e limiti verificati contro il codice.
3. I link relativi dei documenti toccati risolvono a file esistenti.
4. I documenti stale sono marcati o riconciliati, non lasciati come verità implicita.
5. Le modifiche sono registrate nel repo proprietario del modulo/tema e non in `bmad-output/`.

## Verifica

```bash
test -f laravel/Themes/Trattoria/README.md
test -f laravel/Themes/Trattoria/docs/README.md
test -f laravel/Themes/Meetup/README.md
test -f laravel/Modules/Fixcity/README.md
test -f laravel/Modules/Fixcity/docs/README.md
rg -n '\]\(\.\./\.\./Modules' laravel/Themes/Trattoria/docs
```

## Note di coordinamento

- Trattoria è un repository git indipendente: usare `git -C laravel/Themes/Trattoria`.
- Xot è un repository git indipendente: usare `git -C laravel/Modules/Xot`.
- Meetup e Fixcity non hanno un `.git` proprio: le modifiche ricadono nel repo root.
- Non usare `bmad-output/`; non spostare o cancellare documenti senza approvazione esplicita.
