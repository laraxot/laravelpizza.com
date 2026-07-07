# FixCity Hero Marketing Section - Design Spec

## Overview
Aggiungere una Hero Section cinematica alla homepage di FixCity per migliorare l'impatto visivo e aumentare le conversioni.

## Componenti

### 1. Hero Component
- **File**: `resources/views/components/ui/hero.blade.php`
- **Background**: Gradient `from-slate-950 via-slate-900 to-emerald-950/20`
- **Particles**: 80 particles using existing `<x-ui.cinematic-particles>` component

### 2. Headline
- Testo principale: "Segnala i problemi della tua città"
- Animazione: fade-in + slide-up con GSAP
- Gradiente testo: `text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400`

### 3. Stats Counter
- 3 metriche: Segnalazioni totali, Comuni coperti, Cittadini attivi
- Animazione numeri con GSAP ScrollTrigger
- Icone Heroicons

### 4. CTA Button
- Pulsante principale: "Nuova Segnalazione"
- Stile: Emerald con hover effect
- Link a rotta segnalazione

## Layout
```
┌─────────────────────────────────────┐
│         HERO SECTION               │
│  ┌─────────────────────────────┐   │
│  │ 🎯 Headline animata         │   │
│  │ "Segnala i problemi..."    │   │
│  └─────────────────────────────┘   │
│                                     │
│  ┌─────┐ ┌─────┐ ┌─────┐          │
│  │ 1K+ │ │ 50+ │ │ 500+│          │
│  │Segn │ │Com  │ │Citt │          │
│  └─────┘ └─────┘ └─────┘          │
│                                     │
│  [➕ Nuova Segnalazione]           │
└─────────────────────────────────────┘
```

## Animazioni GSAP
```javascript
// Hero entrance
gsap.from('.hero-headline', {
  opacity: 0,
  y: 50,
  duration: 1.5,
  ease: 'power3.out'
});

// Stats counter
gsap.to('.stat-number', {
  innerText: targetValue,
  duration: 2,
  snap: { innerText: 1 },
  scrollTrigger: { trigger: '.stats-section', start: 'top 80%' }
});
```

## Accessibilità
- `prefers-reduced-motion`: disabilita animazioni
- Semantic HTML: `<section>`, `<h1>`, `<p>`
- Focus visible sui link
- Contrast ratio > 4.5:1

## File da Modificare
1. `laravel/Themes/Sixteen/resources/views/home.blade.php` - Aggiungere hero sopra content
2. `laravel/Themes/Sixteen/resources/views/components/ui/hero.blade.php` - Creare/aggiornare componente
3. `laravel/Themes/Sixteen/resources/js/app.js` - Aggiungere GSAP animations

## Success Criteria
- Lighthouse Performance > 80
- FCP < 2s
- Bounce rate ridotto del 10%
