---
type: taste-skill-config
title: "Taste-Skill Config — CMS Homepage"
description: "Config taste-skill dials per homepage redesign. Reads DESIGN.md tokens."
links: {github_issue: #500, taste-skill-repo: leonxlnx/taste-skill}
---
# Taste-Skill Config — CMS Homepage

## Design Read (before anything)
Homepage = landing page / redesign (preserve brand, modernize). Direction: editorial / ledger / exp. material (DESIGN.md tokens `forest #1E6B50` + `paper #F6F4EE`).

## Three Dials (per taste-skill Section 1)
- DESIGN_VARIANCE: 7 (moderate asymmetry, editorial grid)
- MOTION_INTENSITY: 3 (subtle hover/focus, reduced-motion fallback)
- VISUAL_DENSITY: 5 (medium — KPI + featured, not cockpit)

## Anti-Features (banned — per taste-skill v2 / UX discipline)
- NO glassmorphism (`backdrop-filter`)
- NO gradient orbs / purple glow
- NO neon-on-dark
- NO default-card (`rounded-2xl shadow-lg` untouched)
- NO 1px gray border (`border-zinc`/`gray` default)
- NO tracked-out eyebrow (ALL-CAPS meta dots)
- NO tinted near-black (`#0B0B0B` / `#111` for black)
- NO permanent dark-mode reflex

## Stack
- Tailwind v4 (preferred per taste-skill 3.A; existing project uses v3 → keep v3 compatibility, no breaking change)
- Motion (framer-motion legacy alias) only for one orchestrated reveal — not scattered
- Fonts: `next/font` equivalent (self-hosted via `assets/fonts/` in `public_html/`)

## Preflight (Section 14) — must pass before output
- [ ] Design Read declared (one line)
- [ ] Brief 5 fields produced (job / inventory / tokens / states / reference)
- [ ] Dials set (7/3/5)
- [ ] Token mapping ≥ 8/10 components
- [ ] APCA contrast ≥75 body / ≥45 large-bold verified
- [ ] States: default + hover + focus-visible + active + disabled
- [ ] prefers-reduced-motion fallback present
- [ ] Zero slop tells (glassmorphism, gradient orbs, neon glow, default-card, 1px gray, tracked eyebrow, tinted near-black)
- [ ] No unrequested abstraction (factory/interface with 1 impl)

## Evidence
- `taste-skill` v2 installed at `.pi/skills/taste-skill/skills/SKILL.md` (1206 lines, indexed)
- Source: https://github.com/leonxlnx/taste-skill (fetched + indexed)
- Local registry: `.pi/skills/taste-skill/skills/` (SKILL.md + examples)

## Improvement to Homepage (from audit findings)
- Apply `DESIGN_VARIANCE: 7` layout (editorial / slightly asymmetric) instead of centered-default
- Apply `VISUAL_DENSITY: 5` content budget (KPI + featured sections, not sparse gallery)
- Use `forest` accent for CTAs / badges, `paper` background, `ink` text
- One signature element: oversized index numeral / glyph from Italian subject's writing (e.g., `§` or `N°`) at reduced opacity
- Punctuation kit: 2–3 deliberate marks (accent terminal, stamp badge, index numeral)
