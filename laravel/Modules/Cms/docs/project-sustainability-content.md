---
title: "Sostenibilità — contenuto CMS (pagine e sezioni)"
type: concept
module: Cms
status: decision-input
updated: 2026-10-15
tags: [sustainability, cms, content, bmad]
qmd: "contenuto di sostenibilità (ownership cms) cms"
---

# Contenuto di sostenibilità (ownership Cms)

## Perché questo modulo

Cms serve pagine e sezioni JSON per tenant (`SushiToJsons`). Qualsiasi
comunicazione «come sostenere / chi ci sostiene» è **contenuto editoriale**, non
logica Blade.

## Scopo business

Tenere in un solo posto (JSON tenant) la narrazione sostenibile: pagina dedicata
e eventuale blocco partner nel footer — senza inventare URL o copy nel tema.

## Superfici proposte (post-GO)

1. **Pagina** `sostieni` (o `collabora`) in `content/pages/` — modello economico,
   uso fondi, contatti, CTA; niente pagamento live finché governance manca.
2. **Sezione footer** — eventuale `support` / partner (vedi
   [footer-sponsorship tech-spec](../../../../../../bmad-output/footer-sponsorship/tech-spec.md)).
3. **Niente** HTML sponsor inline; solo riferimenti a asset Media.

## Outline pagina `/sostieni` (bozza editoriale)

1. Perché esiste FixCity (missione)
2. Impatto aggregato (da Fixcity KPI)
3. Come si finanzia oggi (B2G / grant / partner — testo onesto)
4. Come un Comune adotta o co-finanzia
5. Come un partner collabora (link policy)
6. Donazioni — solo se beneficiario definito; altrimenti «in preparazione»
7. Contatti e trasparenza

## Confini

- Cms non calcola KPI ticket
- Cms non approva contratti
- Filament Page/Section = editing; policy di pubblicazione resta umana

## Collegamenti

- Dossier: [project-sustainability](../../../../../../bmad-output/project-sustainability/README.md)
- Footer marketing: [footer-sponsorship](../../../../../../bmad-output/footer-sponsorship/README.md)
- Tenant opt-in: [project-sustainability-tenant-governance.md](../../Tenant/docs/project-sustainability-tenant-governance.md)
- Sixteen: [project-sustainability-front-office.md](../../../Themes/Sixteen/docs/project-sustainability-front-office.md)
- README Cms: [README.md](./README.md)
