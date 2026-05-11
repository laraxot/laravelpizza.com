# 📸 Analisi Visiva Homepage FixCity vs Bootstrap Italia

## Data: {{ date('Y-m-d H:i:s') }}

## Reference
- **Bootstrap Italia**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html
- **FixCity**: http://fixcity.local/it/tests/homepage

---

## 1. Header Structure

### Bootstrap Italia
```
┌─────────────────────────────────────────────────────────────┐
│ [Regione]                              [ITA] [ENG] [Login] │  ← Slim Header
├─────────────────────────────────────────────────────────────┤
│ [Logo] Nome del Comune                    [Social] [Cerca] │  ← Main Header
├─────────────────────────────────────────────────────────────┤
│ [NAV] Amministrazione | Novità | Servizi | Vivere          │  ← Navigation
└─────────────────────────────────────────────────────────────┘
```

**Colori:**
- Primary Blue: `#0066CC`
- Background: `#FFFFFF`
- Text: `#1A1A1A`

### FixCity (Attuale)
```
┌─────────────────────────────────────────────────────────────┐
│ [Header Component - XotBase]                                │
└─────────────────────────────────────────────────────────────┘
```

**Differenze:**
- ❌ Manca slim header con regione
- ❌ Social non allineati correttamente
- ⚠️ Navigation usa componenti Filament invece di Bootstrap Italia

**Fix Necessari:**
1. Aggiungere slim header component
2. Allineare social con icone Bootstrap Italia
3. Sostituire navigation con Bootstrap Italia navbar

---

## 2. Hero Section

### Bootstrap Italia
```
┌─────────────────────────────────────────────────────────────┐
│              CONTENUTI IN EVIDENZA                          │  ← H2 Centered
├─────────────────────────────────────────────────────────────┤
│ ┌───────────────────────────────────────────────────────┐   │
│ │  [Notizie 18 mag 2022]                                │   │
│ │  PARTE L'ESTATE CON OLTRE 300 EVENTI...              │   │
│ │  Inaugurazione lunedì 2 luglio...                    │   │
│ │  [Estate in città - Tutte le novità →]               │   │
│ └───────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

**Specifiche:**
- Section padding: `py-5` (3rem)
- Card: `card card-teaser`
- Title H2: `text-center mb-5`
- Card shadow: `shadow-sm`

### FixCity (Attuale)
```
┌─────────────────────────────────────────────────────────────┐
│ [Hero Component - Tailwind classes]                         │
└─────────────────────────────────────────────────────────────┘
```

**Differenze:**
- ❌ Usa classi Tailwind invece di Bootstrap Italia
- ❌ Card non usa `card-teaser`
- ⚠️ Spaziature non conformi

**Fix Necessari:**
```blade
<!-- PRIMA (Tailwind) -->
<section class="py-5 bg-white">
  <div class="container mx-auto">
    <div class="card shadow-lg">

<!-- DOPO (Bootstrap Italia) -->
<section class="py-5">
  <div class="container">
    <article class="card card-teaser shadow-sm">
```

---

## 3. Governance Cards

### Bootstrap Italia
```
┌─────────────────────────────────────────────────────────────┐
│              Organi di governo                              │
├──────────────┬──────────────┬──────────────┤
│ │MARIO ROSSI │ │LA GIUNTA   │ │IL CONSIGLIO│
│ │Il Sindaco  │ │COMUNALE    │ │COMUNALE    │
│ │            │ │La giunta.. │ │Il Consiglio│
│ │[Vai →]     │ │[Vai →]     │ │[Vai →]     │
└──────────────┴──────────────┴──────────────┘
```

**Specifiche:**
- Section background: `bg-light` (`#F5F6F7`)
- Grid: `row g-4` (gap 1.5rem)
- Columns: `col-lg-4 col-md-6`
- Card: `card card-teaser shadow-sm h-100`
- Button: `btn btn-outline-primary btn-sm mt-3`

### FixCity (Attuale)
```
┌─────────────────────────────────────────────────────────────┐
│ [Governance Component - Tailwind Grid]                      │
└─────────────────────────────────────────────────────────────┘
```

**Differenze:**
- ❌ Background usa `bg-gray-50` invece di `bg-light`
- ❌ Grid usa Tailwind invece di Bootstrap grid
- ❌ Card non usa `card-teaser`

**Fix Necessari:**
```blade
<!-- PRIMA -->
<div class="bg-gray-50 py-8">
  <div class="grid grid-cols-3 gap-4">

<!-- DOPO -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="card card-teaser shadow-sm h-100">
```

---

## 4. Events Calendar

### Bootstrap Italia
```
┌─────────────────────────────────────────────────────────────┐
│  EVENTI                    SETTEMBRE 2022                   │
├─────────────────────────────────────────────────────────────┤
│  ┌────────────────────────────────────────────────────┐    │
│  │ 15 LUN  • Saldo TASI                               │    │
│  │         • Concerto gratuito                        │    │
│  │         • Convocazione Consiglio                   │    │
│  ├────────────────────────────────────────────────────┤    │
│  │ 16 MAR  • Presentazione mostra                     │    │
│  └────────────────────────────────────────────────────┘    │
│           [Vai al calendario eventi →]                     │
└─────────────────────────────────────────────────────────────┘
```

**Specifiche:**
- Calendar container: `calendar-list`
- Event item: `calendar-event mb-3 pb-3 border-bottom`
- Date badge: `calendar-date text-primary h3`
- Day abbr: `calendar-day text-muted small text-uppercase`

### FixCity (Attuale)
```
┌─────────────────────────────────────────────────────────────┐
│ [Events Component - Flexbox Tailwind]                       │
└─────────────────────────────────────────────────────────────┘
```

**Differenze:**
- ❌ Non usa `calendar-list` class
- ❌ Date boxes non conformi
- ❌ Manca icona calendario

**Fix Necessari:**
```blade
<!-- PRIMA -->
<div class="flex gap-4 overflow-x-auto">

<!-- DOPO -->
<div class="calendar-list">
  <div class="calendar-event mb-3 pb-3 border-bottom">
    <div class="row">
      <div class="col-3 col-md-2">
        <span class="calendar-date text-primary h3">15</span>
        <span class="calendar-day text-muted small">LUN</span>
```

---

## 5. Topics Grid

### Bootstrap Italia
```
┌─────────────────────────────────────────────────────────────┐
│              Argomenti in evidenza                          │
├──────────┬──────────┬──────────┬──────────┤
│ │TRASPORTO│ │MOBILITÀ│ │ANIMALE  │ │SPORT   │
│ │PUBBLICO │ │IN COMUNE│ │DOMESTICO│ │        │
│ │Info...  │ │Sito... │ │Adozioni │ │Strutture│
│ │         │ │        │ │• Aree   │ │• Piscine│
│ │[Visita] │ │[Esplora]│ │[Esplora]│ │[Esplora]│
└──────────┴──────────┴──────────┴──────────┘
┌─────────────────────────────────────────────────────────────┐
│  ALTRI ARGOMENTI                                            │
│  • Associazioni  • Concorsi  • Energie  • Rifiuti          │
│  [Mostra tutti →]                                           │
└─────────────────────────────────────────────────────────────┘
```

**Specifiche:**
- Section: `py-5 bg-light`
- Grid: `row g-4`
- Cards: `col-lg-3 col-md-6`
- Card: `card card-teaser shadow-sm h-100`
- Title: `h6 text-uppercase text-muted mb-3`

### FixCity (Attuale)
```
┌─────────────────────────────────────────────────────────────┐
│ [Topics Component - Tailwind Cards]                         │
└─────────────────────────────────────────────────────────────┘
```

**Differenze:**
- ❌ Card non usano `card-teaser`
- ❌ Titoli non uppercase
- ❌ Manca "Altri Argomenti" card

**Fix Necessari:**
```blade
<!-- PRIMA -->
<div class="grid grid-cols-4 gap-4">
  <div class="card bg-white">

<!-- DOPO -->
<div class="row g-4">
  <div class="col-lg-3 col-md-6">
    <div class="card card-teaser shadow-sm h-100">
      <div class="card-body">
        <h3 class="card-title h6 text-uppercase text-muted mb-3">
```

---

## 6. Footer

### Bootstrap Italia
```
┌─────────────────────────────────────────────────────────────┐
│  [Valuta pagina] ⭐⭐⭐⭐⭐                                     │
│  [Contatta] [Problemi] [Cerca]                              │
├──────────────┬──────────────┬──────────────┬───────────────┤
│Amministrazione│Categorie     │Novità        │Contatti       │
│• Organi       │• Anagrafe    │• Notizie     │Via Roma 123   │
│• Aree         │• Cultura     │• Comunicati  │Tel: 05 0505   │
│• Uffici       │• Turismo     │• Avvisi      │PEC: ...       │
└──────────────┴──────────────┴──────────────┴───────────────┘
┌─────────────────────────────────────────────────────────────┐
│  [Social]  Privacy  Note Legali  Accessibilità  Mappa      │
└─────────────────────────────────────────────────────────────┘
```

### FixCity (Attuale)
```
┌─────────────────────────────────────────────────────────────┐
│ [Footer Component - XotBase]                                │
└─────────────────────────────────────────────────────────────┘
```

**Differenze:**
- ❌ Manca feedback module (stelle)
- ❌ Quick actions non conformi
- ❌ Footer columns diverse

---

## 📊 Riepilogo Differenze

| Sezione | Conformità | Priorità | Fix Time |
|---------|-----------|----------|----------|
| Header | 60% | 🔴 Alta | 2h |
| Hero | 70% | 🔴 Alta | 1h |
| Governance | 75% | 🟡 Media | 1h |
| Events | 65% | 🔴 Alta | 2h |
| Topics | 80% | 🟢 Bassa | 30min |
| Footer | 50% | 🔴 Alta | 3h |

**Conformità Totale: 67%**

---

## 🛠️ Piano di Intervento

### Fase 1: Header & Hero (Priorità 🔴)
1. Creare `components/layout/header-slim.blade.php`
2. Aggiornare `components/layout/header.blade.php`
3. Fixare hero con `card card-teaser`

### Fase 2: Governance & Events (Priorità 🔴)
1. Convertire grid a Bootstrap (`row g-4`)
2. Aggiungere classi `calendar-list`
3. Fixare date boxes

### Fase 3: Topics & Footer (Priorità 🟡)
1. Aggiungere "Altri Argomenti" card
2. Creare feedback module
3. Fixare footer columns

---

## 📝 Note Tecniche

### Classi Bootstrap Italia da Usare
```css
/* Sections */
.py-5, .bg-light, .container

/* Cards */
.card, .card-teaser, .card-bg, .shadow-sm

/* Grid */
.row, .g-4, .col-lg-4, .col-md-6

/* Typography */
.section-title, .text-primary, .text-muted, .text-uppercase

/* Components */
.calendar-list, .calendar-event, .calendar-date, .calendar-day

/* Buttons */
.btn, .btn-outline-primary, .btn-sm
```

### File da Modificare
```
Themes/Sixteen/resources/views/
├── components/layout/
│   ├── header-slim.blade.php     ← NUOVO
│   └── header.blade.php          ← MODIFICA
├── components/blocks/
│   ├── hero/homepage.blade.php   ← MODIFICA
│   ├── governance/cards.blade.php ← MODIFICA
│   ├── events/calendar.blade.php  ← MODIFICA
│   └── topics/highlight.blade.php ← MODIFICA
└── components/
    └── footer/
        └── full.blade.php         ← MODIFICA
```

---

**Prossimo Step**: Eseguire fix con Ralph Loop per iterazioni rapide
