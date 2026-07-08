# Converti pagina: Assistenza - Dati (assistenza-01-dati.html)

## Obiettivo
Portare la pagina locale `http://127.0.0.1:8000/it/tests/assistenza-01-dati` al **95%+ di parità visiva e strutturale** con il riferimento Bootstrap Italia.

## Riferimento
- **Reference:** https://italia.github.io/design-comuni-pagine-statiche/sito/assistenza-01-dati.html
- **Locale:** http://127.0.0.1:8000/it/tests/assistenza-01-dati

## Descrizione
Support request step 1: data entry.

## Attività
- [ ] Fetch reference HTML: `curl -sL https://italia.github.io/design-comuni-pagine-statiche/sito/assistenza-01-dati.html > docs/visual-comparison/reference-assistenza-01-dati.html`
- [ ] Fetch local HTML: `curl -s http://127.0.0.1:8000/it/tests/assistenza-01-dati > docs/visual-comparison/local-assistenza-01-dati.html`
- [ ] Analyze structural differences (body content, excluding scripts)
- [ ] Screenshot comparison (reference vs local at 1920x1080)
- [ ] Create/update JSON content file: `config/.../content/pages/tests.assistenza-01-dati.json`
- [ ] Create/update Blade templates in `Themes/Sixteen/resources/views/components/blocks/`
- [ ] Add missing CSS to `bootstrap-italia.css`
- [ ] Run `npm run build && npm run copy`
- [ ] Verify structural match (component classes, data-element attributes)
- [ ] Update comparison doc: `docs/visual-comparison/ASSISTENZA-01-DATI-COMPARISON.md`
- [ ] Update theme index: `docs/00-index.md`

## Priorità
**MEDIUM**

## Criteri di Accettazione
1. Stessi elementi strutturali (divs, sections, containers) del reference
2. Stesse classi componente (cmp-*, it-*)
3. Stessi attributi data-element
4. Layout responsive (mobile-first)
5. NO Bootstrap Italia CDN - solo Tailwind CSS + Alpine.js
6. Documentazione aggiornata con link bidirezionali

## Note
- Il file .json contiene testi e immagini
- Le blade contengono la struttura HTML
- I CSS sono in `Themes/Sixteen/resources/css/bootstrap-italia.css`
- Build: `cd Themes/Sixteen && npm run build && npm run copy`
