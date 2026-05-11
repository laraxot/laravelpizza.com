---
title: "BMad Method in Geo Module"
type: concept
sources:
  - "https://docs.bmad-method.org/"
  - "https://github.com/salacoste/antigravity-bmad-config"
confidence: high
created: 2026-04-22
tags: [bmad, geo, workflow, antigravity]
---

# BMad Method in Geo Module

Il modulo **Geo** utilizza il **BMad Method** (Build More Architect Dreams) per coordinare lo sviluppo dei componenti geografici complessi.

## 🤖 Antigravity Integration

In questo progetto, l'agente **Antigravity** è configurato per supportare i ruoli BMAD tramite i seguenti slash commands:

- `/bmad:pm` — Avvia la discovery dei requisiti per nuove feature geografiche.
- `/bmad:architect` — Definisce l'architettura tecnica (es. integrazione Leaflet/Tit).
- `/bmad:dev` — Esegue l'implementazione storia per storia (es. refactor di `CoordinatePicker`).
- `/bmad:qa` — Verifica la qualità e i casi limite (es. rendering mappe in wizard).

## 🏛️ Architecture: Body and Mind

Seguendo il pattern BMAD/BMB, i componenti Geo sono divisi in:

1.  **Body (The Stateless UI)**: Lit-based Web Components (es. `coordinate-picker-lit.js`) che gestiscono solo il rendering (Leaflet) e gli eventi.
2.  **Mind (The State Controller)**: Livewire/Blade che gestisce la persistenza, la geocodifica server-side e il coordinamento con il database.

## 📝 Workflow Operativo

Per ogni modifica al modulo Geo:
1. **Analisi**: Verificare l'impatto sui componenti esistenti.
2. **Implementazione**: Usare `/bmad:dev` per mantenere la coerenza con il "Golden Standard" (Light DOM, Guard directives).
3. **Validazione**: Usare `/bmad:qa` per testare la stabilità in contesti dinamici (wizard, fullscreen).

## 🔗 Collegamenti
- [[bmad-method]]: Guida generale al metodo BMAD
- [[geo-components]]: Panoramica dei componenti geografici
- [[standardized-geo-architecture]]: ADR sull'architettura Geo standardizzata
