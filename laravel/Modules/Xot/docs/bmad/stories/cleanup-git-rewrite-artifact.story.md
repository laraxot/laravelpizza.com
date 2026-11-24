---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
issues: []
discussions: []
title: "Rimuovere l'artefatto .git-rewrite/t/ (leftover filter-branch)"
type: story
module: Xot
status: backlog
track: docs-hygiene
qmd: "git-rewrite filter-branch leftover artifact untracked mirror docs cleanup"
related:
  - ./docs-filename-no-date-bonifica-xot.story.md
---

# Rimuovere `.git-rewrite/t/`

## Perche'

`Modules/Xot/.git-rewrite/` e' interamente **non tracciato** (`git ls-files`
vuoto, `git log --all -- .git-rewrite` vuoto): non e' storia git, e' la
directory di lavoro temporanea che `git filter-branch` crea (`t/` = checkout
di lavoro, `map/` = mapping vecchi->nuovi commit) e normalmente cancella da
sola a fine run. Qui e' rimasta sul disco — la run e' stata interrotta o e'
crashata prima della pulizia automatica.

`.git-rewrite/t/` mirror l'intero albero del modulo (`app/`, `docs/`, `tests/`,
`config/`, `lang/`, `routes/`, ecc. — non solo `docs/`, correzione rispetto
alla nota precedente che la descriveva come mirror di `docs/` soltanto).

## Verifica gia' fatta (questa sessione)

- `git -C laravel/Modules/Xot ls-files .git-rewrite` → vuoto (non tracciato)
- `git -C laravel/Modules/Xot log --oneline --all -- .git-rewrite` → vuoto
  (nessuna storia, mai committato)
- `git -C laravel/Modules/Xot status --short .git-rewrite` → vuoto (non e'
  nemmeno untracked secondo git — probabilmente coperto da `.gitignore`,
  o il working tree e' fuori dal path che git status esamina di default;
  da confermare con `git status --short --ignored .git-rewrite`)

Per la memoria progetto "verificare prima di cancellare una copia"
(28% dei presunti duplicati in questo repo erano l'unica copia buona):
qui il criterio e' diverso e piu' forte — non e' un duplicato di contenuto,
e' un artefatto di processo (git lo confermerebbe come storia se fosse reale).

## Task

- [ ] `git status --short --ignored laravel/Modules/Xot/.git-rewrite` — confermare
      se e' gia' in `.gitignore` (in tal caso aggiungere la regola se manca,
      cosi' non ricapita) o del tutto invisibile a git
- [ ] `du -sh laravel/Modules/Xot/.git-rewrite` — dimensione, per capire impatto
      di un `rm -rf` (operazione distruttiva locale, non su dati applicativi:
      non ricade sotto la regola "dati sacri", ma resta un `rm -rf` da fare con
      conferma esplicita)
- [ ] Rimuovere `laravel/Modules/Xot/.git-rewrite/` dal disco
- [ ] Se non gia' in `.gitignore`: aggiungere `.git-rewrite/` per prevenire
      che una futura `filter-branch` interrotta la ricommitti per errore

## Acceptance

- [ ] `laravel/Modules/Xot/.git-rewrite/` non esiste piu' su disco
- [ ] `.gitignore` copre `.git-rewrite/` per il futuro
- [ ] Nessuna regressione: repo Xot pulito, PHPStan/Pest invariati (l'artefatto
      non e' codice caricato da nessun autoloader)
