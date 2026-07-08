---
title: "BMAD v6.6 Codex Setup for Laravel 13 Upgrade"
module: "AI"
type: concept
created: "2026-05-05"
updated: "2026-05-05"
qmd: "BMAD 6.6, Codex skills, Laravel 13 upgrade, create story, second brain"
related:
  - "../bmad-method.md"
  - "../../../../../../docs/llm-wiki-qmd.md"
---

# BMAD v6.6 Codex Setup for Laravel 13 Upgrade

## Installed State

BMAD was updated locally with:

```bash
npx bmad-method install --directory . --modules bmm --tools codex --action update --user-name Codex --communication-language Italian --document-output-language Italian --output-folder _bmad-output --set bmm.user_skill_level=expert --set bmm.project_knowledge=docs --yes
```

Installer result:

- BMad Core: `v6.3.0` -> `v6.6.0`
- BMad Method BMM: `v6.3.0` -> `v6.6.0`
- Codex integration: `42` skills generated in `.agents/skills`
- Output folder: `_bmad-output`
- Project knowledge folder: `docs`

## Workflow Mapping

For the Laravel 13 work:

1. `bmad-create-story` creates the implementation story with Composer blockers, package owners, docs rules, and quality gates.
2. `bmad-dev-story` should apply dependency edits only after story review.
3. `bmad-code-review` should check Composer ownership, Laravel 13 breaking-change audit, and docs/QMD ingest.

## Second Brain Rule

Before changing dependencies, query QMD:

```bash
qmd search "Laravel 13 composer merge plugin nwidart laravel modules" -c module_Xot
qmd search "second brain qmd ingest docs modules themes" -c main_docs
```

For this project, "second brain" means local markdown knowledge in `docs/raw`, `docs/wiki`, and `docs/outputs`, indexed by QMD and maintained close to the owning project/module/theme.

## References

- BMAD install docs: https://docs.bmad-method.org/how-to/install-bmad/
- Local guide: `docs/llm-wiki-qmd.md`
- Project concept: `docs/wiki/concepts/laravel13-modular-composer-upgrade-plan.md`
- Story: `_bmad-output/implementation-artifacts/13-1-laravel13-modular-composer-upgrade.md`
