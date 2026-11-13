# Geo Module — daisyUI Documentation

## Panoramica

[daisyUI](https://daisyui.com/) è la libreria di componenti UI per Tailwind CSS più popolare al mondo (40.9k ⭐ GitHub).
Nel contesto del modulo **Geo**, daisyUI **non è attualmente installato**.

| Attributo | Valore |
|-----------|--------|
| NPM package (canonico nel tema Sixteen) | `daisyui@^5.5.19` (aggiornato 2026-05-16 da v4 — incompatibile con Tailwind v4) |
| Installato in Geo? | ❌ No (e non serve — vedi sotto) |
| Tailwind CSS in Geo | ✅ `tailwindcss@^3.4.1` (autonomo, solo utility) |
| Build pipeline | `vite build` + `copy` → `public_html/assets/geo` |
| Stack canonico | Tailwind v4 + DaisyUI v5 + Filament v5 + Alpine + Lit (definito nel tema, vedi `laravel/Themes/Sixteen/docs/DAISYUI.md`) |

---

## Perché Geo non usa daisyUI (e perché non serve)

Il modulo **Geo** gestisce asset pubblici autonomi: `coordinate-picker-lit`, `map-lit`, widget mappa Leaflet.
Tutti questi componenti utilizzano:

- **Lit** (Web Components) per il rendering UI
- **Leaflet.js** per la mappa
- Tailwind CSS 3.x per utility class (non componenti)

DaisyUI è un **plugin Tailwind CSS** che aggiunge classi semantiche e componenti CSS predefiniti.
Poiché il modulo Geo non ha un'UI di backend Filament propria (i form Filament sono nel tema), **non ha senso installare DaisyUI nel modulo**.

L'integrazione UI del modulo avviene a livello di **tema Sixteen**, che ospita:
- `coordinate-picker-lit` (Web Component esposto nel tema)
- `selectAddressField` (componente Filament esposto dal tema)
- `MapPickerField` (componente Filament)

---

## Ruolo di daisyUI in Geo (consumatore indiretto)

Il modulo Geo **consuma daisyUI indirettamente** tramite il **tema Sixteen** quando:

1. Le pagine front-office caricano `app.css` del tema → regole daisyUI disponibili
2. Il componente `coordinate-picker-lit` è montato nel DOM della pagina front-office

| Componente Geo | Dipende da DaisyUI? | Note |
|---------------|---------------------|------|
| `coordinate-picker-lit` | ⚠️ Indiretto | Usa classi CSS del tema; il CSS include regole DaisyUI se abilitate |
| `MapPickerField` (Filament) | ❌ No | Stile gestito dal Filament `fi-*` classes, non daisyUI |
| `AddressInput` (Filament) | ❌ No | Usa Bootstrap Italia markup convertito a Tailwind |

---

## Pro e contro di adottare daisyUI in Geo

### ✅ Pro

| Avantaggio | Contesto Geo |
|------------|--------------|
| Classi semantiche (`.btn`, `.alert`, `.badge`) | Ridurrebbero il numero di utility Tailwind manuali nel CSS del modulo |
| 35 temi built-in | Utile per la mappa: tema `dark` / `night` / `forest` per la UI di ricerca indirizzi |
| CSS variables centralizzate | `--color-primary`, `--color-base-100` per riutilizzo tra `coordinate-picker-lit` e `map-lit` |
| Bundle piccolo | Solo componenti utilizzati: ~10 KB gzip per `btn + input + card` |

### ❌ Contro

| Problema | Contesto Geo |
|----------|--------------|
| Tailwind v4 in build Sixteen confligge con Tailwind v3 nel modulo | Il modulo Geo usa Tailwind v3 (`^3.4.1`) → incompatibile diretta con DaisyUI v5 |
| Doppia istallazione daisyUI (tema + modulo) = CSS rules duplicate | Due versioni di daisyUI nel bundle finale app.css |
| Lit Web Components non hanno bisogno di classi CSS predefinite | `coordinate-picker-lit` costruisce il suo DOM e stili programmaticamente, non usa classi HTML statiche |
| Aumento bundle | Il modulo pubblica in `public_html/assets/geo/` un CSS indipendente; aggiungere daisyUI aumenta `coordinate-picker-lit.css` di ~10–30 KB |

---

## Percentuali e metriche

| Metrica | Valore |
|---------|--------|
| Tailwind v3 vs v4 in progetto | Geo: v3, Sixteen: v4 (incompatibilità diretta) |
| Sovrapposizione daisyUI (tema vs modulo) | ~40% delle regole daisyUI duplicate se entrambi installati |
| Bundle coordinate-picker-lit.css attuale | < 5 KB gzip (solamente Lit + Leaflet CSS) |
| Impatto se aggiunto daisyUI a Geo | +15–30 KB gzip al bundle del modulo |

---

## Raccomandazioni

1. **Non installare daisyUI nel modulo Geo** — usa Tailwind v3 puro come già configurato
2. **I componenti UI del modulo (coordinate-picker-lit)** consumano le regole CSS dal tema Sixteen
3. **Se serve un componente UI nuovo** nel modulo: crearlo in `resources/js/components/` con utility Tailwind e duplicarlo nel tema Sixteen
4. **Tailwind v4迁移** per il modulo Geo: attendere che `daisyui` v5 sia stable con Tailwind v4 PnP setup
5. **Monitor versione daisyUI**: il tema Sixteen usa v4, quando v5 sarà adottata bisognerà aggiornare anche il modulo (se usato autónomo)

---

*Documento: Geo/daisyUI-docs — creato 2026-05-16, aggiornato 2026-05-16 (upgrade DaisyUI v5)*
*Modulo: `laravel/Modules/Geo/` — NPM: `tailwindcss@^3.4.1`, `daisyui` non installato*

---

## Decisione architetturale (2026-05-16)

Stack canonico del progetto: **Tailwind v4 + DaisyUI v5 + Filament v5 + Alpine + Lit**,
con **nomi classi CSS e HTML semantico allineati a
[italia/design-comuni-pagine-statiche](https://github.com/italia/design-comuni-pagine-statiche/tree/main/src/stylesheets)**.

Per il modulo Geo l'implicazione è:

- I Web Component Lit (`coordinate-picker-lit`, `map-lit`) restano l'API canonica per la mappa.
- I template Blade del modulo (se ce ne sono) devono usare i nomi delle classi
  design-comuni (`.cmp-card`, `.form-control`, `.cmp-input__label`, ecc.) — **non**
  classi Bootstrap-Italia legacy né classi DaisyUI direttamente nel markup.
- Lo styling viene dalla pipeline del tema Sixteen: alias `@apply` in
  `resources/css/components/` legano i nomi design-comuni a un cluster di utility
  Tailwind (eventualmente componenti DaisyUI come `btn`, `card`).

Doc canonico (con pro/contro/percentuali completi): `laravel/Themes/Sixteen/docs/DAISYUI.md`.
