---
title: "Cookiebar Bootstrap Italia nel second brain (superato)"
type: note
status: stale
stale_reason: "Superato da cookie-banner.md (DCP-153, 2026-10-14): non descrive il banner che gira. Il contenuto resta come cronologia."
superseded_by: cookie-banner.md
updated: 2026-10-14
tags: [gdpr, cookie, stale]
qmd: "cookiebar superato cookie-banner dcp-153"
---

# Second Brain: Cookiebar Bootstrap Italia Integration

## Integration Summary
- **Component**: Bootstrap Italia Cookiebar
- **Framework**: TailwindCSS + Alpine.js + Lit + DaisyUI + Flowbite (no Bootstrap)
- **GDPR Module**: Integrated into existing cookiebar-integration.md

## Key Points
- Markup uses `section.cookiebar` with `data-bs-accept="cookiebar"`
- Preference link: `/bootstrap-italia/docs/esempi/cookiebar/`
- No Bootstrap CSS — relies on Tailwind + DaisyUI + Flowbite
- Alpine.js manages the accept button behavior
- Aligns with existing Gdpr consent flow

## Next Steps
- [ ] Create BMAD story (done)
- [ ] Add entry to second brain (done)
- [ ] Verify integration in layout
- [ ] Test consent flow
