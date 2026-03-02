# Laravel Pizza HTML Notes

## 👀 Cosa manca ancora
- [ ] Versioni Blade dei layout e componenti HTML
- [ ] Hook tra HTML statico e dati reali (pizze, categorie, ordini)
- [ ] Script per sincronizzare assets (src delle immagini, icone reali)
- [ ] Gestione reale del carrello (backend API)

## ➕ Idee di miglioramento
1. **Animazioni**
   - Introdurre micro-animazioni (hover, focus) con `@keyframes`
   - Aggiungere transizioni su apertura mobile menu/carrello
2. **Accessibilità**
   - Verificare contrasto colori (WCAG AA)
   - Aggiungere `aria-*` a form e navigation
3. **Componenti riutilizzabili**
   - Estrarre card, badge, CTA in partials (`components.html`)
   - Definire uno style guide con esempi
4. **Responsive avanzato**
   - Testare con puppeteer (MCP) su device specifici
   - Ottimizzare layout 2xl + widescreen

## ✅ Fatto
- Versione statica con Tailwind 4
- Palette colori e typography definite
- CTA e form con design coerente
