---
title: "Git push UI — history unrelated laraxot vs provtv + loop automatico"
type: rule
module: UI
tags: [git, push, dual-remote, unrelated, multi-org, ui, forward-only]
created: 2026-07-23
updated: 2026-07-23
qmd: "UI module_ui_fila5 push unrelated histories laraxot provtv loop automatico no merge force"
related:
  - "../../multi-org-sync-laraxot-provtv.md"
  - "../../git-multi-org-sync-handoff.md"
  - "./git-push-lfs-missing-objects.md"
  - "./git-push-lfs-missing-objects.md"
  - "./git-push-lfs-missing-objects.md"
  - "./git-push-lfs-missing-objects.md"
  - "./git-push-lfs-missing-objects.md"
  - "../../../../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md"
---

# Git push UI — history unrelated (laraxot ↔ provtv) + loop automatico

## Perché

`Modules/UI` ha due remote:

- `laraxot` → `laraxot/module_ui_fila5`
- `provtv` → `provtv/module_ui_fila5`

Stesso pattern del caso [User](../../../../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md): `provtv/dev` è fermo su un commit orfano (`dfbb8305`, autore `marco76tv`, msg ".", ~2200 file nel diff — snapshot completo, non un semplice gap), `git merge-base HEAD provtv/dev` fallisce (unrelated). `laraxot/dev` invece resta allineato.

## Scoperta aggiuntiva 2026-07-23: non è un evento singolo, è un loop

A differenza del caso User (diagnosticato una volta, poi fermo), su UI il ri-merge di `provtv/dev` è **ricorrente**: nella stessa sessione, la risoluzione completa dei marker di conflitto (verificata 0 marker, `php -l` pulito, push su `laraxot` riuscito) è stata **reintrodotta due volte** da un processo che rilancia periodicamente merge/rebase con `provtv/dev` — visibile in `git reflog` come `pull --rebase provtv dev (start)` / `rebase (abort)` intercalati a commit vuoti `.` dallo stesso autore. Un tentativo di `git push provtv dev` per allineare direttamente il remote stantio (bypassando il merge) è stato rifiutato come non-fast-forward nonostante localmente risultasse un FF pulito — causa non determinata (branch protection? mirror non standard?).

## Cosa fare / non fare

| Scenario | Azione |
|----------|--------|
| Solo `laraxot` da pubblicare | push normale, verificato allineato (`0 0`) |
| `provtv` unrelated + loop attivo | **Niente** merge/rebase/force finché l'utente non ferma/corregge il processo che genera i commit `.` periodici su `provtv`, o non sceglie esplicitamente la storia autoritativa |
| Trovi marker di conflitto già risolti che riappaiono | Non è un tuo errore né di un altro agente: è il loop. Rifai la stessa risoluzione (bulk per SVG whitespace-only, giudizio via grep sui caller per PHP/lang) ma non aspettarti che regga finché la causa a monte non è rimossa |

**Vietato agenti:** `push --force`, `merge --allow-unrelated-histories` ripetuto senza motivo (rischia di sprecare lavoro contro il loop), `reset`/`checkout` per "aggiustare".

## Relazione con altri playbook

- Stesso pattern, altro modulo: [User git-push-dual-remote-unrelated](../../../../User/docs/wiki/troubleshooting/git-push-dual-remote-unrelated.md)
- LFS / `--no-thin`: [UI git-push-lfs-missing-objects](./git-push-lfs-missing-objects.md)
- LFS / `--no-thin`: [UI git-push-lfs-missing-objects](./git-push-lfs-missing-objects.md)
- LFS / `--no-thin`: [UI git-push-lfs-missing-objects](./git-push-lfs-missing-objects.md)
- LFS / `--no-thin`: [UI git-push-lfs-missing-objects](./git-push-lfs-missing-objects.md)
- LFS / `--no-thin`: [UI git-push-lfs-missing-objects](./git-push-lfs-missing-objects.md)
- Storico risoluzione marker di conflitto (73 file, poi ricorsi): [git-merge-conflict-inventory.md](./git-merge-conflict-inventory.md)
