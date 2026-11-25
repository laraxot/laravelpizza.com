---
title: "Topic auth-pages"
type: digest
status: active
qmd: "digest ceiling 100 auth-pages"
---

# Topic auth-pages

Sintesi automatica di 3 documenti (chiave `auth-pages`).

## Auth Pages - UI/UX Guidelines

_Fonte: `auth-pages-design.md`_

# Auth Pages - UI/UX Guidelines

## Overview

This document describes the design patterns and best practices for authentication pages (login, register, password reset) in the Meetup theme.

## Password dimenticata / nuova password (versione del progetto)

`pages/auth/password/reset.blade.php` (`password.request`) e `pages/auth/password/[token].blade.php` (`password.reset`) usano
`<x-ui.auth-card>` + `<x-ui.auth-field>`, `middleware(['guest', 'throttle:6,1'])`, la stessa risposta se l'email esiste o no
(nessuna enumerazione) e, dopo il reset, entrano subito nell'area personale (`xra.post_login_path`). I testi stanno in
`lang/{it,en,de,es,...}/auth.php` sotto `password.request.*`, `password.reset.*`, `password.confirm.*`, `verify.*`.
Una sincronizzazione con il tema generico li aveva sostituiti con pagine senza `<h1>` e senza quei testi
(`FrontOfficePrivacyAndSeoTest`: "forgot password"): ripristinate le pagine del progetto e riunite le chiavi di lingua
(chiavi del tema generico mantenute, valori del progetto vincenti).

## URL Structure

All auth pages must be under `/auth/` prefix:

- Login: `/it/auth/login` or `/en/auth/login`
- Register: `/it/auth/register` or `/en/auth/register`
- Password Reset: `/it/auth/password/reset` or `/en/auth/password/reset`

## UI/UX Best Practices

### Visual Design

1. **Split Layout**: Image/branding on one side, form on the other
2. **Clear Typography**: Large headings, readable body text

## SEO Guidelines for Auth Pages

_Fonte: `auth-pages-seo.md`_

# SEO Guidelines for Auth Pages

## Meta Tags

Every auth page must have unique meta tags:

```blade
<x-layouts.app>
    <x-slot name="title">
        {{ __('gdpr::register.title') }} - LaravelPizza
    </x-slot>

    <x-slot name="description">
        {{ __('gdpr::register.subtitle') }}
    </x-slot>
</x-layouts.app>
```

## Requirements

### Title
- Unique per page
- Include brand name
- Max 60 characters

### Description
- Unique per page
- Include primary keyword
- Max 160 characters

## Auth Pages UI/UX Guidelines

_Fonte: `auth-pages-uiux.md`_

# Auth Pages UI/UX Guidelines

## Overview

This document defines the design standards for authentication pages (login, register, password reset).

## Layout Principles

### Mobile-First
- Form always full-width on mobile/tablet
- Side-by-side layout only on desktop (>1024px)
- Touch targets minimum 44×44px

### Responsive Breakpoints
```css
/* Mobile: 0-639px */
.sm: /* 640px+ */
.md: /* 768px+ */
.lg: /* 1024px+ */
.xl: /* 1280px+ */
```

## Color Palette

| Purpose | Color | Usage |
|---------|-------|-------|
| Primary | red-500/red-600 | CTAs, accents |
| Background | slate-900/slate-800 | Dark mode |
| Surface | slate-800/white | Cards, forms |
| Text | white/slate-300 | Content |
