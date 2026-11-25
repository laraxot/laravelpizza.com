---
qmd: "dashboard provider docs.story"
title: "Correct AI dashboard contract and provider documentation"
type: story
module: AI
status: done
created: 2026-09-25
updated: 2026-09-25
tags: [bmad, dashboard, phpstan, providers, docs]
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../wiki/concepts/provider-support-and-doc-ownership.md
  - ../../../Xot/docs/wiki/concepts/module-dashboard-page-mandatory.md
---

# Story: correct dashboard and provider documentation

## As a maintainer

I want the AI module documentation to describe the real dashboard base class and
provider implementation, so PHPStan cleanup and agent guidance preserve runtime
architecture and do not advertise integrations that are absent.

## Acceptance criteria

- [x] AI panel dashboard extends `XotBaseDashboard`; PHPStan findings do not
  justify changing the panel landing-page contract.
- [x] The stale `XotBasePage` example in PHPStan history is corrected and the
  reason is linked to the Xot canonical rule.
- [x] Provider statements identify actual code paths and scope missing Claude /
  Gemini adapters to `Modules/AI/app`.
- [x] AI and Themes indexes route readers to one provider support map; the Gemini
  theme note no longer reads as a configured integration manual.
- [x] `./vendor/bin/phpstan analyse Modules` completed with `[OK] No errors` on
  2026-09-25 after the code fixes.

## Implementation notes

Claude/GPT/Gemini are agent-provider labels, not theme folders. Runtime ownership
stays with modules; theme documentation stays focused on presentation and links
to the module owner. See the [provider support map](../wiki/concepts/provider-support-and-doc-ownership.md).
