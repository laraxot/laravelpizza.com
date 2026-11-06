---
name: "Cookiebar Bootstrap Italia Integration"
title: "Integrate Bootstrap Italia Cookiebar into Gdpr Module"
description: "Integrate the Bootstrap Italia cookiebar component into the Gdpr module, ensuring GDPR compliance with consent management and cookie preferences.

## Goals
- Integrate Bootstrap Italia's cookiebar component into the existing Gdpr module
- Maintain GDPR compliance (consent management, opt-in/opt-out)
- Use TailwindCSS + Alpine.js + Lit + DaisyUI + Flowbite (no Bootstrap)
- Follow BMAD framework for documentation

## Acceptance Criteria
- [ ] Cookiebar component is properly integrated into the Gdpr module
- [ ] Consent management (Accept/Reject) works with Alpine.js
- [ ] Link to cookie preferences page is functional
- [ ] Component follows Tailwind + DaisyUI + Flowbite styling
- [ ] Second Brain (kp-*) entry created for this integration
- [ ] Story added to BMAD docs

## Implementation Notes
- Bootstrap Italia cookiebar uses `section.cookiebar` with `data-bs-accept="cookiebar"`
- Must be placed after `<body>` tag
- Preference link points to `/bootstrap-italia/docs/esempi/cookiebar/` example
- No Bootstrap CSS — use Tailwind + DaisyUI + Flowbite instead
- Alpine.js handles the accept button behavior
- GDPR consent flow must align with existing Gdpr module consent mechanisms

## Related
- spatie/laravel-cookie-consent
- statikbe/laravel-cookie-consent
- Bootstrap Italia cookiebar docs
- Gdpr module: cookiebar-integration.md, cookie-consent.md

## Owner
- Gdpr Module Team
- BMAD: [your name]
- Second Brain: kp-xxx

## Nota di verifica del 2026-10-14 (aggiunta, righe sopra non toccate)
Questa story e' stata superata da [DCP-153](./dcp-153-cookiebar-integrata-nel-modulo-gdpr.story.md). Nessuno dei criteri di accettazione era spuntato; l'integrazione e' stata fatta nel modulo Gdpr con `statikbe/laravel-cookie-consent` (middleware e chiave del cookie) e una vista propria, senza Bootstrap, con il contratto di markup di Bootstrap Italia. Lo `status` del frontmatter non e' stato modificato (la story e' di un'altra sessione): vale `superseded`.
