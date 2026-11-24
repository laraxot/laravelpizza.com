---
title: "📸 Analisi Visiva Header & Footer - FixCity vs Bootstrap Italia"
title: "📸 Analisi Visiva Header & Footer - Notify vs Bootstrap Italia"
type: concept
tags: [analisi, colori, header, footer]
created: 2026-07-14
updated: 2026-07-14
qmd: "analisi-colori-header-footer 📸 analisi visiva header & footer - fixcity vs bootstrap italia"
qmd: "analisi-colori-header-footer 📸 analisi visiva header & footer - laraxot vs bootstrap italia"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./analisi-visiva.md"
  - "./fix-plan.md"
  - "./screenshot-analysis.md"
---

# 📸 Analisi Visiva Header & Footer - FixCity vs Bootstrap Italia
# 📸 Analisi Visiva Header & Footer - Notify vs Bootstrap Italia

## Data: {{ date('Y-m-d H:i:s') }}

---

## 🎯 Problema Identificato

**URL Reference**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html  
**FixCity**: http://fixcity.local/it/tests/homepage
**Notify**: http://laraxot.local/it/tests/homepage

**Differenze Principali**:
1. ❌ Header: Colori non corretti
2. ❌ Footer: Struttura e colori errati
3. ❌ Hero: Layout non allineato
4. ❌ Governance: Card non conformi
5. ❌ Events: Calendar non Bootstrap Italia
6. ❌ Topics: Card non corrette

---

## 1. HEADER - Bootstrap Italia Reference

### Struttura Ufficiale

```
┌─────────────────────────────────────────────────────────────┐
│ [BARRA REGIONE - #0066CC]                                   │
│ Nome della Regione           Lingua: ITA | ENG  [Accedi]   │
├─────────────────────────────────────────────────────────────┤
│ [LOGO COMUNE]                                               │
│ Il mio Comune                                               │
│ Un comune da vivere                                         │
│                                    [🔍 Cerca] [Social]      │
├─────────────────────────────────────────────────────────────┤
│ [NAVIGATION BAR - Bianco]                                   │
│ NOME DEL COMUNE    | Amministrazione | Novità | Servizi |  │
│                    | Vivere il Comune |                    │
└─────────────────────────────────────────────────────────────┘
```

### Colori Ufficiali Bootstrap Italia

| Elemento | Colore #hex | Note |
|----------|-------------|------|
| **Barra Regione** | `#0066CC` | Primary Blue |
| **Testo Regione** | `#FFFFFF` | White |
| **Login Button** | `#FFFFFF` | White bg, #0066CC text |
| **Navbar BG** | `#FFFFFF` | White |
| **Navbar Text** | `#1A1A1A` | Dark Grey |
| **Navbar Hover** | `#0066CC` | Primary Blue |
| **Social Icons** | `#1A1A1A` | Dark Grey |
| **Social Hover** | `#0066CC` | Primary Blue |

### Font Ufficiali

| Elemento | Font | Size | Weight |
|----------|------|------|--------|
| Regione | Titillium Web | 14px | 600 (Semibold) |
| Login | Titillium Web | 14px | 600 (Semibold) |
| Comune Name | Titillium Web | 24px | 700 (Bold) |
| Sottotitolo | Titillium Web | 16px | 400 (Regular) |
| Menu Items | Titillium Web | 16px | 600 (Semibold) |

### Spaziature Ufficiali

```css
.header-slim {
  padding-top: 0.5rem;    /* 8px */
  padding-bottom: 0.5rem; /* 8px */
  background-color: #0066CC;
}

.header-main {
  padding-top: 1.5rem;    /* 24px */
  padding-bottom: 1.5rem; /* 24px */
  background-color: #FFFFFF;
}

.navbar {
  padding-top: 1rem;      /* 16px */
  padding-bottom: 1rem;   /* 16px */
  gap: 1.5rem;            /* 24px */
}
```

---

## 2. FOOTER - Bootstrap Italia Reference

### Struttura Ufficiale

```
┌─────────────────────────────────────────────────────────────┐
│ [FEEDBACK MODULE - Grigio Chiaro #F5F6F7]                   │
│ Quanto sono chiare le informazioni?                         │
│ [⭐⭐⭐⭐⭐]                                                   │
├─────────────────────────────────────────────────────────────┤
│ [QUICK ACTIONS - Blu #0066CC, Testo Bianco]                 │
│ [📧 Contatta]  [⚠️ Problemi]  [🔍 Cerca]                    │
├─────────────────────────────────────────────────────────────┤
│ [MAIN FOOTER - Grigio Scuro #1A1A1A, Testo Bianco]          │
│ Comune | Admin | Servizi | News | Live | Contatti          │
├─────────────────────────────────────────────────────────────┤
│ [BOTTOM BAR - Nero #000000]                                 │
│ [Social] Privacy Note Legali Accessibilità                 │
└─────────────────────────────────────────────────────────────┘
```

### Colori Ufficiali Footer

| Sezione | BG #hex | Text #hex |
|---------|---------|-----------|
| **Feedback Module** | `#F5F6F7` | `#1A1A1A` |
| **Quick Actions** | `#0066CC` | `#FFFFFF` |
| **Main Footer** | `#1A1A1A` | `#FFFFFF` |
| **Bottom Bar** | `#000000` | `#CCCCCC` |
| **Links Hover** | - | `#FFFFFF` |

### Font Footer

| Elemento | Font | Size | Weight |
|----------|------|------|--------|
| Feedback Title | Titillium Web | 18px | 600 (Semibold) |
| Quick Actions | Titillium Web | 16px | 600 (Semibold) |
| Column Headers | Titillium Web | 16px | 700 (Bold), UPPERCASE |
| Column Links | Titillium Web | 14px | 400 (Regular) |
| Bottom Bar | Titillium Web | 14px | 400 (Regular) |

### Spaziature Footer

```css
.feedback-section {
  padding-top: 3rem;      /* 48px */
  padding-bottom: 3rem;   /* 48px */
  background-color: #F5F6F7;
}

.quick-actions {
  padding-top: 2.5rem;    /* 40px */
  padding-bottom: 2.5rem; /* 40px */
  background-color: #0066CC;
  gap: 2rem;              /* 32px */
}

.main-footer {
  padding-top: 3rem;      /* 48px */
  padding-bottom: 3rem;   /* 48px */
  background-color: #1A1A1A;
}

.bottom-bar {
  padding-top: 1.5rem;    /* 24px */
  padding-bottom: 1.5rem; /* 24px */
  background-color: #000000;
}
```

---

## 3. FixCity - Differenze Attuali

### Header FixCity (Errato)
## 3. Notify - Differenze Attuali

### Header Notify (Errato)

```
❌ Barra regione: Colore sbagliato
❌ Font: Non Titillium Web
❌ Spaziature: Non conformi
❌ Social: Posizione errata
❌ Login: Stile non Bootstrap Italia
```

### Footer FixCity (Errato)
### Footer Notify (Errato)

```
❌ Feedback module: Assente o errato
❌ Quick actions: Colori sbagliati
❌ Main footer: Struttura errata
❌ Social: Icone non Bootstrap Italia
❌ Bottom bar: Colore e testo errati
```

---

## 4. Piano di Fix

### Header - Fix Prioritari

1. **Colori**
   - Barra regione: `#0066CC`
   - Testo: `#FFFFFF`
   - Login button: Bianco con testo `#0066CC`

2. **Font**
   - Importare Titillium Web da Google Fonts
   - Applicare pesi corretti (400, 600, 700)

3. **Struttura**
   - Header slim con regione
   - Header main con logo e search
   - Navbar con menu

4. **Icone**
   - Usare SVG sprites Bootstrap Italia
   - Social: Twitter, Facebook, YouTube, Telegram, Whatsapp, RSS

### Footer - Fix Prioritari

1. **Feedback Module**
   - Stelle 1-5
   - Form follow-up
   - Background `#F5F6F7`

2. **Quick Actions**
   - 3 colonne: Contatta, Problemi, Cerca
   - Background `#0066CC`
   - Testo bianco

3. **Main Footer**
   - 6 colonne
   - Background `#1A1A1A`
   - Testo bianco

4. **Bottom Bar**
   - Social + Legal links
   - Background `#000000`
   - Testo `#CCCCCC`

---

## 5. File da Modificare

### Header
```
Themes/Sixteen/resources/views/
├── components/layout/
│   ├── header-slim.blade.php     ← Fix colori #0066CC
│   └── header.blade.php          ← Fix struttura completa
└── resources/css/
    └── app.css                   ← Fix font Titillium Web
```

### Footer
```
Themes/Sixteen/resources/views/
└── components/bootstrap-italia/
    └── footer-full.blade.php     ← Fix completo struttura + colori
```

---

## 6. Testing Checklist

### Header
- [ ] Barra regione colore `#0066CC`
- [ ] Testo bianco `#FFFFFF`
- [ ] Font Titillium Web
- [ ] Login button bianco
- [ ] Social allineati
- [ ] Responsive mobile

### Footer
- [ ] Feedback module con stelle
- [ ] Quick actions blu `#0066CC`
- [ ] Main footer grigio scuro `#1A1A1A`
- [ ] Bottom bar nero `#000000`
- [ ] Social icone Bootstrap Italia
- [ ] Responsive mobile

---

**Prossimo Step**: Applicare fix con Ralph Loop iterazioni
