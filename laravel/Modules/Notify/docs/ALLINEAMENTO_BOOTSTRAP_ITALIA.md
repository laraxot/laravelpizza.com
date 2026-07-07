# 🎯 Allineamento HTML con Bootstrap Italia

## Problema
I componenti blade usano classi Tailwind ma Bootstrap Italia richiede classi specifiche.

## Soluzione
Creare componenti compatibili Bootstrap Italia.

---

## Componenti da Fixare

### 1. Hero Homepage

**Attuale (Tailwind):**
```blade
<section id="head-section" class="bg-white">
  <div class="container mx-auto px-4">
    <div class="flex flex-col-reverse lg:flex-row">
```

**Bootstrap Italia:**
```blade
<section class="hero-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
```

### 2. Governance Cards

**Attuale (Tailwind):**
```blade
<div class="bg-gray-50 py-8">
  <div class="max-w-6xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
```

**Bootstrap Italia:**
```blade
<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="card card-teaser">
```

### 3. Events Calendar

**Attuale (Tailwind):**
```blade
<section class="bg-white py-10">
  <div class="hidden md:flex gap-4 overflow-x-auto">
```

**Bootstrap Italia:**
```blade
<section class="py-5">
  <div class="calendar-list">
    <div class="calendar-event">
      <span class="calendar-date">15 LUN</span>
```

---

## Piano d'Azione

### Fase 1: Mappatura Classi

| Tailwind | Bootstrap Italia |
|----------|------------------|
| `bg-white` | `card-bg` |
| `bg-gray-50` | `bg-light` |
| `text-blue-700` | `text-primary` |
| `container mx-auto` | `container` |
| `grid grid-cols-3` | `row g-4` |
| `col-lg-4` | `col-lg-4` |

### Fase 2: Fix Componenti

1. `components/blocks/hero/homepage.blade.php`
2. `components/blocks/governance/cards.blade.php`
3. `components/blocks/events/calendar.blade.php`
4. `components/blocks/topics/highlight.blade.php`

### Fase 3: Testing

```bash
curl http://fixcity.local/it/tests/homepage | grep -o '<section[^>]*>' | head -10
```

---

## Stato

- [x] Analisi completata
- [ ] Componenti fixati
- [ ] Testing eseguito
- [ ] Documentazione aggiornata
