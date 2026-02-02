# Differenze grafica e miglioramenti

Questo documento analizza in dettaglio le differenze visive tra l'implementazione locale del tema **Meetup** e il sito target `laravelpizza.com`, definendo una roadmap di miglioramento.

**Approfondimento tecnico** (mappatura file, righe di codice, SVG, checklist): [differenze-grafica-approfondimento](differenze-grafica-approfondimento.md).

## 🖼️ Analisi per Sezione

### 1. Header & Navigation
- **Logo**: 
    - *Locale*: Icona pizza curva (SVG) con sfondo rosso.
    - *Target*: Testo "Laravel Pizza Meetups" accanto all'icona.
    - **Miglioramento**: Integrare il testo del brand nel componente logo con il font corretto.
- **Menu**:
    - *Locale*: Include "Events", "Community Chat", "Language Selector", "Theme Toggle".
    - *Target*: Menu più minimalista nel layout desktop.
    - **Miglioramento**: Verificare il padding e la dimensione dei font per maggiore ariosità.

### 2. Hero Section
- **Icona Centrale**: 
    - *Locale*: Pizza slice grande sopra il testo.
    - *Target*: Match quasi identico.
    - **Miglioramento**: Aggiungere una micro-animazione al passaggio del mouse (già presente, da affinare).
- **Testi**:
    - *Locale*: "Laravel Developers. Pizza. Community."
    - *Target*: Identico.
    - **Miglioramento**: Allineamento perfetto del font-weight.

### 3. Features & Body Content
- **Sfondo**:
    - *Locale*: Spesso alterna bianco e grigio chiaro.
    - *Target*: Premium Dark (Slate-950/900).
    - **Miglioramento**: Sostituire `bg-slate-50` con `bg-slate-950` ovunque nel body per mantenere il look "Midnight Pizza".
- **Card**:
    - *Locale*: Background solido.
    - *Target*: Glassmorphism sottile con bordi sfumati.
    - **Miglioramento**: Applicare `backdrop-blur-sm` e `bg-slate-800/40` alle card features.

### 4. CTA (Call to Action)
- **Bottone "Join the Community"**:
    - *Locale*: Rosso vibrante con icone.
    - *Target*: Rosso profondo.
    - **Miglioramento**: Standardizzare l'ombra (`shadow-red-500/20`).

### 5. Footer
- **Struttura**:
    - *Locale*: In fase di definizione.
    - *Target*: Link rapidi, social e copyright.
    - **Miglioramento**: Implementare un footer sticky o minimalista che rispetti la dark mode.

## 🚀 Priorità Miglioramenti

1.  🔴 **Critica**: Enforcement della Dark Mode globale (addio sfondi bianchi).
2.  🟡 **Alta**: Allineamento font e testi del brand nell'header.
3.  🟡 **Alta**: Rifinitura card con effetti glass e gradienti sul bordo.
4.  🟢 **Media**: Animazioni di ingresso (Fade In / Slide Up) per le sezioni.

---
**Visual References**:
- `screenshots/grafica-confronto/local-dev.png`
- `screenshots/grafica-confronto/target-prod.png`
