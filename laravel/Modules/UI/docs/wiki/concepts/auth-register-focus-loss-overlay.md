---
title: "Auth register focus loss caused by mobile header overlay"
type: concept
tags: [ui, auth, register, focus, overlay, alpine]
created: 2026-05-21
updated: 2026-05-21
---

# Problema

Su `/it/auth/register` gli input perdevano il focus al click e diventavano non usabili.

# Root cause

Nel componente `Modules/UI/resources/views/components/ui/marketing/header.blade.php` il menu mobile era un container `fixed` fullscreen (`w-full h-full min-h-screen`) con `z-index` alto.
Quando chiuso, in alcune condizioni continuava a intercettare i click sopra il form auth.

# Fix applicato

- sostituita la sola logica `hidden/flex` con `x-show="mobileMenuOpen"` (+ `style="display:none"` iniziale)
- aggiunta gestione esplicita `pointer-events`:
  - `pointer-events-none` quando chiuso
  - `pointer-events-auto` quando aperto
  - desktop sempre `md:pointer-events-auto` con `md:flex`

# Esito

Form registrazione nuovamente usabile: passaggio focus tra input e digitazione corretti.

