---
title: "Fix ricerca 404 — Folio page placement"
type: concept
status: active
tags: [search, folio, fix, error-doc]
created: 2026-10-26
updated: 2026-10-26
---

# Errore trovato con Playwright (200 OK, 2026-10-26)

`/it/ricerca?q=test` → **404 Not Found**.

Causa: il file Folio crea `pages/[container0]/ricerca/index.blade.php` ma il form invia `/it/ricerca` (route diretta senza container0/slug0). Folio non matcha.

Fix: spostato a `pages/ricerca.blade.php` (route diretta, locale `it`).

Prevenzione: quando si crea una pagina Folio per una rotta fissa, verificare che il percorso del form sia coerente con il path del file Folio.
