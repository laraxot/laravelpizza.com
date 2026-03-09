# Profile Page Design - Laravel Pizza Meetups

## Data: [DATE]

## 🎯 Overview

Questo documento descrive il design e l'implementazione della pagina profilo utente per Laravel Pizza Meetups, basato sul design di laravelpizza.com/profile.

## 📊 Struttura Profile Page

### Layout Generale
- **Background**: Dark theme (slate-900)
- **Navigation**: Sticky top con logo, links, user menu, logout (come dashboard)
- **Cover Banner**: Grande area rossa in alto
- **Profile Picture**: Immagine circolare che si sovrappone al banner in basso a sinistra
- **Main Content**: Grid layout con sezioni principali
- **Footer**: Dark con links

### Sezioni Principali

#### 1. Navigation Bar
- Logo pizza + "Laravel Pizza Meetups"
- Links: Events, Community Chat, English (dropdown), Dashboard
- User menu: "marco xot" (con icona persona)
- Logout button (con icona freccia)

#### 2. Cover/Banner Section
- **Background**: Rosso (`bg-red-600` o simile)
- **Height**: Grande, circa 200-250px
- **Position**: Relativo per permettere overlap della profile picture

#### 3. Profile Picture
- **Position**: Assoluto, sovrapposto al banner in basso a sinistra
- **Size**: Circolare, grande (circa 120-150px)
- **Border**: Bordo bianco o scuro per contrasto
- **Image**: Foto utente (placeholder se non disponibile)

#### 4. User Details Section
- **Name**: "marco xot" (grande, bold, bianco)
- **Email**: "marco.sottana@gmail.com" (grigio chiaro, con icona envelope)
- **Edit Profile Button**: Rosso, a destra del nome/email, con icona matita

#### 5. Profile Statistics (2 cards side-by-side)
Ogni card ha:
- Icona (calendario o persona)
- Label (grigio chiaro)
- Value (bianco, bold)
- Background: slate-800 con border slate-700

**Cards:**
1. **Member Since**: [DATE] (icona calendario)
2. **Events Attended**: 12 Events (icona persona)

#### 6. Bio Section
- **Title**: "Bio" (bianco, bold)
- **Content**: "New Laravel community member" (grigio chiaro)

#### 7. Interests Section
- **Title**: "Interests" (bianco, bold)
- **Tags**: Pill-shaped tags rossi
- **Example**: "Laravel" (tag rosso)

## 🎨 Colori e Stili

### Background
- Main: `bg-slate-900`
- Cover Banner: `bg-red-600` o `bg-red-700`
- Cards: `bg-slate-800` con `border-slate-700`

### Text
- Headings: `text-white`
- Body: `text-gray-300` o `text-gray-400`
- Labels: `text-gray-400`

### Accents
- Primary buttons: `bg-red-600 hover:bg-red-700`
- Tags/Interests: `bg-red-600 text-white`

### Profile Picture
- Border: `border-4 border-slate-900` (per contrasto con banner rosso)
- Size: `w-32 h-32` o `w-36 h-36` (circolare)

## 📐 Layout Structure

```
┌─────────────────────────────────────────────────────────┐
│ Navigation (full width, sticky)                         │
├─────────────────────────────────────────────────────────┤
│ Cover Banner (rosso, full width, ~200-250px)            │
│   └─ Profile Picture (circolare, sovrapposto bottom-left)│
├─────────────────────────────────────────────────────────┤
│ User Details (con Edit Profile button)                   │
├─────────────────────────────────────────────────────────┤
│ Statistics (2 cards side-by-side)                        │
├─────────────────────────────────────────────────────────┤
│ Bio Section                                              │
├─────────────────────────────────────────────────────────┤
│ Interests Section (con tags)                            │
└─────────────────────────────────────────────────────────┘
│ Footer (full width)                                      │
└─────────────────────────────────────────────────────────┘
```

## 🔧 Componenti da Implementare

### Cover Banner Component
```html
<div class="relative bg-red-600 h-64">
    <!-- Profile Picture sovrapposto -->
    <div class="absolute bottom-0 left-8 transform translate-y-1/2">
        <img src="..." class="w-32 h-32 rounded-full border-4 border-slate-900" />
    </div>
</div>
```

### User Details Component
```html
<div class="pt-20 px-8 pb-6">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">marco xot</h1>
            <div class="flex items-center text-gray-400">
                <svg>...</svg>
                <span>marco.sottana@gmail.com</span>
            </div>
        </div>
        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center">
            <svg>...</svg>
            Edit Profile
        </button>
    </div>
</div>
```

### Statistics Card Component
```html
<div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
    <div class="flex items-center">
        <svg class="w-6 h-6 text-white mr-3">...</svg>
        <div>
            <p class="text-gray-400 text-sm">Label</p>
            <p class="text-xl font-bold text-white">Value</p>
        </div>
    </div>
</div>
```

### Interest Tag Component
```html
<span class="bg-red-600 text-white px-4 py-2 rounded-full text-sm font-medium">
    Laravel
</span>
```

## 📋 Checklist Implementazione

- [ ] Navigation con user menu e logout
- [ ] Cover banner rosso
- [ ] Profile picture circolare sovrapposta
- [ ] User details con nome, email, Edit Profile button
- [ ] 2 Statistics cards (Member Since, Events Attended)
- [ ] Bio section
- [ ] Interests section con tags
- [ ] Footer allineato
- [ ] Responsive design
- [ ] Dark theme completo

## 🔗 Riferimenti

- **Sito originale**: https://laravelpizza.com/profile
- **File da creare**: `laravel/Themes/Meetup/resources/html/profile.html`
- **Documenti correlati**:
  - [Dashboard Page Design](./dashboard-page-design.md)
  - [Register Page Design](./register-page-design-error.md)
  - [Design Analysis](./laravelpizza-com-design-analysis.md)
