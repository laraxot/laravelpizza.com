---
qmd: "media bmad readme md"
bmad_id: MEDIA-readme
domain: media-module
version: 1.0.0
status: active
tags: [media, docs]
created: 2026-10-06
updated: 2026-10-06
---

# Modulo Media — Documentazione Bridge

Documentazione canonica per il modulo Media: gestione multimediale (immagini, video, documenti, audio) in Laraxot.

## File Canonici

1. **[README.md](README.md)** — questo file, punto di ingresso
2. **[architecture.md](architecture.md)** — architettura, namespace, dipendenze, struttura, funzionalità
3. **[index.md](index.md)** — bridge per discovery (legacy)

## Scopo Modulo

- Memorizzazione, elaborazione, distribuzione file multimediali
- Supporto multi-format (immagini, video, documenti, audio)
- Integrazione CDN e streaming video
- Isolamento tenant
- Conversione automatica (FFmpeg, immagini)

## Linkage

- Dipende da: Xot (base), Tenant, User, UI
- Utilizzato da: temi e moduli applicativi
- Standard di documentazione: vedi `/docs/` root

Per dettagli architetturali, vedi **architecture.md**.
