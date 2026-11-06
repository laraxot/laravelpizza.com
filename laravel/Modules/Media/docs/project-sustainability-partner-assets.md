---
title: "Sostenibilità: asset loghi partner"
type: concept
module: Media
status: decision-input
updated: 2026-10-15
tags: [sustainability, media, assets, bmad]
qmd: "asset partner (ownership media) media"
---

# Asset partner (ownership Media)

## Perché questo modulo

I loghi partner sono file media con vincoli di licenza, MIME, dimensione e
accessibilità. Non devono arrivare come HTML/script dallo sponsor.

## Scopo business

Garantire recognition sobria e sicura: asset locali o CDN controllato, alt text
governato a livello contenuto (Cms), revoca = rimozione pubblicazione.

## Regole proposte

1. Solo formati approvati (es. SVG/PNG/WebP) con validazione MIME
2. Nessun SVG con script / foreignObject pericolosi (policy da definire)
3. Dimensioni massime e ratio coerenti col footer (Sixteen)
4. Metadati: partner, licenza, `starts_at`/`ends_at`, reviewed_by
5. Fallback: se logo manca, mostrare nome testuale: non placeholder inventato

## Confini

- Media non decide chi è partner
- Media non scrive disclosure (Cms/copy)
- Media non traccia click verso siti sponsor oltre HTTP referrer naturale

## Collegamenti

- Dossier: [project-sustainability](../../../../../../bmad-output/project-sustainability/README.md)
- Architecture footer: [architecture](../../../../../../bmad-output/footer-sponsorship/architecture.md)
- Cms: [project-sustainability-content.md](../../Cms/docs/project-sustainability-content.md)
