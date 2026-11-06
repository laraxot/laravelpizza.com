---
type: story
title: "STORY-Activity: Audit Log Completo"
links: {github_issue: "#401", discussion: "#402"}
---
# Story Activity Audit Log Completo

## User Job + Success State
Come cittadino o operatore comunale, voglio vedere la cronologia completa di una segnalazione (data creazione, presa in carico, inizio lavori, completamento, verifica) per avere trasparenza sullo stato di avanzamento e garantire accountability.

## Screen Inventory
- **Header**: Logo, menu principale, ricerca
- **Hero section**: Titolo principale, call-to-action primaria
- **Featured content**: Ultimi articoli, segnalazioni attive, KPI in evidenza
- **Sidebar/Secondary**: Link rapidi, categorie
- **Footer**: Navigazione, contatti, link utili

## Token Constraints (from DESIGN.md)
- **Palette**: Accento `forest #1E6B50`, neutri tintati `paper #F6F4EE`, `ink #22302A`
- **Typography**: Testata `Spline Sans 700–800`, corpo `IBM Plex Sans 400/1rem-1.125rem/45-75ch`
- **Spacing**: Griglia 8px, margini coerenti, altezza riga coerente
- **Elevation**: Nominali (sm/md/lg), nessuna shadow inventata

## Required Interaction States
- **Header**: `default`, `hover`, `focus-visible`, `active`, `disabled`
- **Hero CTA**: `default`, `hover`, `focus-visible`, `active`, `disabled`
- **Featured cards**: `default`, `hover`, `focus-visible`, `active`, `disabled`
- **Nav links**: `default`, `hover`, `focus-visible`, `active`, `disabled`

## Reference
Homepage DECORO URBANO — dashboard dati aperti, filtri categoria, KPI temporali.

## Acceptance Criteria
- APCA contrast ≥75 body, ≥45 large-bold
- Tokens ONLY, nessun hardcoded hex fuori `:root`
- Stati interattivi completi con `:focus-visible` + `:disabled`
- Transizione/animazione con `prefers-reduced-motion` fallback
- Nessuna glassmorphism, gradient orb, neon glow, default-card, 1px gray border, tracked-out eyebrow, tinted near-black
