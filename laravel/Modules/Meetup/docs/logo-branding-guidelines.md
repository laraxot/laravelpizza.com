# Logo e Branding Guidelines - Laravel Pizza Meetups

## Overview

Questo documento definisce le linee guida per l'uso del logo e degli elementi di branding per Laravel Pizza Meetups.

## 🍕 Logo Principale

### SVG Originale da laravelpizza.com

Il logo è uno **spicchio di pizza stilizzato** estratto direttamente da `laravelpizza.com`.

```svg
<svg xmlns="http://www.w3.org/2000/svg"
     width="24"
     height="24"
     viewBox="0 0 24 24"
     fill="none"
     stroke="currentColor"
     stroke-width="2"
     stroke-linecap="round"
     stroke-linejoin="round"
     class="h-8 w-8 text-red-500">
  <path d="M15 11h.01"></path>
  <path d="M11 15h.01"></path>
  <path d="M16 16h.01"></path>
  <path d="m2 16 20 6-6-20A20 20 0 0 0 2 16"></path>
  <path d="M5.71 17.11a17.04 17.04 0 0 1 11.4-11.4"></path>
</svg>
```

### Caratteristiche Tecniche

- **ViewBox**: `0 0 24 24` (standard 24x24)
- **Fill**: `none` (solo stroke, nessun riempimento)
- **Stroke**: `currentColor` (eredita colore dal parent)
- **Stroke Width**: `2`
- **Stroke Linecap**: `round`
- **Stroke Linejoin**: `round`

### Dimensioni Standard

- **Navigation**: `h-8 w-8` (32px × 32px)
- **Hero Section**: `h-24 w-24` (96px × 96px)
- **Footer**: `h-8 w-8` (32px × 32px)
- **Favicon**: `16x16` o `32x32`

### Colori

- **Primary**: `text-red-600` (#dc2626)
- **Hover**: `text-red-500` (#ef4444)
- **Dark Background**: `text-white` (quando su sfondo scuro)

### Uso Corretto

#### ✅ DO
- Usare sempre l'SVG originale estratto da laravelpizza.com
- Mantenere proporzioni originali
- Usare `currentColor` per il colore stroke
- Aggiungere `aria-hidden="true"` quando il logo è decorativo
- Mantenere viewBox `0 0 24 24`

#### ❌ DON'T
- Non modificare i path dell'SVG
- Non cambiare il viewBox
- Non usare fill invece di stroke
- Non creare versioni alternative senza validazione
- Non usare immagini raster (PNG/JPG) quando possibile

## 📐 Implementazione

### Navigation Bar

```html
<a href="/" class="flex items-center space-x-3">
    <svg xmlns="http://www.w3.org/2000/svg"
         width="24"
         height="24"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round"
         class="h-8 w-8 text-red-500"
         aria-hidden="true">
        <path d="M15 11h.01"></path>
        <path d="M11 15h.01"></path>
        <path d="M16 16h.01"></path>
        <path d="m2 16 20 6-6-20A20 20 0 0 0 2 16"></path>
        <path d="M5.71 17.11a17.04 17.04 0 0 1 11.4-11.4"></path>
    </svg>
    <span class="text-xl font-bold text-white">Laravel Pizza Meetups</span>
</a>
```

### Hero Section

```html
<div class="flex justify-center mb-8">
    <svg xmlns="http://www.w3.org/2000/svg"
         width="24"
         height="24"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round"
         class="h-24 w-24 text-red-500">
        <path d="M15 11h.01"></path>
        <path d="M11 15h.01"></path>
        <path d="M16 16h.01"></path>
        <path d="m2 16 20 6-6-20A20 20 0 0 0 2 16"></path>
        <path d="M5.71 17.11a17.04 17.04 0 0 1 11.4-11.4"></path>
    </svg>
</div>
```

## 🔍 Analisi Path SVG

### Path 1-3: Topping Points
```svg
<path d="M15 11h.01"></path>
<path d="M11 15h.01"></path>
<path d="M16 16h.01"></path>
```
Piccoli punti che rappresentano topping sulla pizza (peperoni, olive, etc.)

### Path 4: Forma Principale Spicchio
```svg
<path d="m2 16 20 6-6-20A20 20 0 0 0 2 16"></path>
```
Definisce la forma principale dello spicchio di pizza con:
- Bordo curvo esterno (crosta)
- Bordo interno dritto (taglio)
- Arco di 20 unità

### Path 5: Dettaglio Interno
```svg
<path d="M5.71 17.11a17.04 17.04 0 0 1 11.4-11.4"></path>
```
Aggiunge dettaglio interno per dare profondità allo spicchio

## 🎨 Varianti Colore

### Su Sfondo Scuro (Default)
```html
class="h-8 w-8 text-red-500"
```

### Su Sfondo Chiaro
```html
class="h-8 w-8 text-red-600"
```

### Hover State
```html
class="h-8 w-8 text-red-500 group-hover:text-red-400 transition-colors"
```

## 📱 Responsive

Il logo si adatta automaticamente alle dimensioni del container:

- **Mobile**: `h-6 w-6` (24px)
- **Tablet**: `h-8 w-8` (32px)
- **Desktop**: `h-8 w-8` (32px) o `h-10 w-10` (40px) per hero

## 🔗 Riferimenti

- **Sito Originale**: https://laravelpizza.com
- **File Componente**: `laravel/Themes/Meetup/resources/html/components/navigation.html`
- **Documentazione Errore**: [Logo Implementation Error](../Themes/Meetup/docs/logo-implementation-error.md)
- **Design System**: [DESIGN-SYSTEM.md](./DESIGN-SYSTEM.md)

## ✅ Checklist Implementazione

- [x] SVG estratto correttamente da laravelpizza.com
- [x] Path analizzati e documentati
- [x] Dimensioni standard definite
- [x] Colori standardizzati
- [x] Varianti responsive implementate
- [x] Accessibilità verificata (`aria-hidden`)
- [x] Documentazione completa

## 🎯 Best Practices

1. **Sempre usare l'SVG originale** - Non creare versioni alternative
2. **Mantenere proporzioni** - Non distorcere il logo
3. **Usare currentColor** - Per flessibilità di colore
4. **Accessibilità** - Aggiungere `aria-hidden="true"` quando decorativo
5. **Performance** - SVG inline è preferibile a immagini esterne
