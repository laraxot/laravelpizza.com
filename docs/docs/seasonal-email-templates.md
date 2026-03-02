# Seasonal Email Templates - Guida Completa

**Status**: ✅ Implementato
**Data**: 2025-12-19
**Moduli**: Notify, Themes/Sixteen

## 📋 Indice

1. [Overview](#overview)
2. [Architettura](#architettura)
3. [Template Disponibili](#template-disponibili)
4. [Utilizzo](#utilizzo)
5. [Come Creare Nuovi Template Stagionali](#come-creare-nuovi-template-stagionali)
6. [Best Practices](#best-practices)
7. [Testing](#testing)

---

## Overview

Il sistema di **Seasonal Email Templates** permette di utilizzare layout HTML tematici per email stagionali mantenendo la stessa infrastruttura di `SpatieEmail`.

### Vantaggi

✅ **Flessibilità**: Cambia il layout senza modificare il contenuto
✅ **Riusabilità**: Stesso contenuto, diversi layout
✅ **Manutenibilità**: Layout centralizzati in Themes
✅ **Personalizzazione**: Ogni tema può avere i suoi layout
✅ **Compatibilità**: Email-safe CSS animations

---

## Architettura

### Stack Tecnologico

```
SpatieEmail (Modules/Notify)
    ↓ usa
Mustache Template Engine
    ↓ processa
HTML Layout (Themes/*/resources/mail-layouts/)
    ↓ inserisce
Contenuto Dinamico {{{ body }}}
    ↓ genera
Email HTML finale
```

### Flusso Dati

```php
// 1. Creazione email
$email = new SpatieEmail($record, 'welcome-customer');

// 2. SpatieEmail::getHtmlLayout() carica layout
$layout = file_get_contents('Themes/Sixteen/resources/mail-layouts/base.html');

// 3. Mustache sostituisce variabili
// Per la lista completa delle variabili, vedi: Themes/Sixteen/docs/mustache-variables.md
$layout = $mustache->render($layout, [
    'subject' => 'Benvenuto!',
    'company_name' => 'ACME Corp',
    'logo_header' => 'https://...',
    'body' => '<p>Contenuto email</p>',
    // ...
]);

// 4. Email inviata
Mail::to($user)->send($email);
```

### File Coinvolti

| File | Ruolo |
|------|-------|
| `Modules/Notify/app/Emails/SpatieEmail.php` | Classe email principale |
| `Themes/Sixteen/resources/mail-layouts/base.html` | Layout standard |
| `Themes/Sixteen/resources/mail-layouts/christmas.html` | Layout natalizio classico |
| `Themes/Sixteen/resources/mail-layouts/christmas-elegant.html` | Layout natalizio elegante |
| `Themes/Sixteen/resources/mail-layouts/christmas-festive.html` | Layout natalizio festoso |
| `Themes/Sixteen/resources/mail-layouts/christmas-modern.html` | Layout natalizio moderno |
| `Themes/Sixteen/resources/mail-layouts/christmas-sottana.html` | Layout natalizio personalizzato per Sottana Service |
| `Themes/Sixteen/resources/mail-layouts/christmas-luxury.html` | Layout natalizio luxury premium (oro/rosso/bordeaux) |
| `Themes/Sixteen/resources/mail-layouts/christmas-winter-wonderland.html` | Layout winter wonderland con aurora borealis |
| `Themes/Sixteen/resources/mail-layouts/christmas-elephant-mascot.html` | Layout natalizio con elefante mascotte Sottana Service |
| `Modules/Notify/app/Models/MailTemplate.php` | Contenuti email da DB |

---

## Template Disponibili

### 1. base.html - Standard

**Quando usare**: Tutte le comunicazioni normali

**Caratteristiche**:
- Design Italia Color System
- Responsive + Dark mode
- Font: Titillium Web
- Colori: Blu #0066CC, Verde #00AA66

---

### 2. christmas.html - Template Base Natalizio (MIGLIORATO)

**Quando usare**: Comunicazioni natalizie generiche

**Caratteristiche Migliorate (2025)**:
- ✅ **Pattern SVG decorativo**: Pattern natalizio email-safe nel background con stelle dorate
- ✅ **Animazioni sofisticate**: 
  - Albero di Natale con animazione `tree-glow` (pulsazione dorata)
  - Effetto shimmer sull'header (luce che attraversa)
  - Decorazioni con `bounce-rotate` (rimbalzo + rotazione)
- ✅ **Box decorato**: Holiday notice box con pattern interno, decorazioni multiple (4 emoji animate)
- ✅ **Bordi elaborati**: Border dorato con ombre multiple e glow effect
- ✅ **20 snowflakes animate**: Caduta neve naturale con velocità variabili
- ✅ **Colori vivaci**: Gradienti oro/rosso/verde più intensi e professionali
- ✅ **Accessibilità**: Supporto `prefers-reduced-motion` completo
- ✅ **Mobile optimized**: Animazioni disabilitate su mobile per performance

**Animazioni CSS**:
- `tree-glow`: Pulsazione dorata per albero di Natale
- `shimmer`: Effetto luce che attraversa l'header
- `bounce-rotate`: Rimbalzo e rotazione per decorazioni
- `snowfall`: Caduta naturale della neve

---

### 3. christmas-sottana.html - Template Sottana Service (MIGLIORATO)

**Quando usare**: Comunicazioni natalizie per Sottana Service

**Caratteristiche Migliorate (2025)**:
- ✅ **Pattern natalizio nel wrapper**: Sfondo decorativo con pattern oro/rosso
- ✅ **Header decorato**: 
  - Pattern a righe dorate
  - Shimmer effect elegante
  - Stelle decorative animate (⭐✨) con twinkle effect
  - Decorazioni fluttuanti (🎅🎁) con animazione float-decor
- ✅ **Albero animato**: Glow effect con pulsazione dorata e drop-shadow
- ✅ **Box Sottana Service elaborato**:
  - Pattern interno decorativo
  - 4 decorazioni animate (🎁🎄⭐✨) posizionate strategicamente
  - Gradienti oro più vivaci
  - Ombre multiple per profondità
- ✅ **Messaggi professionali**: Tipografia migliorata con text-shadow e colori più vivaci
- ✅ **Brand colors**: Mantenuto #0071b0 per branding Sottana Service

**Messaggi Personalizzati**:
- "Lo staff di Sottana Service augura..."
- "Ufficio chiuso dal 24 dicembre fino al 6 gennaio"
- "Ci rivediamo il 7 gennaio!"

---

### 4. christmas-elegant.html - Template Elegante (MIGLIORATO)

**Quando usare**: Comunicazioni natalizie eleganti e raffinate

**Caratteristiche Migliorate (2025)**:
- ✅ **Background stellato**: Pattern SVG di stelle dorate nel background body
- ✅ **Stelle fluttuanti**: 5 stelle emoji che fluttuano dal basso verso l'alto
- ✅ **8 stelle CSS animate** (invece di 5): Maggiore densità di stelle nell'header
- ✅ **Stelle emoji decorative**: 3 stelle emoji aggiuntive con animazione twinkle
- ✅ **Shimmer elegante**: Effetto luce che attraversa l'header con animazione più lenta (4s)
- ✅ **Box holiday-message decorato**: 
  - Pattern interno
  - Decorazioni ❅ animate con elegant-twinkle
  - Border e ombre più elaborate
- ✅ **Bordi dorati elaborati**: Border 2px con glow effect e ombre multiple
- ✅ **Colori eleganti**: Palette oro (#D4AF37) con sfumature più raffinate

**Animazioni CSS**:
- `elegant-twinkle`: Animazione elegante per stelle (rotazione + scale + glow)
- `elegant-shimmer`: Shimmer effect lento e raffinato
- `float-star`: Fluttuazione stellare dal basso verso l'alto

---

### 5. christmas-festive.html - Template Festoso (MIGLIORATO)

**Quando usare**: Comunicazioni natalizie vivaci e festose

**Caratteristiche Migliorate (2025)**:
- ✅ **Luci natalizie realistiche**: 
  - Forma a bulbo con border-radius specifico (50% 50% 50% 50% / 60% 60% 40% 40%)
  - Cavo nero con gradiente realistico
  - 4 colori (rosso, verde, giallo, blu) con animazione `festive-flash`
  - Glow effect più intenso (box-shadow multipli)
  - Cavetto superiore per realismo
- ✅ **Bordo decorativo animato**: Gradient animato intorno al container con `border-glow`
- ✅ **Pattern background**: Pattern natalizio doppio (oro + rosso) nel body
- ✅ **Header con pattern**: Pattern decorativo interno nell'header
- ✅ **Titolo con pulse**: Animazione `title-pulse` per il titolo festivo
- ✅ **Gift box decorato**: 
  - Decorazioni 🎁🎄 animate con bounce
  - Pattern interno
  - Border e ombre più elaborate

**Animazioni CSS**:
- `festive-flash`: Flash realistico per luci natalizie con scale e glow
- `border-glow`: Pulsazione del bordo decorativo
- `title-pulse`: Pulsazione leggera per il titolo
- `bounce`: Rimbalzo per decorazioni emoji

---

### 6. christmas-sottana-elephant.html - Template con Elefante Mascotte

**Quando usare**: Comunicazioni natalizie per Sottana Service con elefante mascotte

**Caratteristiche**:
- Tutte le caratteristiche di `christmas-sottana.html` migliorate
- ✅ Elefante mascotte prominente con animazione `elephant-wave`
- ✅ Cappello Babbo Natale animato con `hat-wiggle`
- ✅ Decorazioni 🐘🎄 integrate nel messaggio

---

## 🎨 Miglioramenti Avanzati 2025 - Design Premium e Professionalità

### Glassmorphism e Profondità

Tutti i template implementano effetti glassmorphism avanzati:
- ✅ **Backdrop blur**: Effetti blur per profondità visiva (`backdrop-filter: blur(10px)`)
- ✅ **Multiple shadow layers**: 6-8 layers di ombre per profondità tridimensionale
- ✅ **Gradient overlays**: Layer di gradienti animati per texture dinamiche
- ✅ **Border glow effects**: Bordi con glow animato per eleganza

### Pattern SVG Email-Safe

Tutti i template utilizzano pattern SVG inline per background decorativi:
- Pattern stelle dorate (christmas-elegant.html)
- Pattern neve/fiocchi (christmas.html, christmas-sottana.html)
- Pattern natalizio geometrico (christmas-festive.html)
- Pattern animati con gradienti dinamici

**Vantaggi**:
- Email-safe (non base64, non bloccati da Gmail)
- Leggeri (< 1KB)
- Scalabili e responsive
- Compatibili con tutti i client email moderni

### Animazioni CSS Email-Safe Avanzate

#### Animazioni Premium Aggiunte:
1. **tree-glow**: Pulsazione dorata per albero di Natale (scale + drop-shadow + brightness)
2. **shimmer**: Effetto luce che attraversa elementi (linear-gradient animato con rotazione)
3. **bounce-rotate**: Rimbalzo + rotazione per decorazioni emoji (3D effect)
4. **elegant-twinkle**: Animazione elegante per stelle (rotazione + scale + glow multipli)
5. **float-star**: Fluttuazione stellare dal basso verso l'alto con fade
6. **festive-flash**: Flash realistico per luci natalizie con glow intenso e scale
7. **border-glow**: Pulsazione per bordi decorativi con brightness animation
8. **title-pulse**: Pulsazione per titoli con glow effect
9. **float-decor**: Fluttuazione per decorazioni nell'header con rotazione
10. **pulse-gold**: Pulsazione dorata per elementi decorativi
11. **gradient-shift**: Animazione gradienti di sfondo (400% background-size)
12. **header-gradient-flow**: Flusso gradienti nell'header (200% background-size)
13. **notice-glow**: Glow animato per box con opacity variabile
14. **elegant-aurora**: Effetto aurora borealis per template elegante
15. **festive-border-glow**: Glow animato per bordo festivo con brightness
16. **gift-box-shine**: Shine effect per gift box con opacity variabile
17. **elegant-gradient-flow**: Flusso gradienti eleganti (400% background-size)
18. **dark-mode-bg-shift**: Animazione background dark mode
19. **pattern-shift**: Pattern decorativi animati con translate
20. **festive-shimmer**: Shimmer effect festivo con rotazione avanzata

#### Micro-Interactions Premium:
- **Button ripple effect**: Effetto ripple al hover con ::before pseudo-element
- **Button scale on hover**: Transform scale(1.02) con cubic-bezier easing
- **Active state feedback**: Transform scale(0.98) al click per feedback tattile
- **Link hover animations**: Border-bottom animato per link footer

#### Animazioni Esistenti Migliorate:
- **snowfall**: Migliorata con più varietà di velocità
- **bounce**: Migliorata con scale effect
- **twinkle**: Migliorata con rotazione e glow più intenso

### Decorazioni Elaborate e Design Premium

Ogni template ora include:
- **Multiple emoji decorations**: 4-8 decorazioni posizionate strategicamente con animazioni diverse
- **Pattern interni animati**: Pattern decorativi dentro box e header con animazioni
- **Bordi elaborati multi-layer**: 3-6 layers di border e shadow per profondità
- **Gradienti animati vivaci**: Gradienti complessi con background-size 200-400% e animazioni
- **Stelle decorative**: Stelle CSS (8+) e emoji (3-5) con animazioni twinkle sofisticate
- **Glassmorphism effects**: Backdrop blur per effetti di vetro smerigliato
- **Texture overlays**: Radial gradients per texture subtle e profondità
- **Animated gradient borders**: Bordi con gradienti animati (4 colori, 400% background-size)
- **Shimmer effects**: Effetti luce che attraversano elementi con rotazione
- **Aurora borealis effects**: Effetti aurora per template elegante (christmas-elegant.html)

### Typography Premium

- **Font weights ottimizzati**: 600-800 per headings, hierarchy chiara
- **Letter-spacing migliorato**: -0.03em per h1, -0.02em per h2, 0.01em per p
- **Text shadows avanzati**: Multiple layers di text-shadow per profondità
- **Line-height ottimizzato**: 1.1 per h1, 1.2 per h2, 1.7-1.95 per paragrafi
- **Font smoothing**: Antialiased e grayscale per rendering perfetto
- **Visual hierarchy**: Dimensioni font scalate (32px h1, 26px h2, 17-18px p)

### Performance e Accessibilità Avanzate

**Ottimizzazioni Mobile Premium**:
- ✅ Animazioni disabilitate automaticamente su schermi < 600px
- ✅ Decorazioni nascoste su mobile per risparmio batteria
- ✅ Backdrop-filter disabilitato su mobile (performance)
- ✅ Pattern SVG e gradienti animati rimossi su mobile
- ✅ Layout fluido con padding ottimizzato (32-24px)
- ✅ Typography scalata per leggibilità mobile (26px h1, 22px h2, 16px p)
- ✅ Button full-width per touch-friendly
- ✅ White space ottimizzato per mobile (margini ridotti)

**Accessibilità WCAG 2.1 AA Enhanced**:
- ✅ Supporto completo `prefers-reduced-motion` con animation-duration: 0.01ms
- ✅ Decorazioni diventano statiche quando motion è ridotto
- ✅ Contrasto colori mantenuto per leggibilità (minimo 4.5:1)
- ✅ Text shadows per leggibilità in dark mode
- ✅ Font smoothing per rendering perfetto
- ✅ Skip links per screen reader
- ✅ ARIA labels e semantic HTML

---

## 📊 Comparazione Template Migliorati Premium (2025)

| Template | Glassmorphism | Animazioni | Decorazioni Emoji | Bordi Elaborati | Stelle Animate | Gradient Animati | SVG Decorativi | Mobile Optimized | Dark Mode |
|----------|---------------|------------|-------------------|-----------------|----------------|------------------|----------------|------------------|-----------|
| christmas.html | ✅ (10px) | ✅ (8 nuove) | ✅ (4+) | ✅ (6 layers) | ❌ | ✅ (400%) | ✅ (4 stelle + 6 snowflakes + tree) | ✅ | ✅ Avanzato |
| christmas-sottana.html | ✅ (8-12px) | ✅ (10 nuove) | ✅ (6+) | ✅ (6 layers) | ✅ (4) | ✅ (400%) | ✅ (4 stelle + 6 snowflakes + tree) | ✅ | ✅ Avanzato |
| christmas-elegant.html | ✅ (12px) | ✅ (7 nuove) | ✅ (5+) | ✅ (8 layers) | ✅ (8 CSS + 3 emoji) | ✅ (400%) | ✅ (4 stelle + 6 snowflakes + tree) | ✅ | ✅ Avanzato |
| christmas-festive.html | ✅ (10px) | ✅ (9 nuove) | ✅ (2+) | ✅ (6 layers) | ❌ | ✅ (400%) | ✅ (4 stelle + 6 snowflakes + tree) | ✅ | ✅ Avanzato |
| christmas-premium.html | ✅ (15px) | ✅ (8+ nuove) | ✅ (3+) | ✅ (8 layers) | ✅ (5 CSS) | ✅ (400%) | ✅ (4 stelle + 6 snowflakes) | ✅ | ✅ Avanzato |
| christmas-corporate.html | ✅ (8px) | ✅ (5+ nuove) | ✅ (2+) | ✅ (6 layers) | ❌ | ✅ (300%) | ✅ (2 stelle + 4 snowflakes minimaliste) | ✅ | ✅ Avanzato |
| christmas-modern.html | ✅ (10px) | ✅ (6+ nuove) | ✅ (3+) | ✅ (6 layers) | ✅ (3 CSS) | ✅ (300%) | ✅ (4 stelle + 6 snowflakes blu) | ✅ | ✅ Avanzato |
| christmas-professional.html | ✅ (8px) | ✅ (6+ nuove) | ✅ (1+) | ✅ (6 layers) | ❌ | ✅ (400%) | ✅ (2 stelle + 4 snowflakes oro/maroon) | ✅ | ✅ Avanzato |
| christmas-luxury.html | ✅ (15px) | ✅ (8+ nuove) | ✅ (4+) | ✅ (8 layers) | ✅ (4 CSS) | ✅ (400%) | ✅ (4 stelle + 6 snowflakes + tree + pattern) | ✅ | ✅ Avanzato |

---

## 🎯 Best Practices Applicate

### Email-Safe Techniques
1. ✅ **Pattern SVG inline**: Utilizzati invece di immagini base64
2. ✅ **CSS animations**: Solo animazioni supportate da client email moderni
3. ✅ **Fallback graceful**: Decorazioni nascoste su client non supportati
4. ✅ **Table-based layout**: Mantenuto per compatibilità Outlook
5. ✅ **Inline CSS**: Aggiunto dove necessario per compatibilità

### Design Principles
1. ✅ **Colori vivaci ma professionali**: Palettes natalizie intensificate
2. ✅ **Decorazioni elaborate**: Multiple decorazioni senza sovraccaricare
3. ✅ **Animazioni sofisticate**: Effetti più raffinati e professionali
4. ✅ **Pattern decorativi**: Pattern SVG per texture natalizie
5. ✅ **Tipografia migliorata**: Text-shadow, letter-spacing, font-size ottimizzati

### Elementi SVG Decorativi Animati (2025)

Tutti i template natalizi includono elementi SVG decorativi animati email-safe:

#### Caratteristiche SVG Comuni:
- ✅ **Email-Safe**: Inline SVG con `viewBox` per compatibilità
- ✅ **Animazioni CSS + SVG**: Doppia animazione per massima compatibilità
- ✅ **Opacità animate**: Effetti twinkle sofisticati
- ✅ **Rotazione dinamica**: Stelle e alberi con rotazione fluida
- ✅ **Drop-shadow effects**: Profondità visiva premium
- ✅ **Colori tematici**: Coordinati con il design di ogni template
- ✅ **Decorazioni SVG decorative**: Pattern decorativi discreti negli angoli del content area (`.svg-decoration`)
- ✅ **Icone Social SVG**: Icone social (Facebook, Twitter, LinkedIn) con variabili Mustache dinamiche

#### Elementi SVG per Template:

| Template | Stelle SVG | Snowflakes SVG | Tree SVG | Pattern SVG | Decorazioni SVG | Icone Social | Colori |
|----------|-----------|----------------|----------|-------------|-----------------|--------------|--------|
| christmas.html | 4 (24px) | 6 (16px) | ✅ (48px) | ❌ | ✅ (2 angoli) | ✅ SVG Mustache | Oro/Bianco |
| christmas-sottana.html | 4 (24px) | 6 (18px) | ✅ (52px) | ❌ | ❌ | ✅ SVG Mustache | Oro #FFD700 |
| christmas-elegant.html | 4 (24px) | 6 (16px) | ✅ (48px) | ❌ | ✅ (2 angoli) | ✅ SVG Mustache | Oro/Champagne |
| christmas-festive.html | 4 (22px) | 6 (16px) | ✅ (50px) | ❌ | ✅ (2 angoli) | ✅ SVG Mustache | Oro/Bianco |
| christmas-premium.html | 4 (26px) | 6 (20px) | ❌ | ❌ | ✅ (2 angoli) | ✅ SVG Mustache | Oro #D4AF37/Champagne |
| christmas-corporate.html | 2 (18px) | 4 (14px) | ❌ | ❌ | ✅ (2 angoli minimaliste) | ✅ SVG Mustache | Rosso/Oro corporate |
| christmas-modern.html | 4 (20px) | 6 (14px) | ❌ | ❌ | ✅ (2 angoli) | ✅ SVG Mustache | Blu #2563EB/Blu scuro |
| christmas-professional.html | 2 (20px) | 4 (16px) | ❌ | ❌ | ✅ (2 angoli eleganti) | ✅ SVG Mustache | Oro #C5A059/Crema |
| christmas-luxury.html | 4 (28px) | 6 (20px) | ✅ (56px) | ✅ Pattern stellato | ✅ (2 angoli premium) | ✅ SVG Mustache | Oro premium/Champagne |

**Nota**: Le dimensioni sono ottimizzate per ogni tema (minimaliste per corporate, più grandi per luxury).

### Icone Social SVG (2025)

Tutti i template includono icone social SVG dinamiche con variabili Mustache:

- ✅ **Facebook, Twitter, LinkedIn**: Icone SVG email-safe (32px)
- ✅ **Variabili Mustache**: Utilizzano `{{ facebook_url }}`, `{{ twitter_url }}`, `{{ linkedin_url }}`
- ✅ **Condizionali**: Mostrate solo se le variabili sono presenti
- ✅ **Colori tematici**: Coordinati con il design di ogni template (oro per elegant/luxury/premium, bianco per festive, colori corporate/professional/modern)
- ✅ **Hover effects**: Scale e cambio colore su hover
- ✅ **Accessibility**: ARIA labels per screen reader

**Template con icone social**:
- ✅ Tutti i template natalizi principali (christmas.html, christmas-elegant.html, christmas-festive.html, christmas-premium.html, christmas-corporate.html, christmas-modern.html, christmas-professional.html, christmas-luxury.html)
- ✅ Template Sottana Service (christmas-sottana.html già presente)

### Decorazioni SVG Decorative (2025)

Tutti i template includono decorazioni SVG decorative discrete negli angoli del content area:

- ✅ **Pattern decorativi**: Stelle e cerchi SVG con opacità molto bassa (0.03-0.06)
- ✅ **Posizionamento**: Angoli top-left e bottom-right del content area
- ✅ **Dimensioni**: Adattate al tema (80-130px, minimaliste per corporate)
- ✅ **Rotazione**: Angoli rotati (45° e 135°) per effetto decorativo
- ✅ **Email-safe**: Inline SVG con `viewBox` per compatibilità
- ✅ **Mobile optimized**: Disabilitate su mobile per performance
- ✅ **Accessibility**: Supporto `prefers-reduced-motion` completo

### Performance
1. ✅ **Mobile optimization**: Animazioni SVG disabilitate automaticamente su mobile
2. ✅ **Reduced motion**: Supporto completo `prefers-reduced-motion` per accessibilità (incluso `.svg-decoration`)
3. ✅ **Lightweight**: Elementi SVG < 2KB per template
4. ✅ **Efficient animations**: Animazioni CSS + SVG ottimizzate
5. ✅ **Email-safe**: Inline SVG con `viewBox` per compatibilità client email
6. ✅ **Icone social**: SVG inline con dimensioni ottimizzate (32px)
7. ✅ **Decorazioni decorative**: Opacità molto bassa per non interferire con il contenuto

---

## 🚀 Utilizzo Template Migliorati

I template migliorati mantengono la stessa API e variabili Mustache, quindi sono completamente retrocompatibili:

```php
// Utilizzo identico a prima
$email = new SpatieEmail($record, 'christmas-greetings');

// Il template migliorato viene caricato automaticamente
// Tutte le animazioni e decorazioni sono incluse automaticamente
```

---

## 📝 Note Tecniche

### Compatibilità Animazioni

| Client Email | Pattern SVG | CSS Animations | Decorazioni Emoji |
|--------------|-------------|----------------|-------------------|
| Apple Mail (macOS/iOS) | ✅ | ✅ | ✅ |
| Gmail Web | ✅ | ⚠️ Parziale | ✅ |
| Gmail Mobile | ✅ | ❌ | ✅ |
| Outlook 2016+ | ⚠️ Limitato | ❌ | ✅ |
| Outlook.com | ✅ | ⚠️ Parziale | ✅ |

### Fallback Strategy

I template degradano gracefully:
- Pattern SVG: Visualizzati come gradienti su client non supportati
- Animazioni CSS: Ignorate, decorazioni rimangono statiche
- Decorazioni emoji: Sempre visibili (supporto universale)

---

## 🔄 Prossimi Miglioramenti Suggeriti

1. **Interactive elements**: Hover effects dove supportati (Gmail Web, Apple Mail)
2. **Additional themes**: Epifania, Carnevale, Primavera
3. **Customization**: Parametri per intensità animazioni
4. **A/B testing**: Template per testare engagement
5. **Localization**: Pattern decorativi per diverse tradizioni culturali

**Visualizzazione**:
```
┌────────────────────────┐
│  [LOGO AZIENDA]        │ ← Header blu gradient
├────────────────────────┤
│                        │
│  Contenuto email       │ ← Contenuto bianco
│  dinamico qui          │
│                        │
├────────────────────────┤
│  © 2025 Company        │ ← Footer scuro
│  Links sociali         │
└────────────────────────┘
```

### 2. christmas-elegant.html - Natalizio Elegante

**Quando usare**: Comunicazioni ufficiali durante periodo natalizio (Dicembre-Gennaio) - stile raffinato e professionale

**Caratteristiche**:
- ❄️ Neve animata elegante CSS (15 snowflakes)
- ⭐ Stelle brillanti animate (8 stelle con effetto twinkle)
- 🎨 Colori eleganti: Rosso #C8102E, Verde #165B33, Oro #D4AF37
- 🌙 Background notturno elegante: Gradiente blu notte
- 📋 Box evidenziato dorato con gradiente crema
- ✨ Emoji festive integrate
- Font serif (Georgia) per eleganza

**Visualizzazione**:
```
  ❄  ⭐  ❄  ← Neve e stelle animate
┌────────────────────────┐
│ 🎄  [LOGO]  ❄         │ ← Header rosso-verde gradient
│     Buone Feste!       │
├────────────────────────┤
│ ┌──────────────────┐   │
│ │ 🎅 CHIUSURA 🎅   │   │ ← Box dorato elegante
│ │ 24 Dic - 7 Gen   │   │
│ └──────────────────┘   │
│                        │
│ Contenuto email        │
│                        │
├────────────────────────┤
│ ✨ © 2025 Company ✨   │ ← Footer blu notte
└────────────────────────┘
```

**Animazioni CSS**:
- `@keyframes snowfall`: Neve elegante che cade (15 snowflakes)
- `@keyframes twinkle`: Stelle che brillano (8 stelle)
- Durata: 11s - 16s per naturalezza
- Disabilitate su mobile per performance
- Fallback graceful per Outlook

### 3. christmas-sottana.html - Natalizio Personalizzato Sottana Service

**Quando usare**: Comunicazioni specifiche di Sottana Service durante il periodo natalizio - design molto natalizio e molto professionale

**Caratteristiche**:
- 🎄 **Messaggio personalizzato**: "Lo staff di Sottana Service augura a tutti voi e alle vostre famiglie Felici Feste Natalizie!"
- 📋 **Informazioni chiusura**: "L'ufficio sarà chiuso dal 24 dicembre fino al 6 gennaio"
- 🎅 **Riapertura**: "Ci rivediamo il 7 gennaio!"
- 🎨 **Design molto natalizio**:
  - ❄️ 20 fiocchi di neve animati con traiettorie realistiche (CSS `@keyframes snowfall`)
  - 🎁 Decorazioni natalizie animate con effetto bounce (emoji 🎁🎄 con animazione)
  - 🎄 Header con gradient rosso-verde-rosso e bordo dorato (#FFD700)
  - 🌟 Background scuro elegante (gradiente #1F2937 → #111827) con animazioni neve
  - 🎅 Decorazioni natalizie nel header (emoji posizionate strategicamente)
- 💼 **Design molto professionale**:
  - 🎨 Box evidenziato con gradiente oro elegante (#FFF8E1 → #FFECB3) e bordo dorato da 3px
  - 📝 Tipografia chiara e leggibile: font serif (Georgia) per eleganza professionale
  - 🎨 Colori natalizi armoniosi: Rosso #C8102E, Verde #006400, Oro #FFD700
  - 🔵 Branding Sottana Service: colore primario #0071b0 evidenziato nel testo dello staff
  - 📱 Layout responsive completo con ottimizzazioni mobile
  - ♿ Accessibilità WCAG 2.1 completa (prefers-reduced-motion support, aria-hidden per decorazioni)
- ✨ Animazioni email-safe (CSS puro, no JavaScript)
- 📱 Animazioni disabilitate su mobile per performance ottimali
- 🖨️ Stampa ottimizzata (animazioni disabilitate, layout pulito)

**Visualizzazione**:
```
  ❄  ❄  ❄  ❄  ← 20 snowflakes animate
┌═══════════════════════════┐
│ 🎅 [LOGO] 🎁              │ ← Header gradient rosso-verde-rosso
│                           │    bordo dorato 3px
│       🎄                  │ ← Christmas tree animate (bounce)
│   🎄 Buone Feste 🎄       │ ← Title bianco con shadow
│   Sottana Service         │ ← Sottotitolo oro (#FFD700)
├───────────────────────────┤
│ ┏━━━━━━━━━━━━━━━━━━━━━┓ │
│ ┃ 🎄 Auguri di Buone   ┃ │ ← Box gradiente oro con
│ ┃    Feste! 🎄         ┃ │    bordo dorato 3px
│ ┃                      ┃ │
│ ┃ Lo staff di          ┃ │ ← Testo con branding #0071b0
│ ┃ Sottana Service      ┃ │
│ ┃ augura a tutti voi   ┃ │
│ ┃ e alle vostre        ┃ │
│ ┃ famiglie             ┃ │
│ ┃ 🎅 Felici Feste      ┃ │
│ ┃ Natalizie! 🎉        ┃ │
│ ┃                      ┃ │
│ ┃ ━━━━━━━━━━━━━━━━━ ━ ┃ │
│ ┃ 📅 Informazioni      ┃ │
│ ┃    Chiusura Ufficio  ┃ │
│ ┃                      ┃ │
│ ┃ L'ufficio sarà       ┃ │
│ ┃ chiuso               ┃ │
│ ┃ dal 24 dicembre      ┃ │
│ ┃ fino al 6 gennaio    ┃ │
│ ┃                      ┃ │
│ ┃ 🎊 Ci rivediamo il   ┃ │
│ ┃ 7 gennaio! 🎊        ┃ │
│ ┗━━━━━━━━━━━━━━━━━━━━━┛ │
│                           │
│ {{{ body }}}              │ ← Contenuto dinamico
│                           │
├───────────────────────────┤
│ 🎄 Lo Staff di            │ ← Footer verde con
│    Sottana Service 🎄     │    branding oro
│ © 2025                    │
└═══════════════════════════┘
```

**Animazioni CSS**:
- `@keyframes snowfall`: Neve che cade con traiettorie realistiche (20 snowflakes, durata 10s-15s)
- `@keyframes bounce`: Decorazioni natalizie che saltellano (🎁🎄 nel box, durata 2s con delay alternati)
- `@keyframes bounce` (header): Christmas tree nel header che saluta (durata 2s infinite)
- Animazioni disabilitate su mobile per performance
- Animazioni disabilitate quando `prefers-reduced-motion: reduce`
- Fallback graceful per Outlook (animazioni disabilitate, layout statico OK)

**Dati Specifici per Template**:
```php
// Esempio utilizzo con Sottana Service
$email = new SpatieEmail($client, 'auguri-natale-sottana');
$email->mergeData([
    'company_name' => 'Sottana Service',
    // Il messaggio di chiusura è già hardcoded nel template
    // ma può essere personalizzato con variabili Mustache se necessario
]);
```

**Note Branding**:
- Template specifico per Sottana Service con messaggi pre-impostati
- Utilizzare logo Sottana Service nella variabile `{{ logo_header }}`
- Colore primario brand #0071b0 utilizzato per evidenziare "Sottana Service" nel testo
- Tono professionale ma festoso, perfetto per comunicazioni istituzionali durante le festività

### 4. christmas-festive.html - Natalizio Festoso

**Quando usare**: Newsletter festive, comunicazioni informali, auguri ufficiali - stile allegro e vivace

**Caratteristiche**:
- 💡 Luci natalizie animate (20 luci rosse/gialle/verdi che lampeggiano)
- ❄️ Neve animata festosa CSS (20 snowflakes)
- 🎨 Colori vivaci: Rosso #DC143C, Verde #228B22, Oro #FFD700
- 🌈 Background festivo: Gradiente rosso-verde vivace
- 📋 Box evidenziato festoso con bordo tratteggiato
- 💡 Luci animate nel bordo superiore/inferiore
- ✨ Emoji festive integrate con animazioni bounce
- Font sans-serif (Arial) per modernità
- Bordo dorato intorno al container

**Visualizzazione**:
```
💡💡💡💡💡  ← Luci animate nel bordo
  ❄  ❄  ❄  ← Neve animata festosa
┌════════════════════════┐ ← Bordo dorato
│ [LOGO]                 │ ← Header rosso-verde vivace
│ 🎄🎅🎁 Buone Feste! 🎁🎅🎄 │
├════════════════════════┤
│ ┌────────────────────┐ │
│ │🎄 CHIUSURA FESTIVITÀ🎄│ │ ← Box tratteggiato con emoji
│ │ 24 Dic - 7 Gen     │ │
│ │ ✨🎉 Ci vediamo! 🎉✨ │ │
│ └────────────────────┘ │
│                        │
│ Contenuto email        │
│                        │
├════════════════════════┤
│ 🎄🎅🎁 © 2025 Company 🎁🎅🎄│ ← Footer verde con luci
└════════════════════════┘
💡💡💡💡💡  ← Luci animate nel bordo
```

**Animazioni CSS**:
- `@keyframes snowfall`: Neve festosa che cade (20 snowflakes)
- `@keyframes blink`: Luci natalizie che lampeggiano (20 luci)
- `@keyframes bounce`: Emoji che saltellano
- `@keyframes lightsMove`: Luci che si muovono nel bordo
- Durata: 10s - 15s per naturalezza
- Disabilitate su mobile per performance
- Fallback graceful per Outlook

### 4. christmas-luxury.html - Natalizio Luxury Premium

**Quando usare**: Comunicazioni di alto livello, clienti premium, auguri istituzionali - stile lussuoso ed esclusivo

**Caratteristiche**:
- ✨ Particelle dorate animate (6 particelle con effetto float-and-glow)
- ❄️ Neve elegante con glow dorato (7 snowflakes con box-shadow)
- ⭐ Stelle luxury animate (4 stelle con effetto twinkle-luxury e rotazione)
- 🎨 Palette luxury: Oro #D4AF37, Rosso bordeaux #8B0000, Burgundy #4A0404, Avorio #FFFFF0
- 🌟 Bordi oro con effetto shimmer animato
- 📋 Box chiusura con doppio bordo oro e decorazioni floccate
- 💎 Background scuro gradient (nero-bordeaux) per contrasto luxury
- Font serif (Didot/Bodoni/Garamond) per eleganza massima
- Shadow effects premium con glow dorato

**Visualizzazione**:
```
  ✨  ⭐  ✨  ← Particelle e stelle dorate animate
┌═══════════════════════════┐ ← Bordo oro shimmer
│ ⭐  [LOGO]  ⭐            │ ← Header rosso burgundy gradient
│  BUONE FESTE             │
│ Auguri dallo Staff       │
├───── ❅ ❅ ❅ ─────────────┤
│ ┏━━━━━━━━━━━━━━━━━━━┓   │
│ ┃ 🎄 CHIUSURA 🎄    ┃   │ ← Box doppio bordo oro
│ ┃ FESTIVITÀ         ┃   │
│ ┃ 24 Dic - 6 Gen    ┃   │
│ ┃ Ci rivediamo      ┃   │
│ ┃ il 7 Gennaio! ✨  ┃   │
│ ┗━━━━━━━━━━━━━━━━━━━┛   │
│                           │
│ Contenuto email           │
│                           │
├───────────────────────────┤
│ ✨ Sottana Service ✨     │ ← Footer burgundy scuro
│ © 2025                    │
└═══════════════════════════┘ ← Bordo oro shimmer
  ✨  ❄  ✨
```

**Animazioni CSS**:
- `@keyframes float-and-glow`: Particelle dorate che salgono fluttuando (6 particelle)
- `@keyframes elegant-snowfall`: Neve elegante con rotazione (7 snowflakes)
- `@keyframes twinkle-luxury`: Stelle che brillano con rotazione (4 stelle)
- `@keyframes shimmer`: Bordi oro con effetto brillante
- Durata: 11s - 18s per movimento naturale e lussuoso
- Disabilitate su mobile per performance
- Fallback graceful per Outlook

**Dati Specifici per Template**:
```php
// Esempio utilizzo con dati custom
$email = new SpatieEmail($client, 'christmas-greetings-premium');
$email->mergeData([
    'company_name' => 'Sottana Service',
    'closure_start' => '24 Dicembre',
    'closure_end' => '6 Gennaio',
    'reopen_date' => '7 Gennaio',
]);
```

### 5. christmas-winter-wonderland.html - Winter Wonderland con Aurora Borealis

**Quando usare**: Comunicazioni magiche e innovative, auguri creativi, eventi speciali - stile moderno e incantevole

**Caratteristiche**:
- 🌌 Aurora Borealis animata (2 wave layers con gradient multicolore)
- ❄️ Snowflakes magici con glow aurora (8 snowflakes con box-shadow colorato)
- ⭐ Northern lights stars (6 stelle con effetto aurora-twinkle)
- ❅ Cristalli di ghiaccio fluttuanti (4 ice crystals con float-crystal)
- 🎨 Palette aurora: Blu #00D9FF, Viola #A855F7, Verde #10B981, Rosa #EC4899
- 🌠 Effetto frosted glass sul container con backdrop-filter blur
- 📋 Box chiusura con glow aurora e border crystal-spin
- 🌈 Bordi con aurora-shift gradient animato (6 colori)
- Font moderno sans-serif (Segoe UI) per leggibilità
- Gradient text con background-clip per titoli

**Visualizzazione**:
```
  🌌 ～ Aurora Borealis ～ 🌌  ← Wave aurora animate
  ❄  ⭐  ❅  ← Snowflakes magici e cristalli
┌═══════════════════════════┐ ← Bordo crystal aurora-shift
│ ⭐  [LOGO]  ⭐            │ ← Header winter sky gradient
│  BUONE FESTE             │ ← Title con text-shadow aurora
│ Auguri dallo Staff ❄     │
├──── ❅ ✦ ❅ ──────────────┤
│ ╔═══════════════════════╗ │
│ ║ ❅ CHIUSURA FESTIVITÀ ❅║ │ ← Box aurora glow
│ ║ Lo studio chiuso      ║ │
│ ║ 24 Dic - 6 Gen        ║ │
│ ║ Ci rivediamo          ║ │
│ ║ il 7 Gennaio! ✨      ║ │
│ ╚═══════════════════════╝ │
│                           │
│ Contenuto email           │
│                           │
├───────────────────────────┤
│ ❄ Sottana Service ✨      │ ← Footer midnight blue
│ © 2025                    │
└═══════════════════════════┘ ← Bordo crystal aurora-shift
  🌌 ～ ✨ ～ 🌌
```

**Animazioni CSS**:
- `@keyframes aurora-flow`: Aurora borealis che scorre (2 wave layers)
- `@keyframes magical-fall`: Snowflakes con glow colorato e rotazione (8 snowflakes)
- `@keyframes float-crystal`: Cristalli di ghiaccio fluttuanti (4 crystals)
- `@keyframes aurora-twinkle`: Stelle northern lights (6 stars)
- `@keyframes crystal-spin`: Decorazioni che ruotano
- `@keyframes aurora-shift`: Gradient multicolore sui bordi
- `@keyframes aurora-button`: Pulsante con gradient animato
- `@keyframes sky-shimmer`: Effetto shimmer su header
- Durata: 3s - 25s per movimento naturale e ipnotico
- Disabilitate su mobile per performance
- Fallback graceful per Outlook

**Dati Specifici per Template**:
```php
// Esempio utilizzo con dati custom
$email = new SpatieEmail($client, 'winter-wonderland-greetings');
$email->mergeData([
    'company_name' => 'Sottana Service',
    'closure_message' => 'Lo studio resterà chiuso',
    'closure_period' => 'dal 24 Dicembre al 6 Gennaio',
    'reopen_message' => 'Ci rivediamo il 7 Gennaio!',
]);
```

### 6. christmas-sottana-elephant.html - Natalizio Sottana Service con Mascotte Elefante

**Quando usare**: Comunicazioni natalizie di Sottana Service con l'elefante mascotte come elemento decorativo principale - design molto natalizio e molto professionale con brand identity elefante

**Caratteristiche**:
- 🐘 **Elefante mascotte prominente**: Logo elefante grande (80px emoji fallback) con animazione wave elegante nell'header
- 🎅 **Cappello Santa sull'elefante**: Decorazione animata con effetto wiggle posizionata sopra il logo/emoji elefante
- 🎄 **Messaggio personalizzato**: "Lo staff di Sottana Service e il nostro elefante mascotte 🐘 augurano a tutti voi e alle vostre famiglie Felici Feste Natalizie!"
- 📋 **Informazioni chiusura**: "L'ufficio sarà chiuso dal 24 dicembre fino al 6 gennaio"
- 🎊 **Riapertura**: "Ci rivediamo il 7 gennaio!"
- 🎨 **Design molto natalizio**:
  - ❄️ 20 fiocchi di neve animati con traiettorie realistiche
  - 🐘 Decorazioni elefante animate nel box (emoji con effetto bounce)
  - 🎄 Header con gradient rosso-verde-rosso e bordo dorato 3px
  - 🌟 Background scuro elegante con animazioni neve
  - 🎅 Cappello Santa animato sull'elefante con movimento naturale
- 💼 **Design molto professionale**:
  - 🎨 Box evidenziato con gradiente oro (#FFF8E1 → #FFECB3) e bordo dorato 3px
  - 📝 Tipografia serif (Georgia) per eleganza
  - 🎨 Colori natalizi: Rosso #C8102E, Verde #006400, Oro #FFD700
  - 🔵 Branding Sottana Service: colore primario #0071b0 evidenziato nel testo
  - 🐘 Emoji elefante nel footer e nel branding per identità brand
  - 📱 Layout responsive completo
  - ♿ Accessibilità WCAG 2.1 (prefers-reduced-motion, aria-label per elefante)

**Visualizzazione**:
```
┌═══════════════════════════════┐
│ 🎅     🎅[🎅 🐘 🎅]🎅     🎁  │ ← Header gradient rosso-verde
│        └─🎅 (hat wiggle)       │ ← Cappello Santa animato
│                                │
│        🐘 (elephant wave)      │ ← Elefante mascotte grande
│      🎄 Buone Feste 🎄         │
│    Sottana Service 🐘          │
├───────────────────────────────┤
│ ┌───────────────────────────┐ │
│ │ 🐘  🎄 Auguri Feste! 🎄  │ │ ← Box oro con elefante
│ │                           │ │
│ │ Lo staff di Sottana       │ │
│ │ Service e il nostro       │ │
│ │ elefante mascotte 🐘      │ │
│ │ augurano Felici Feste!    │ │
│ │                           │ │
│ │ 📅 Chiusura Ufficio       │ │
│ │ Chiuso dal 24 dic         │ │
│ │ al 6 gen                  │ │
│ │ Ci rivediamo il 7 gen! 🎊 │ │
│ └───────────────────────────┘ │
│                                │
│ {{{ body }}}                   │
│                                │
├───────────────────────────────┤
│ 🎄 Lo Staff di Sottana        │
│    Service 🐘                  │ ← Footer con emoji elefante
│ © 2025 Sottana Service         │
└═══════════════════════════════┘
```

**Animazioni CSS**:
- `@keyframes elephant-wave`: Elefante che saluta con movimento leggero (rotazione -3°/+3°)
- `@keyframes hat-wiggle`: Cappello Santa che si muove con rotazione (-5°/+5°)
- `@keyframes bounce`: Decorazioni elefante nel box con movimento verticale
- `@keyframes snowfall`: 20 fiocchi di neve con traiettorie diverse
- Durata: 2s - 3s per animazioni eleganti e professionali
- Animazioni disabilitate su mobile per performance
- Supporto `prefers-reduced-motion` per accessibilità

**Differenze rispetto a christmas-sottana.html**:
- Elefante mascotte grande e prominente nell'header invece di Christmas tree
- Cappello Santa animato posizionato sopra l'elefante
- Messaggio include riferimento esplicito all'elefante mascotte
- Decorazioni nel box con emoji elefante invece di 🎁
- Footer e branding includono emoji elefante per identità brand

**Supporto Logo**:
- Supporta `{{ logo_header }}` (URL immagine)
- Supporta `{{ logo_header_base64 }}` (base64)
- Supporta `{{ logo_svg }}` (SVG)
- Fallback elegante: emoji 🐘 grande (80px) se logo non disponibile

**Dati Specifici per Template**:
```php
// Esempio utilizzo template con mascotte elefante
$email = new SpatieEmail($client, 'sottana-christmas-elephant');
$email->mergeData([
    'company_name' => 'Sottana Service',
    'logo_header' => asset('img/sottana/logo-elephant.svg'), // Logo elefante opzionale
    // Tutte le variabili standard Mustache disponibili
]);
```

---

### 7. christmas-elephant-mascot.html - Natalizio con Elefante Mascotte (Stile Giocoso)

**Quando usare**: Comunicazioni friendly e informali, clienti affezionati, brand identity Sottana Service - stile giocoso ma professionale

**Caratteristiche**:
- 🐘 Elefante mascotte con animazione wave (logo con rotate animation)
- 🎅 Cappello Santa sull'elefante (posizionato sopra logo)
- 🎄 Ornamenti natalizi che dondolano (4 ornaments con swing animation)
- ❄️ Snowflakes gentle (5 snowflakes con gentle-fall)
- 🎩 Party hats animate (2 hats con hat-bounce)
- 💬 Elephant speech bubble (box "l'elefante dice")
- 🐘 Elephant footprints decorativi nel background
- 🎨 Palette friendly: Rosso #DC2626, Verde #059669, Oro #F59E0B, Grigio elefante #6B7280
- 🌟 Bordi pattern a strisce natalizie animate (pattern-slide)
- Font playful (Comic Sans MS/Trebuchet) per tono amichevole
- Elephant walking animation sulle decorazioni del box

**Visualizzazione**:
```
  🎄  🔴  🟢  🔴  ← Ornamenti che dondolano
  ❄  ❅  ❄  ← Snowflakes gentle
┌═══════════════════════════┐ ← Bordo pattern rosso/verde/oro
│ 🎩  [ELEFANTE 🎅]  🎩    │ ← Header verde con party hats
│                           │
│  🎄 BUONE FESTE 🎄        │ ← Title con shadow rosso
│ Auguri dallo Staff di     │
│ Sottana Service!          │
├──── 🎁 🎄 🎁 ────────────┤
│ ┌───────────────────────┐ │
│ │ 💬 L'elefante dice:   │ │ ← Speech bubble
│ │ "Non dimenticare mai  │ │
│ │ i tuoi clienti! 🐘❤️" │ │
│ └───────────────────────┘ │
│                           │
│ 🐘┌─────────────────────┐ │
│  │ 🎅 CHIUSURA 🎄      │ │ ← Box con elefanti animati
│  │ L'elefante riposa!  │ │
│  │ 24 Dic - 6 Gen      │ │
│  │ Ci rivediamo        │ │
│  │ il 7 Gennaio! 🎉🐘  │ │🐘
│  └─────────────────────┘ │
│                           │
│ Contenuto email           │
│                           │
├───────────────────────────┤
│ 🐘 Sottana Service 🐘     │ ← Footer grigio scuro
│ Made with 🐘❤️ and       │
│ Christmas magic ✨        │
│ © 2025                    │
└═══════════════════════════┘ ← Bordo pattern oro/verde/rosso
```

**Animazioni CSS**:
- `@keyframes swing`: Ornamenti che dondolano (4 ornaments)
- `@keyframes gentle-fall`: Snowflakes gentle (5 snowflakes)
- `@keyframes hat-bounce`: Cappelli party che saltellano (2 hats)
- `@keyframes elephant-wave`: Logo elefante che saluta (rotate animation)
- `@keyframes hat-wiggle`: Cappello Santa che si muove
- `@keyframes elephant-walk`: Elefanti decorativi che camminano
- `@keyframes pattern-slide`: Pattern bordi che scorrono
- Durata: 2s - 19s per movimento vivace e friendly
- Semplificate su mobile (logo statico)
- Fallback graceful per Outlook

**Dati Specifici per Template**:
```php
// Esempio utilizzo con mascotte elefante
$email = new SpatieEmail($client, 'elephant-christmas-greetings');
$email->mergeData([
    'company_name' => 'Sottana Service',
    'elephant_message' => 'Il nostro elefante dice: "Grazie per essere stati con noi quest\'anno!"',
    'closure_title' => 'Il nostro elefante si riposa! 🐘😴',
    'closure_dates' => 'dal 24 Dicembre al 6 Gennaio',
    'reopen_message' => 'Ci rivediamo il 7 Gennaio! 🎉🐘',
]);
```

**Note Branding**:
- Template specifico per Sottana Service con brand identity elefante
- Utilizzare logo elefante aziendale nella variabile `{{ logo_header }}`
- Fallback emoji 🐘 se logo non disponibile
- Tono friendly ma professionale, ideale per customer relationship

---

## Utilizzo

### Metodo 1: Automatico con GetMailLayoutAction (Approccio Consigliato - ✅ CORRETTO)

Il sistema utilizza automaticamente `GetMailLayoutAction` che delega a `GetThemeContextAction` per determinare il contesto stagionale:

```php
// File: Modules/Notify/app/Emails/SpatieEmail.php

public function getHtmlLayout(): string
{
    // Delega a GetMailLayoutAction che usa GetThemeContextAction (Xot)
    // Single Source of Truth: la logica stagionale è centralizzata in GetThemeContextAction
    return app(GetMailLayoutAction::class)->execute();
}
```

**Vantaggi**:
- ✅ DRY: Logica stagionale centralizzata in `GetThemeContextAction` (Xot)
- ✅ KISS: Delega semplice, nessuna logica duplicata
- ✅ Automatico: Selezione layout stagionale trasparente
- ✅ Estensibile: Nuovi contesti stagionali gestiti automaticamente

**Flusso**:
1. `SpatieEmail::getHtmlLayout()` → delega a `GetMailLayoutAction`
2. `GetMailLayoutAction::execute()` → usa `GetThemeContextAction` per ottenere contesto (christmas, easter, etc.)
3. `GetMailLayoutAction` → cerca layout in ordine di priorità: `base_christmas.html`, `christmas.html`, `base.html`
4. Restituisce il layout HTML trovato

### Architettura Corretta (DRY + KISS)

```
GetThemeContextAction (Xot) → Determina contesto stagionale
    ↓
GetMailLayoutAction (Notify) → Trova layout appropriato nel tema
    ↓
SpatieEmail → Usa layout stagionale per render email (tramite getHtmlLayout())
```

**Nota Importante**: `RecordNotification` **NON** usa layout stagionali. Genera direttamente `MailMessage` con il contenuto HTML del template. Per layout stagionali, utilizzare `SpatieEmail` che integra `GetMailLayoutAction` tramite il metodo `getHtmlLayout()`.

**Single Source of Truth**: La logica stagionale è centralizzata in `GetThemeContextAction` (modulo Xot), non duplicata.

### Periodi Stagionali Supportati (definiti in GetThemeContextAction)

- **Natale**: 1 Dicembre - 10 Gennaio → `christmas`
- **Pasqua**: Good Friday - Easter Monday → `easter`
- **Estate**: 15 Luglio - 31 Agosto → `summer`
- **Halloween**: 25 Ottobre - 1 Novembre → `halloween`
- **Default**: Tutti gli altri periodi → `default`

**Layout Resolution Order** (in `GetMailLayoutAction`):
1. `base_christmas.html` (se contesto = christmas) - se esiste
2. Layout specificato nel campo `html_layout_path` del MailTemplate (es. `christmas-premium.html`, `christmas-corporate.html`)
3. `christmas-elegant.html` (se contesto = christmas) - se specificato nel MailTemplate
4. `christmas-festive.html` (se contesto = christmas) - se specificato nel MailTemplate
5. `christmas.html` (fallback) - se esiste
6. `base.html` (default finale)

### Vantaggi dell'Approccio Corretto

1. **DRY**: Logica stagionale centralizzata in `GetThemeContextAction` (Xot)
2. **KISS**: Una sola classe (`SpatieEmail`) per tutte le email stagionali
3. **Genericity**: Sistema generico che funziona per tutte le feste automaticamente
4. **Manutenibilità**: Modifiche ai periodi stagionali solo in `GetThemeContextAction`
5. **Scalabilità**: Nuove feste gestite automaticamente senza creare nuove classi
6. **Single Source of Truth**: Una sola fonte di verità per logica stagionale

### Metodo 2: Utilizzo Diretto (Sempre Consigliato)

**❌ MAI creare classi hardcoded per feste specifiche** come `ChristmasEmail`, `EasterEmail`, etc. Queste violano DRY e KISS.

**✅ SEMPRE usare `SpatieEmail`** che automaticamente seleziona il layout stagionale tramite `GetMailLayoutAction`:

```php
// ✅ CORRETTO: Usa SpatieEmail che gestisce automaticamente il layout stagionale
$email = new SpatieEmail($client, 'christmas-greetings');
Mail::to($client->email)->send($email);

// Durante il periodo natalizio (1 Dic - 10 Gen), usa automaticamente christmas.html
// Durante altri periodi, usa base.html o altro layout stagionale appropriato
```

**Perché NON creare `ChristmasEmail extends SpatieEmail`**:
- ❌ Violazione DRY: Duplica logica già in `SpatieEmail` + `GetMailLayoutAction`
- ❌ Violazione KISS: Classe separata per logica semplice
- ❌ Violazione Genericity: Hardcoded per una festa specifica
- ❌ Non riutilizzabile: Serve creare una classe per ogni festa (Natale, Pasqua, etc.)
- ✅ **Soluzione**: `SpatieEmail` già gestisce tutto automaticamente!

## Passaggio Dati ai Template

È possibile passare variabili personalizzate ai template (come codici sconto, link personalizzati, scadenze) utilizzando il metodo `mergeData()` di `SpatieEmail`.

### Esempio Pratico

```php
$email = new SpatieEmail($user, 'auguri-natale');

// Dati dinamici da iniettare nel template
$email->mergeData([
    'discount_code' => 'NATALE2025',
    'expiry_date' => '31/12/2025',
    'gift_url' => route('claim.gift', ['id' => $user->id]),
    'personal_message' => 'Grazie per essere stato con noi quest\'anno!',
]);

Mail::to($user)->send($email);
```

### Utilizzo nel Template (HTML)

Nel file HTML del layout o del `html_template` (DB), i dati sono accessibili tramite sintassi **Mustache**:

```html
<!-- In christmas-elegant.html o nel body -->
<div class="special-offer">
    <h3>Il tuo codice regalo: {{ discount_code }}</h3>
    <p>Valido fino al: {{ expiry_date }}</p>
    <a href="{{ gift_url }}" class="btn">Riscatta Regalo</a>
    <p><em>{{ personal_message }}</em></p>
</div>
```

**Nota**: `{{ variable }}` effettua l'escape dell'HTML. Usa `{{{ variable }}}` se la variabile contiene HTML sicuro.

**Per maggiori dettagli sulle variabili Mustache disponibili, consulta**: [Mustache Variables Documentation](./mustache-variables.md)

---

## ❌ Anti-Pattern: Classi Mailable Hardcoded per Feste

**MAI creare classi separate per feste specifiche** come `ChristmasEmail`, `EasterEmail`, `HalloweenEmail`, etc.

### Perché È Una "Cagata"

**Violazioni Principi**:
- ❌ **Violazione DRY**: Duplica logica già in `SpatieEmail` + `GetMailLayoutAction`
- ❌ **Violazione KISS**: Classe separata per logica semplice
- ❌ **Violazione Genericity**: Hardcoded per una festa specifica
- ❌ **Non Scalabile**: Richiede una classe per ogni festa (Natale, Pasqua, Estate, Halloween, etc.)
- ❌ **Violazione Single Source of Truth**: Logica stagionale duplicata invece di usare `GetThemeContextAction`

### Esempio Errato (DA EVITARE)

```php
// ❌ SBAGLIATO: Classe hardcoded per Natale
namespace Modules\Notify\Emails;

class ChristmasEmail extends SpatieEmail
{
    public function getHtmlLayout(): string
    {
        // Hardcoded: forza sempre layout natalizio
        $xot = XotData::make();
        $pubThemePath = base_path('Themes/'.$xot->pub_theme);
        return file_get_contents($pubThemePath.'/resources/mail-layouts/christmas.html');
    }
}
```

**Problemi**:
- Forza layout natalizio anche fuori stagione
- Non riutilizzabile per altre feste
- Duplica logica di risoluzione layout
- Non rispetta contesto stagionale automatico

### Soluzione Corretta

**✅ SEMPRE usare `SpatieEmail` direttamente**:

```php
// ✅ CORRETTO: Usa SpatieEmail che gestisce automaticamente layout stagionale
$email = new SpatieEmail($client, 'christmas-greetings');
Mail::to($client->email)->send($email);

// Durante periodo natalizio (1 Dic - 10 Gen) → usa automaticamente christmas.html
// Durante altri periodi → usa base.html o altro layout stagionale appropriato
```

**Vantaggi**:
- ✅ Automatico: Layout stagionale selezionato automaticamente
- ✅ Generico: Funziona per tutte le feste senza classi separate
- ✅ DRY: Logica centralizzata in `GetThemeContextAction` (Xot)
- ✅ KISS: Nessuna classe extra, solo `SpatieEmail`

---

## Come Creare Nuovi Template Stagionali

### Step-by-Step

#### 1. Pianificazione

Definisci:
- **Stagione/Evento**: Pasqua, Estate, Halloween, etc.
- **Periodo**: Date inizio/fine
- **Tema visivo**: Colori, font, decorazioni
- **Messaggio speciale**: Comunicazioni specifiche (es. "Chiusura estiva")

#### 2. Design

Crea mockup considerando:
- Compatibilità email clients (no JavaScript!)
- Responsive design
- Accessibilità
- Performance (animazioni leggere)

#### 3. Implementazione

```bash
# 1. Crea file HTML
touch Themes/Sixteen/resources/mail-layouts/easter.html

# 2. Usa base.html come template
cp Themes/Sixteen/resources/mail-layouts/base.html \
   Themes/Sixteen/resources/mail-layouts/easter.html

# 3. Personalizza CSS e HTML
```

**Template Structure** (easter.html esempio):

```html
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>{{ subject }}</title>

    <style>
        /* Reset CSS - OBBLIGATORIO */
        body, table, td { -webkit-text-size-adjust: 100%; }

        /* Easter Theme Colors */
        :root {
            --color-primary: #FFB6C1;      /* Rosa pastello */
            --color-secondary: #90EE90;    /* Verde pastello */
            --color-accent: #FFD700;       /* Oro */
        }

        /* Header pasquale */
        .email-header {
            background: linear-gradient(135deg,
                var(--color-primary) 0%,
                var(--color-secondary) 100%);
        }

        /* Decorazioni a tema */
        .easter-decoration {
            font-size: 24px;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Box messaggio stagionale */
        .holiday-notice {
            background: linear-gradient(135deg, #FFF8DC 0%, #FFFACD 100%);
            border: 2px dashed var(--color-accent);
            padding: 24px;
        }
    </style>
</head>
<body>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <!-- Header -->
                <table width="600" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="email-header">
                            <span class="easter-decoration">🐰</span>
                            <img src="{{ logo_header }}" alt="{{ company_name }}">
                            <span class="easter-decoration">🥚</span>
                        </td>
                    </tr>

                    <!-- Contenuto -->
                    <tr>
                        <td class="email-content">
                            <!-- Messaggio pasquale -->
                            <div class="holiday-notice">
                                <h2>🐣 Buona Pasqua! 🐣</h2>
                                <p>Lo studio osserverà i seguenti orari festivi...</p>
                            </div>

                            <!-- Body dinamico -->
                            {{{ body }}}
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="email-footer">
                            🐰 © {{ year }} {{ company_name }} 🥚
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
```

#### 4. Testing

Testa su vari client (vedi sezione [Testing](#testing))

#### 5. Documentazione

Aggiorna:
- Questo file (`seasonal-email-templates.md`)
- README nel tema (`Themes/Sixteen/resources/mail-layouts/README.md`)
- Config file se usi Metodo 4

---

## Best Practices

### 1. Quando NON Usare Layout Stagionali

❌ **Evita per**:
- Email transazionali critiche (reset password, conferme ordini)
- Alert di sicurezza
- Notifiche di sistema
- Comunicazioni urgenti

✅ **Usa per**:
- Newsletter
- Email marketing
- Comunicazioni di chiusura ufficio
- Auguri ufficiali

### 2. Performance

**CSS Animations**:
- Max 20-30 elementi animati
- Durate 10-20 secondi (non troppo veloci)
- Disabilita su mobile: `@media screen and (max-width: 600px) { .animated { animation: none; } }`
- Fallback graceful per client non supportati

**File Size**:
- Target: < 100KB HTML totale
- Comprimi immagini (WebP con fallback JPEG)
- Usa SVG inline per icone
- Base64 solo per loghi piccoli (<10KB)

### 3. Compatibilità Email Clients

**CSS Support Levels**:

| Feature | Gmail | Outlook 2016+ | Apple Mail | Mobile |
|---------|-------|---------------|------------|--------|
| `@keyframes` | ⚠️ Limitato | ❌ No | ✅ Sì | ✅ Sì |
| `position: absolute` | ✅ Sì | ❌ No | ✅ Sì | ✅ Sì |
| `flexbox` | ❌ No | ❌ No | ⚠️ Parziale | ⚠️ Parziale |
| `grid` | ❌ No | ❌ No | ❌ No | ❌ No |
| `background: linear-gradient` | ✅ Sì | ⚠️ Fallback | ✅ Sì | ✅ Sì |

**Golden Rules**:
1. **Tabelle per layout** (non div/flex/grid)
2. **CSS inline** quando possibile
3. **Width fissi** in px (non %, vw, rem)
4. **Fallback colors** per gradients
5. **Alt text** su tutte le immagini

### 4. Accessibilità

```html
<!-- ARIA Labels -->
<div role="presentation" aria-hidden="true"><!-- Decorazioni --></div>

<!-- Screen Reader Only Text -->
<span class="sr-only">Vai al contenuto principale</span>

<!-- Contrasto Colori -->
<!-- Verifica WCAG AA: ratio minimo 4.5:1 per testo normale -->

<!-- Semantic HTML -->
<table role="presentation"><!-- Layout table --></table>
<table><!-- Data table --></table>
```

### 5. Versionamento

Quando modifichi un layout esistente:

```bash
# Backup versione precedente
cp christmas.html christmas-2024.html

# Modifica
vim christmas.html

# Tag git
git add Themes/Sixteen/resources/mail-layouts/christmas.html
git commit -m "feat(email): update Christmas template 2025 with new animations"
git tag email-christmas-2025
```

---

## Testing

### Checklist Pre-Produzione

- [ ] **Outlook 2016-2021** (Word rendering)
- [ ] **Outlook.com** (web)
- [ ] **Gmail** (web, Android, iOS)
- [ ] **Apple Mail** (macOS, iOS)
- [ ] **Thunderbird**
- [ ] **Yahoo Mail**
- [ ] **Mobile clients** (viewport <600px)
- [ ] **Dark mode** (se supportato)
- [ ] **CSS disabilitato** (fallback)
- [ ] **Immagini bloccate** (alt text)
- [ ] **Screen reader** (NVDA/VoiceOver)

### Strumenti

**Online Testing**:
- **Litmus**: https://litmus.com/ ($$$ - industry standard)
- **Email on Acid**: https://www.emailonacid.com/ ($$$)
- **Mailtrap**: https://mailtrap.io/ (free tier)
- **PutsMail**: https://putsmail.com/ (free - basic)

**Local Testing**:

```bash
# 1. Crea MailTemplate di test
php artisan tinker
>>> $tpl = \Modules\Notify\Models\MailTemplate::create([
...     'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
...     'slug' => 'test-christmas',
...     'subject' => 'Test Christmas Template',
...     'html_template' => '<h1>Test Content</h1><p>This is a test email.</p>',
... ]);

# 2. Invia email di test
>>> $user = \Modules\User\Models\User::first();
>>> $email = new \Modules\Notify\Emails\SpatieEmail($user, 'test-christmas');
>>> \Illuminate\Support\Facades\Mail::to('your-email@example.com')->send($email);

# 3. Controlla inbox e verifica rendering
```

**HTML Validation**:

```bash
# W3C Validator
curl -H "Content-Type: text/html; charset=utf-8" \
     --data-binary @christmas.html \
     https://validator.w3.org/nu/?out=json
```

### Test Matrix Example

| Client | Device | OS | Browser | Animations | Layout | Images |
|--------|--------|----|---------|-----------:|-------:|-------:|
| Gmail | Desktop | Win 11 | Chrome | ⚠️ Partial | ✅ OK | ✅ OK |
| Outlook 2021 | Desktop | Win 11 | - | ❌ No | ✅ OK | ✅ OK |
| Apple Mail | Desktop | macOS | - | ✅ OK | ✅ OK | ✅ OK |
| Gmail | Mobile | iOS 17 | App | ❌ Disabled | ✅ OK | ✅ OK |
| Gmail | Mobile | Android 14 | App | ❌ Disabled | ✅ OK | ✅ OK |

**Legend**:
- ✅ OK: Funziona perfettamente
- ⚠️ Partial: Funziona parzialmente
- ❌ No/Disabled: Non supportato o disabilitato

---

## Troubleshooting

### Problema: Animazioni non visibili

**Causa**: Client non supporta `@keyframes`

**Soluzione**:
- Normale per Outlook - layout degrada gracefully
- Assicurati che contenuto sia leggibile anche senza animazioni

### Problema: Layout rotto su mobile

**Causa**: Width fissi non responsive

**Soluzione**:
```css
@media screen and (max-width: 600px) {
    .email-container {
        width: 100% !important;
        max-width: 100% !important;
    }
}
```

### Problema: Immagini non caricate

**Causa**: Client blocca immagini esterne

**Soluzione**:
- Usa `alt` text descrittivi
- Fallback con `logo_header_base64` (embed base64)
- SVG inline per decorazioni

### Problema: Dark mode rompe colori

**Causa**: Client forza colori dark

**Soluzione**:
```css
@media (prefers-color-scheme: dark) {
    .email-content {
        background-color: #1F2937 !important;
        color: #F9FAFB !important;
    }
}
```

---

## Risorse

### Documentazione

- **Spatie Mail Templates**: https://github.com/spatie/laravel-database-mail-templates
- **Mustache Syntax**: https://mustache.github.io/mustache.5.html
- **Can I Email**: https://www.caniemail.com/ (CSS support checker)
- **Email Design Guide**: https://www.campaignmonitor.com/css/

### Template Libraries

- **MJML**: https://mjml.io/ (responsive email framework)
- **Foundation for Emails**: https://get.foundation/emails.html
- **Cerberus**: https://tedgoas.github.io/Cerberus/ (responsive patterns)

### Tools

- **Maizzle**: https://maizzle.com/ (Tailwind for email)
- **Parcel**: https://parcel-css.github.io/playground/ (CSS email optimizer)

---

## Esempi Pratici

### Caso d'Uso 1: Chiusura Natalizia

**Scenario**: Inviare email di massa ai clienti comunicando chiusura ufficio

**Implementazione**:

```php
// 1. Attiva layout natalizio
// config/notify.php
'seasonal_templates' => [
    'enabled' => true,
    'current_season' => 'christmas',
],

// 2. Crea MailTemplate
$template = MailTemplate::create([
    'mailable' => SpatieEmail::class,
    'slug' => 'closure-christmas-2025',
    'subject' => 'Chiusura Festività Natalizie - {{ company_name }}',
    'html_template' => '
        <p>Gentile {{ first_name }},</p>
        <p>ti informiamo che il nostro studio osserverà la chiusura natalizia
           come indicato nel box sopra.</p>
        <p>Per urgenze puoi contattarci via email.</p>
        <p>Buone Feste!</p>
    ',
]);

// 3. Invia a tutti i clienti
$clients = Client::whereNotNull('email')->get();

foreach ($clients as $client) {
    $email = new SpatieEmail($client, 'closure-christmas-2025');
    Mail::to($client->email)->send($email);
}
```

**Risultato**: Email con layout natalizio, neve animata, box "Chiusura 24 Dic - 7 Gen"

### Caso d'Uso 2: Newsletter Stagionale

**Scenario**: Newsletter con offerta Natale

```php
// ✅ CORRETTO: Usa SpatieEmail direttamente, layout stagionale automatico
// Creare MailTemplate per newsletter natalizia
$template = MailTemplate::create([
    'slug' => 'christmas-newsletter-2025',
    'subject' => '🎄 Offerta Speciale Natale - {{ discount_percentage }}% di sconto!',
    'html_template' => '
        <h2>Ciao {{ first_name }},</h2>
        <p>Approfitta della nostra <strong>offerta natalizia</strong>:</p>
        <ul>
            <li>{{ discount_percentage }}% di sconto su tutti i servizi</li>
            <li>Consulenza gratuita fino al 31 Dicembre</li>
            <li>Gift card da {{ gift_card_value }}€</li>
        </ul>
        <p style="text-align: center;">
            <a href="{{ offer_url }}" class="btn">Scopri l\'offerta</a>
        </p>
    ',
]);

// Invio con dati personalizzati - SpatieEmail gestisce automaticamente layout stagionale
$client = Client::find(1);
$email = new SpatieEmail($client, 'christmas-newsletter-2025');
$email->mergeData([
    'discount_percentage' => 20,
    'gift_card_value' => 50,
    'offer_url' => route('christmas-offer'),
]);

Mail::to($client->email)->send($email);
```

---

## Changelog

### 2025-12-19 - Christmas Templates v4.0 - Luxury, Winter Wonderland & Elephant Mascot

**Aggiunto**:
- ✨ Template `christmas-luxury.html` con tema natalizio luxury premium
  - ✨ 6 particelle dorate animate con effetto float-and-glow (salgono fluttuando)
  - ❄️ 7 snowflakes eleganti con glow dorato e box-shadow
  - ⭐ 4 stelle luxury animate con effetto twinkle-luxury e rotazione
  - 🎨 Palette luxury: Oro #D4AF37, Rosso bordeaux #8B0000, Burgundy #4A0404, Avorio #FFFFF0
  - 🌟 Bordi oro con effetto shimmer animato (gradient shift)
  - 📋 Box chiusura con doppio bordo oro (3px double) e decorazioni floccate
  - 💎 Background scuro gradient (nero-bordeaux) per contrasto luxury
  - Font serif eleganti (Didot/Bodoni/Garamond)
  - Shadow effects premium con glow dorato su tutti gli elementi
  - Per comunicazioni di alto livello, clienti premium, auguri istituzionali
- ✨ Template `christmas-winter-wonderland.html` con aurora borealis
  - 🌌 Aurora Borealis animata con 2 wave layers gradient multicolore
  - ❄️ 8 snowflakes magici con glow aurora e box-shadow colorato
  - ⭐ 6 northern lights stars con effetto aurora-twinkle
  - ❅ 4 cristalli di ghiaccio fluttuanti con animazione float-crystal
  - 🎨 Palette aurora: Blu #00D9FF, Viola #A855F7, Verde #10B981, Rosa #EC4899
  - 🌠 Effetto frosted glass sul container con backdrop-filter blur
  - 📋 Box chiusura con glow aurora e bordi crystal-spin
  - 🌈 Bordi con aurora-shift gradient animato (6 colori)
  - Gradient text con background-clip per titoli
  - Font moderno sans-serif (Segoe UI)
  - Per comunicazioni magiche e innovative, auguri creativi, eventi speciali
- ✨ Template `christmas-elephant-mascot.html` con mascotte elefante Sottana Service
  - 🐘 Elefante mascotte con animazione wave (logo rotate animation)
  - 🎅 Cappello Santa posizionato sull'elefante (absolute positioning)
  - 🎄 4 ornamenti natalizi che dondolano (swing animation)
  - ❄️ 5 snowflakes gentle con gentle-fall animation
  - 🎩 2 party hats animate con hat-bounce
  - 💬 Elephant speech bubble con "l'elefante dice"
  - 🐘 Elephant footprints decorativi nel background (radial-gradient)
  - 🎨 Palette friendly: Rosso #DC2626, Verde #059669, Oro #F59E0B, Grigio elefante #6B7280
  - 🌟 Bordi pattern a strisce natalizie animate (pattern-slide con repeating-linear-gradient)
  - Font playful (Comic Sans MS/Trebuchet)
  - Elephant walking animation sulle decorazioni del box
  - Template specifico per Sottana Service con brand identity elefante
  - Per comunicazioni friendly, clienti affezionati, customer relationship

**Caratteristiche Tecniche**:
- CSS animations email-safe complesse (no JavaScript)
- Multiple animation layers (particelle + neve + stelle + effetti speciali)
- Gradient effects avanzati (linear, radial, multi-stop)
- Text effects con background-clip e -webkit-text-fill-color
- Box-shadow colorati per glow effects
- Transform animations (rotate, translate, scale)
- Fallback graceful per Outlook (animazioni disabilitate, layout statico OK)
- Performance ottimizzata: animazioni disabilitate su mobile
- File size: ~45KB (luxury), ~42KB (winter wonderland), ~38KB (elephant)

**Testing**:
- ✅ Gmail (web, Android, iOS) - supporto parziale animazioni
- ✅ Apple Mail (macOS, iOS) - supporto completo animazioni
- ✅ Outlook.com - layout OK, alcune animazioni limitate
- ⚠️ Outlook 2016-2021 - animazioni disabilitate, degradazione elegante a statico

**Documentazione**:
- 📚 Guida completa utilizzo in `seasonal-email-templates.md`
- 📋 Esempi codice per passaggio dati con `mergeData()`
- 🎨 Visualizzazioni ASCII art dei layout
- 🔧 Lista completa animazioni CSS con durate
- 💡 Note branding per template elephant-mascot

**Utilizzo Raccomandato**:
- `christmas-luxury.html`: Clienti VIP, comunicazioni istituzionali, eventi premium
- `christmas-winter-wonderland.html`: Marketing innovativo, eventi speciali, campagne creative
- `christmas-elephant-mascot.html`: Customer relationship Sottana Service, comunicazioni friendly

### 2025-12-19 - Christmas Templates v3.0 - Premium & Corporate

**Aggiunto**:
- ✨ Template `christmas-premium.html` con tema natalizio premium lussuoso
  - 🎨 Pattern SVG inline natalizio come sfondo (email-safe)
  - ❄️ 10 snowflakes animate con traiettorie realistiche (CSS `@keyframes`)
  - ⭐ 5 stelle brillanti con effetto twinkle sofisticato
  - 💎 Background lussuoso: Gradiente blu notte profondo (#0A0E27 → #1A1F3A)
  - 🏆 Colori premium: Oro #D4AF37, Argento #C0C0C0, Rosso #B91C1C
  - 📋 Box evidenziato premium con bordo dorato, ombre eleganti, effetto glow
  - ✨ Font serif (Georgia) per eleganza classica
  - 💼 Per comunicazioni ufficiali importanti, eventi premium
- ✨ Template `christmas-corporate.html` con tema natalizio corporate minimalista
  - 📐 Design minimalista e professionale
  - 🎨 Pattern sottile CSS repeating-linear-gradient per texture
  - 🔴 Colori corporate: Rosso #DC2626, Verde #16A34A, Oro #CA8A04
  - 💼 Background pulito: Bianco con pattern sottile elegante
  - 📋 Box evidenziato con bordo sinistro colorato (stile corporate)
  - 🔴⚫🟡 Accent dots animati con effetto pulse sottile
  - ✨ Font sans-serif (Helvetica Neue/Arial) per modernità
  - 📱 Supporto dark mode completo
  - 💼 Per comunicazioni business professionali
- 🎄 Decorazioni natalizie (emoji, colori, gradients)
- 📱 Responsive design con disabilitazione animazioni mobile
- ♿ Accessibilità WCAG 2.1 (ARIA, sr-only, alt text, prefers-reduced-motion)
- 📚 Documentazione completa utilizzo + [Mustache Variables Guide](./mustache-variables.md)

**Caratteristiche Tecniche**:
- CSS animations email-safe (no JavaScript)
- Pattern SVG inline per background (email-safe, supportato da molti client)
- Pattern CSS repeating-linear-gradient per texture corporate
- Fallback graceful per Outlook (degradazione elegante a statico)
- Dark mode support completo (corporate)
- Performance ottimizzata (10 snowflakes premium, 3 dots corporate)
- File size: ~35KB (premium), ~22KB (corporate)

**Testing**:
- ✅ Gmail (web, Android, iOS)
- ✅ Apple Mail (macOS, iOS)
- ✅ Outlook.com
- ⚠️ Outlook 2016-2021 (animazioni disabilitate, layout OK, pattern degradano a solid)

### 2025-12-19 - Christmas Templates v2.0

**Aggiunto**:
- ✨ Template `christmas-elegant.html` con tema natalizio elegante
  - ❄️ 15 snowflakes animate + 8 stelle brillanti con CSS `@keyframes`
  - 🌙 Background notturno elegante (gradiente blu notte)
  - 🎨 Colori eleganti: Rosso #C8102E, Verde #165B33, Oro #D4AF37
  - 📋 Box evidenziato dorato con gradiente crema
  - Font serif (Georgia) per eleganza professionale
- ✨ Template `christmas-festive.html` con tema natalizio festoso
  - ❄️ 20 snowflakes animate + 20 luci natalizie lampeggianti
  - 💡 Luci animate nel bordo superiore/inferiore con effetto "lampeggio"
  - 🎨 Colori vivaci: Rosso #DC143C, Verde #228B22, Oro #FFD700
  - 🌈 Background festivo (gradiente rosso-verde vivace)
  - 📋 Box evidenziato festoso con bordo tratteggiato e emoji animate
  - Font sans-serif (Arial) per modernità e leggibilità
  - Bordo dorato intorno al container principale

---

**Creato con ❄️ per le festività 2025-2026**

*"Email is not dead. Email is Christmas cards, and Christmas cards are not dead." - Anonymous Email Marketer*
