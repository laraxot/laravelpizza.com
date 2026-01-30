# Confronto motori PDF (Html2Pdf vs Spatie laravel-pdf) e strategia export grafici

Questo documento chiarisce **quale engine PDF usare** nel monolite Laraxot per i report “stile LimeSurvey” (dashboard + export PDF con grafici) e come si inserisce **JPGraph** nella pipeline.

## Contesto: cosa stiamo esportando

Nel nostro stack ci sono due famiglie di output:

- **Dashboard (Filament 4)**: grafici interattivi con Chart.js (client-side)
- **PDF (report)**: documento statico, stampabile, spesso generato in batch

Per i PDF con grafici, la strategia più affidabile rimane: **PNG server-side → embedding nel PDF**.

## Html2Pdf (spipu/html2pdf)

### Cos’è (Html2Pdf)

Libreria PHP che converte HTML in PDF. Richiede PHP >= 7.2 + estensioni `gd` e `mbstring`.

Caratteristiche chiave (da doc ufficiale):

- richiede **HTML 4.01 valido** e “pulito”
- è consigliato usare tag specifici come `<page>`, `<page_header>`, `<page_footer>`, `<nobreak>`
- controlli utili:
  - `setTestIsImage(false)` per bypassare il check immagini (utile in debug)
  - `setTestTdInOnePage(false)` per tabelle lunghe (con cautela)
  - `setModeDebug()` per debug risorse

Riferimenti:

- [spipu/html2pdf (GitHub)](https://github.com/spipu/html2pdf)
- [Html2Pdf docs README](https://raw.githubusercontent.com/spipu/html2pdf/master/doc/README.md)

### Pro (Html2Pdf)

- **Zero Chromium**: solo PHP
- buono per ambienti “chiusi” (no dipendenze headless browser)
- pipeline già presente nel progetto (`Spipu Html2Pdf` + embedding immagini)

### Contro (Html2Pdf)

- supporto HTML/CSS limitato rispetto ad un browser moderno
- richiede HTML “pulito” e spesso tag specifici Html2Pdf

### Quando usare Html2Pdf in Laraxot

- report batch (queue)
- ambienti server senza Chromium
- layout controllato (template Blade mirati per Html2Pdf)

## Spatie laravel-pdf (spatie/laravel-pdf)

### Cos’è (Spatie laravel-pdf)

Package Laravel per generare PDF da Blade view usando **Chromium** (via Browsershot). Supporta CSS moderni (flex, grid, Tailwind).

Riferimenti:

- [spatie/laravel-pdf (GitHub)](https://github.com/spatie/laravel-pdf)
- [Spatie laravel-pdf docs: introduction](https://spatie.be/docs/laravel-pdf/v1/introduction)

### Pro (Spatie laravel-pdf)

- rendering “browser-grade” (CSS moderno)
- ottimo per layout complessi e design system (Tailwind)

### Contro (Spatie laravel-pdf)

- richiede Chromium + dipendenze Browsershot/Puppeteer
- più “pesante” operativamente (memoria/CPU) e più fragile in ambienti non standard

### Quando usare Spatie laravel-pdf in Laraxot

- PDF con layout molto complesso che Html2Pdf non riesce a rendere
- quando si vuole usare Tailwind/CSS moderno senza compromessi

## JPGraph nella pipeline (render immagini per PDF)

JPGraph è il nostro **renderer server-side** per generare immagini (PNG) di alta qualità da inserire nel PDF.

Punti chiave:

- output tipico: PNG via `Stroke()`
- usato nel progetto tramite Actions del modulo `Chart` (`Modules\Chart\Actions\JpGraph\V1\*Action`)

Riferimenti:

- [JPGraph](https://jpgraph.net/)
- `jpgraph-step-by-step-guide.md`

## Strategia consigliata per report “stile LimeSurvey”

### 1) Dashboard (Filament 4)

- ChartWidget Filament (Chart.js)
- filtri globali: `DashboardFilterData`

### 2) Export PDF (report)

Preferire:

1. **Query + aggregazioni** (SurveyResponse + DashboardFilterData)
2. **Render grafici server-side** (JPGraph → PNG)
3. **Embedding nel template** (`<img src="...">` con base64 o path assoluto)
4. **Conversione PDF**
   - default: Html2Pdf
   - alternativa: Spatie laravel-pdf quando serve CSS moderno

## Nota su LimeSurvey upstream

LimeSurvey upstream genera statistiche e PDF con una pipeline differente (pChart) e con copertura limitata per casi enterprise.

Riferimento:

- [LimeSurvey Manual: Statistics](https://www.limesurvey.org/manual/Statistics)
