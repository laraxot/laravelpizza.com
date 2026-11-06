---
title: "BMAD completion pack — Gdpr"
type: note
status: draft
updated: 2026-10-26
tags: [docs, gdpr, bmad]
qmd: "bmad completion pack   gdpr gdpr"
---
# BMAD completion pack — Gdpr

This is the owner-local BMAD entry point. Cross-owner contracts are in plans/fixcity-completion-architecture.md; the backlog is in docs/completion-backlog.md.

## Architecture

Boundary: consent, export, deletion and retention.
- Inputs, outputs, authorization, persistence owner, failure behavior and localization must be recorded before implementation.
- Reuse XotBase, Queueable Actions, Folio/Volt, Filament schemas and shared theme components where applicable.
- No new Controller, Service, Bootstrap component, duplicate migration or mixed shortcut without an explicit decision.
- Shared files are serialized; owned files are declared in the story before parallel work.

## Brainstorming

- 5 Whys: identify why the current behavior exists before changing it.
- SCAMPER: reuse, simplify and remove duplicated paths before adding abstractions.
- Reverse brainstorm: list privacy, accessibility, migration, localization and provider failure modes.
- Top question: what user or operator promise does this owner protect?

## Stories

- Primary story map: plans/fixcity-completion-epics.md.
- Owner backlog: ../completion-backlog.md.
- New stories must use plans/stories, include Acceptance Criteria, Testing and Owned File/Module Scope.
- Mark work verified only with live evidence; historical status documents are context, not proof.

## Definition of done

- Intended behavior and caller map are documented.
- Focused test/static/UI evidence is recorded, with blockers explicit.
- Localization, security/privacy and accessibility impact are checked.
- Second Brain/Hindsight receives durable corrections and Graphify is updated after code changes.
