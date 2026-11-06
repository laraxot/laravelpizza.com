---
title: "CMS Content, Routing and Theme Boundary"
type: concept
module: Cms
sources:
  - "../../../README.md"
  - "../../00-index.md"
confidence: high
created: 2026-10-14
updated: 2026-10-14
tags: [cms, folio, json, tenant, theme-boundary]
related:
  - "../../../../Fixcity/docs/wiki/concepts/ticket-domain-and-public-flow-boundary.md"
  - "../../../../../Themes/Sixteen/docs/wiki/concepts/legal-consent-ui-boundary.md"
  - "../../../../../../bmad-output/docs-architecture/ownership.md"
status: draft
qmd: "cms content, routing and theme boundary cms"
---

# CMS content, routing and theme boundary

`Modules/Cms` owns the content contract and page resolution. Tenant JSON files
provide localized page data and block configuration; Folio pages resolve the URL;
the active theme owns the public layout and visual rendering.

## Runtime contract

- Pages live in `config/<tenant>/database/content/pages/` as localized JSON.
- `ResolvePageAction` and `PageSlugMiddleware` resolve the page and declared
  middleware; CMS route files are not the source of public page routing.
- Blocks are data records with a `type`; their Blade rendering belongs to the CMS
  or the active theme according to the component boundary.
- Sixteen owns markup, CSS and JavaScript for public presentation. It must not
  duplicate page persistence or CMS policy.

## Change rule

When a page is missing or wrong, inspect JSON + resolver + Folio page before
changing the theme. When the data is correct but the appearance is wrong, change
the theme and document the parity evidence there.

## References

- [Fixcity public ticket flow](../../../../Fixcity/docs/wiki/concepts/ticket-domain-and-public-flow-boundary.md)
- [Sixteen legal-consent UI boundary](../../../../../Themes/Sixteen/docs/wiki/concepts/legal-consent-ui-boundary.md)
- [Documentation ownership](../../../../../../bmad-output/docs-architecture/ownership.md)

