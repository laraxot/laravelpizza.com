# Dashboard Page Design - Laravel Pizza Meetups

## Data: 2025-01-27

## 🎯 Overview

Questo documento descrive il design e l'implementazione della pagina dashboard per Laravel Pizza Meetups, basato sul design di laravelpizza.com/dashboard.

## 📊 Struttura Dashboard

### Layout Generale
- **Background**: Dark theme (slate-900)
- **Navigation**: Sticky top con logo, links, user menu, logout
- **Main Content**: Grid layout con sezioni principali e sidebar
- **Footer**: Dark con links

### Sezioni Principali

#### 1. Navigation Bar
- Logo pizza + "Laravel Pizza Meetups"
- Links: Events, Community Chat, English (dropdown), Dashboard
- User menu: "marco xot" (con icona persona)
- Logout button (con icona freccia)

#### 2. Welcome Section
- **Heading**: "Welcome back, marco xot!" (grande, bianco)
- **Subtitle**: "Here's what's happening in your Laravel community" (grigio chiaro)

#### 3. Statistics Cards (4 cards in row)
Ogni card ha:
- Icona bianca (calendario, persone, chat, pizza)
- Numero grande (bianco, bold)
- Label (grigio chiaro)
- Background: slate-800 con border slate-700

**Cards:**
1. **Events Attended**: 12 (icona calendario)
2. **Community Members**: 248 (icona persone)
3. **Messages Sent**: 156 (icona chat)
4. **Pizza Slices**: 47 (icona pizza)

#### 4. Your Upcoming Events Section
- **Title**: "Your Upcoming Events" (bianco, bold)
- **Button**: "View All" (rosso, top-right)
- **Event Cards**: 3 eventi, ognuno con:
  - Thumbnail image (quadrato scuro)
  - Titolo evento (bianco, bold)
  - Data/ora (grigio, con icona calendario)
  - Location (grigio, con icona location)
  - Badge "Registered" (verde, rounded)

**Eventi esempio:**
1. Laravel 11 Release Pizza Party - Dec 15, 2025 • 6:00 PM - 9:00 PM - Tech Hub Downtown
2. Filament Admin Panel Workshop - Dec 22, 2025 • 5:30 PM - 8:30 PM - Innovation Center
3. Livewire 3 Pizza Meetup - Jan 5, 2026 • 6:30 PM - 9:00 PM - Startup Lounge

#### 5. Right Sidebar

**Quick Actions:**
- Title: "Quick Actions"
- 3 items:
  - Browse Events (rosso, con icona calendario)
  - Community Chat (grigio scuro, con icona chat)
  - Edit Profile (grigio scuro, con icona persona)

**Community Tip:**
- Title: "Community Tip"
- Background: rosso-marrone (red-900 o simile)
- Text: "Don't forget to introduce yourself in the chat before your first meetup!"

## 🎨 Colori e Stili

### Background
- Main: `bg-slate-900`
- Cards: `bg-slate-800` con `border-slate-700`
- Sidebar items: `bg-slate-800`

### Text
- Headings: `text-white`
- Body: `text-gray-300` o `text-gray-400`
- Labels: `text-gray-400`

### Accents
- Primary buttons: `bg-red-600 hover:bg-red-700`
- Badge "Registered": `bg-green-600 text-white`
- Active sidebar item: `bg-red-600` o `text-red-500`

### Community Tip
- Background: `bg-red-900/30` o `bg-amber-900/30`
- Text: `text-white` o `text-amber-100`

## 📐 Layout Grid

```
┌─────────────────────────────────────────────────────────┐
│ Navigation (full width, sticky)                         │
├─────────────────────────────────────────────────────────┤
│ Welcome Section (full width)                            │
├─────────────────────────────────────────────────────────┤
│ Statistics (4 columns grid)                              │
├──────────────────────────────┬──────────────────────────┤
│                              │                          │
│ Your Upcoming Events         │ Quick Actions            │
│ (2/3 width)                  │ Community Tip            │
│                              │ (1/3 width)              │
│                              │                          │
└──────────────────────────────┴──────────────────────────┘
│ Footer (full width)                                      │
└─────────────────────────────────────────────────────────┘
```

## 🔧 Componenti da Implementare

### Statistics Card Component
```html
<div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-400 text-sm mb-1">Label</p>
            <p class="text-3xl font-bold text-white">Number</p>
        </div>
        <svg class="w-8 h-8 text-white">...</svg>
    </div>
</div>
```

### Event Card Component
```html
<div class="bg-slate-800 border border-slate-700 rounded-lg p-4 flex gap-4">
    <img src="..." class="w-20 h-20 rounded object-cover" />
    <div class="flex-1">
        <h3 class="text-white font-bold mb-2">Event Title</h3>
        <div class="space-y-1 text-sm text-gray-400">
            <div class="flex items-center">
                <svg>...</svg>
                <span>Date • Time</span>
            </div>
            <div class="flex items-center">
                <svg>...</svg>
                <span>Location</span>
            </div>
        </div>
    </div>
    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
        Registered
    </span>
</div>
```

### Quick Actions Item
```html
<a href="..." class="flex items-center gap-3 p-4 bg-slate-800 rounded-lg hover:bg-slate-700 transition-colors">
    <svg class="w-5 h-5 text-white">...</svg>
    <span class="text-white font-medium">Action Name</span>
</a>
```

## 📋 Checklist Implementazione

- [ ] Navigation con user menu e logout
- [ ] Welcome section con nome utente
- [ ] 4 Statistics cards
- [ ] Your Upcoming Events section
- [ ] 3 Event cards con badge "Registered"
- [ ] Right sidebar con Quick Actions
- [ ] Community Tip box
- [ ] Footer allineato
- [ ] Responsive design
- [ ] Dark theme completo

## 🔗 Riferimenti

- **Sito originale**: https://laravelpizza.com/dashboard
- **File da creare**: `laravel/Themes/Meetup/resources/html/dashboard.html`
- **Documenti correlati**:
  - [Register Page Design](./register-page-design-error.md)
  - [Design Analysis](./laravelpizza-com-design-analysis.md)

