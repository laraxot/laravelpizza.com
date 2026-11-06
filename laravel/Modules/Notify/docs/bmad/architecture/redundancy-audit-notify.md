---
title: "Notify redundancy audit 2026-05-21"
type: audit
module: Notify
tags: [redundancy, email, config, casing]
created: 2026-05-21
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
updated: 2026-10-23
qmd: "notify redundancy audit 2026-05-21 notify"
---

# Notify redundancy audit 2026-05-21

High-risk findings:
- Email template fragments have case-only duplicates: `contentEnd`/`contentend`, `contentStart`/`contentstart`, `wideImage`/`wideimage`, `articleEnd`/`articleend`.
- Includes still reference camel-case fragment names such as `notify::emails.templates.ark.contentEnd`.
- Config files are duplicated across nested `config/Config/Config`, `config/Config`, `config/config/Config`, `config/config`, and root `config`.
- Many German and English lang files are byte-identical.

Risk:
- Case-only Blade fragment names can fail when moved between case-sensitive and case-insensitive filesystems.
- Nested config duplication hides the active source.

Suggested cleanup order:
1. Resolve Blade include names first; keep the fragment casing that runtime includes already use.
2. Collapse config to the provider-loaded directory only.
3. Treat identical translations as lower-priority generated noise unless they block localization work.
