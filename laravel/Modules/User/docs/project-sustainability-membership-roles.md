---
title: "Sostenibilità: ruoli e membership"
type: concept
module: User
status: decision-input
updated: 2026-10-15
tags: [sustainability, user, rbac, bmad]
qmd: "ruoli e membership (ownership user) user"
---

# Ruoli e membership (ownership User)

## Perché questo modulo

User possiede autenticazione e RBAC. Qualsiasi approvazione editoriale di partner
o futura **membership ente** passa da ruoli e permessi, non da config Blade.

## Scopo business

1. **Oggi (discovery):** chi può approvare pubblicazione partner/CTA sul tenant
   (es. admin/supervisor): da formalizzare in policy, non ancora in codice.
2. **Domani (P2):** membership B2G/associazione: account ente con rinnovo, non
   paywall cittadino.

## Principi

- Il cittadino non compra «priorità» sulle segnalazioni
- Membership ≠ advertising
- Permessi di pubblicazione partner separati da permessi ticket operativi
- Nessun ruolo «sponsor» nel FO finché Epic A governance non chiude

## Confini

- User non gestisce pagamenti (futuro: gateway fuori da questo modulo o dedicati)
- User non ospita loghi (Media)
- User non scrive copy (Cms)

## Collegamenti

- Dossier: [project-sustainability](../../../../../../bmad-output/project-sustainability/README.md)
- Recommendation: [recommendation](../../../../../../bmad-output/project-sustainability/recommendation.md)
- Gdpr: [project-sustainability-privacy.md](../../Gdpr/docs/project-sustainability-privacy.md)
