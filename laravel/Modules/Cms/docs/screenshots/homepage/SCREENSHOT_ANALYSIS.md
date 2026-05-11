# 📸 Screenshot Analysis - Homepage FixCity

## Reference: Bootstrap Italia

### 1. Header Structure
```
Screenshot: header_bootstrap_italia.png
URL: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html
```

**Elementi Chiave:**
- Slim header con Regione a sinistra
- Language switcher (ITA/ENG) a destra
- Login button "Accedi all'area personale"
- Logo Comune con subtitle
- Social icons allineate
- Search button
- Navigation bar con 4 voci principali

**Colori:**
- Primary: `#0066CC`
- Background: `#FFFFFF`
- Text: `#1A1A1A`
- Hover: `#0052A3`

---

### 2. Hero Section
```
Screenshot: hero_bootstrap_italia.png
```

**Layout:**
- Titolo "CONTENUTI IN EVIDENZA" centrato
- Card singola con immagine a destra (50%)
- Testo a sinistra (50%)
- Categoria + data in alto
- Titolo notizia H3
- Excerpt testo
- Tag badge
- Link "Tutte le novità"

**Dimensioni:**
- Section padding: `3rem` (py-5)
- Card max-width: `800px`
- Image aspect ratio: `4:3`

---

### 3. Governance Cards
```
Screenshot: governance_bootstrap_italia.png
```

**Layout:**
- 3 card orizzontali
- Stessa altezza (`h-100`)
- Icona o immagine a destra (opzionale)
- Categoria in uppercase small
- Titolo H5
- Descrizione
- Button "Vai alla pagina"

**Colori:**
- Background section: `#F5F6F7` (bg-light)
- Card background: `#FFFFFF`
- Shadow: `0 2px 4px rgba(0,0,0,0.1)`

---

### 4. Events Calendar
```
Screenshot: events_bootstrap_italia.png
```

**Layout:**
- Titolo "EVENTI" + mese "SETTEMBRE 2022"
- Lista verticale di date
- Ogni data: box con giorno (15) e weekday (LUN)
- Lista eventi sotto ogni data
- Link "Vai al calendario eventi"

**Colori:**
- Date header: `#0066CC` (primary)
- Background box: `#F5F6F7`
- Text hover: `#0066CC`

---

### 5. Topics Grid
```
Screenshot: topics_bootstrap_italia.png
```

**Layout:**
- 4 card in prima riga
- Card "Altri Argomenti" sotto
- Ogni card: titolo uppercase, descrizione, lista (opzionale), button
- Link "Mostra tutti"

**Dimensioni:**
- Card width: `25%` (col-lg-3)
- Gap: `1.5rem` (g-4)

---

### 6. Footer
```
Screenshot: footer_bootstrap_italia.png
```

**Sezioni:**
1. Feedback module (stelle 1-5)
2. Quick actions (Contatta, Problemi, Cerca)
3. 5 colonne sitemap
4. Bottom bar con social e legal

**Colori:**
- Background: `#1A1A1A` (dark)
- Text: `#FFFFFF`
- Links: `#CCCCCC`
- Hover: `#FFFFFF`

---

## FixCity Current State

### Screenshots
```
Screenshot: fixcity_header_current.png
Screenshot: fixcity_hero_current.png
Screenshot: fixcity_governance_current.png
Screenshot: fixcity_events_current.png
Screenshot: fixcity_topics_current.png
Screenshot: fixcity_footer_current.png
URL: http://fixcity.local/it/tests/homepage
```

### Differenze Principali

| Elemento | Bootstrap Italia | FixCity | Status |
|----------|-----------------|---------|--------|
| Header slim | ✅ Presente | ❌ Assente | 🔴 |
| Hero card-teaser | ✅ Sì | ❌ No | 🔴 |
| Governance bg-light | ✅ #F5F6F7 | ⚠️ Tailwind | 🟡 |
| Events calendar-list | ✅ Sì | ❌ No | 🔴 |
| Topics uppercase | ✅ Sì | ⚠️ Parziale | 🟡 |
| Footer feedback | ✅ Stelle | ❌ Assente | 🔴 |

---

## Action Plan

### Fix Immediati (🔴 Alta Priorità)

1. **Header Slim**
   - File: `components/layout/header-slim.blade.php`
   - Tempo: 1h
   - Difficoltà: Bassa

2. **Hero Card-Teaser**
   - File: `components/blocks/hero/homepage.blade.php`
   - Tempo: 30min
   - Difficoltà: Bassa

3. **Events Calendar-List**
   - File: `components/blocks/events/calendar.blade.php`
   - Tempo: 1h
   - Difficoltà: Media

### Fix Secondari (🟡 Media Priorità)

4. **Governance Grid**
   - File: `components/blocks/governance/cards.blade.php`
   - Tempo: 30min
   - Difficoltà: Bassa

5. **Topics Uppercase**
   - File: `components/blocks/topics/highlight.blade.php`
   - Tempo: 15min
   - Difficoltà: Bassa

6. **Footer Feedback**
   - File: `components/footer/full.blade.php`
   - Tempo: 2h
   - Difficoltà: Alta

---

## Testing Checklist

- [ ] Header slim visibile su desktop
- [ ] Hero card allineata correttamente
- [ ] Governance cards stessa altezza
- [ ] Events calendar scrollabile
- [ ] Topics responsive (mobile/desktop)
- [ ] Footer feedback module funzionante
- [ ] Conformità accessibilità WCAG 2.1 AA
- [ ] Testing cross-browser (Chrome, Firefox, Safari)
- [ ] Testing responsive (mobile, tablet, desktop)

---

**Data Analisi**: {{ date('Y-m-d') }}  
**Analista**: AI Agent  
**Prossima Review**: Dopo fix Fase 1
