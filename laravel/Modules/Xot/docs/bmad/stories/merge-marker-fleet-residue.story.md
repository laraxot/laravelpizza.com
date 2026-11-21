---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
issues: []
discussions: []
title: "Story — bonifica marker merge residui fleet"
type: story
module: Xot
epic: quality
story_id: "merge-marker-fleet-residue"
status: ready
track: quality/fleet
qmd: "merge marker conflitto residui fleet bonifica gitmodules HEAD checkout marker committati"
related:
  - ../../../docs/bmad/stories/git-status-fleet-sync.story.md
  - ../../../../../../bashscripts/docs/prompts/03-quality-gates.md
---

# merge-marker-fleet-residue

## Perche'

Sessione 2026-09-22: ~2644 marker `<<<<<<<` risolti prendendo lato HEAD, ma
~900 file fuori scope (docs, WIP altrui) possono ancora contenerne. Marker in
file PHP/JSON/blade = boot rotto o output corrotto.

## Task

- [ ] Scan completo: `rg -l '<<<<<<<|>>>>>>>' Modules/ Themes/` escludendo
      i `.md` dove i marker sono esempi intenzionali (verificare contesto)
- [ ] Per ogni file: verificare se HEAD del submodulo e' pulito
      (`git show HEAD:file | grep -c '<<<<<<<'`) → `git checkout HEAD --` sicuro
- [ ] Se HEAD contiene marker committati: risoluzione manuale lato migliore
      (criterio: versione con piu' contenuto/traduzioni, come fatto in Notify)
- [ ] `php -l` su ogni PHP toccato, `phpstan analyse` finale
- [ ] Registrare in story quali file avevano marker committati in HEAD
      (sintomo di processo rotto a monte: daemon committa worktree sporco)

## AC

- [ ] Zero marker in `.php`/`.json`/`.blade.php` su tutti i moduli
- [ ] PHPStan Modules 0 errori post-bonifica
- [ ] Memoria aggiornata con conteggio residuo trovato
