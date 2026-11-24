---
issues: []
discussions: []
title: collisione GitHub remote sbagliato nei docs Tenant
type: memory
tags: [github, git, merge, remote, tenant, grave]
module: Tenant
created: 2026-07-27
updated: 2026-07-27
qmd: "Tenant git remote module_tenant_fila5 base_project base_workorder collision grave"
related:
  - ../../../../../../docs/wiki/memories/module-github-remote-discipline.md
  - ../../../../../../docs/wiki/rules/multi-repo-modules-themes-map.md
  - ../../../../../../docs/wiki/how-to/module-theme-github-issues.md
  - ../../code-quality-improvement-report.md
---

# Collisione Git: entrambe le parti sbagliate (Tenant)

## Errore

In `docs/code-quality-improvement-report.md` un conflitto Git aveva:

- HEAD → `laraxot/<nome repository>`
- other → `laraxot/<nome repository>`

**Entrambi errati.** Il remote del modulo è:

```bash
cd laravel/Modules/Tenant && git remote -v
# laraxot → git@github.com:laraxot/module_tenant_fila5.git
```

## Perché è grave

1. Scegliere «current» o «incoming» **non basta**: può essere falso vs falso.
2. Issue/discussion del mono finiscono nei docs del modulo → audit trail spezzato.
3. Altri agenti e `gh` operano sulla repo sbagliata.

## Regola operativa

Prima di scrivere URL GitHub in `Modules/*/docs` o `Themes/*/docs`:

1. `cd` nella cartella del componente
2. `git remote -v`
3. Usare quel owner/repo (o solo `#N` + istruzione remote)

Mai indovinare da nomi `base_*` del monorepo o di altri progetti.

## Canon cross-cutting

- [module-github-remote-discipline](../../../../../../docs/wiki/memories/module-github-remote-discipline.md)
- [multi-repo-modules-themes-map](../../../../../../docs/wiki/rules/multi-repo-modules-themes-map.md)
- skill [module-theme-git-remote-resolve](../../../../../../docs/wiki/skills/module-theme-git-remote-resolve.md)
