---
type: reference
module: Cms
tags: [daisyui, tailwind, metriche, governance, fixcity, sixteen]
updated: 2026-05-15
---

# DaisyUI: pro, contro e percentuali

Documento di riferimento condiviso per moduli e temi. **SSoT** per valutazioni su [DaisyUI](https://daisyui.com/docs/) nel progetto.

## Pro

| Pro | Perché conta nel progetto |
|-----|---------------------------|
| **Velocità di consegna** | Classi semantiche (`btn`, `card`, `modal`, …) riducono tempo su CRUD-like e blocchi ripetitivi. |
| **Solo CSS** | Nessun runtime JS DaisyUI; si integra con **Alpine** e **Lit** senza lock-in proprietario. |
| **Temi e varianti** | `tailwind.config.js` → tema `light` / estensioni coerenti con Tailwind v4 pipeline del tema Sixteen. |
| **DX** | HTML più leggibile rispetto a lunghe stringhe di utility grezze; utile per blocchi CMS e prototipi. |
| **MCP ufficiale** | Blueprint tramite `npx -y daisyui@latest mcp` (vedi modulo UI). |

## Contro

| Contro | Mitigazione nel progetto |
|--------|-------------------------|
| **Collisione lessico con Bootstrap Italia / Design Comuni** | Stesso vocabolario (`btn`, `card`, `dropdown`, …) può confondere: la resa dipende dall’ordine CSS e dal plugin. Mantenere [parity Design Comuni](../../../Themes/Sixteen/docs/wiki/entities/design-comuni-class-mapping.md) come priorità. |
| **Peso CSS potenziale** | Il plugin genera stili per molti componenti; il purge Tailwind limita il risultato finale, ma va verificato dopo ogni ampliamento `content`. |
| **Accoppiamento major Tailwind** | Aggiornare Tailwind/Daisy in lockstep; testare `npm run build` nel tema Sixteen. |
| **Filament v5 (`fi-*`)** | Form e wizard usano DOM Filament: DaisyUI non sostituisce i componenti Filament; servono layer dedicati (es. `filament-wizard-parity.css`). |
| **Allineamento PA** | Per contrasti e pattern AgID, spesso servono **override** rispetto al tema Daisy “generico”. |

## Tailwind: `@apply` come alias (preferenza progetto)

Anche quando si usano classi **DaisyUI** o utility Tailwind, nel nostro stack la forma **più pulita** resta definire **componenti/alias nel CSS del tema** con `@apply`, e lasciare nel Blade i **nomi semantici** (Design Comuni / BI / nomi interni controllati) — così Daisy e Tailwind concorrono all’implementazione, non al markup rumoroso.

Riferimento filosofia: [bootstrap-italia-tailwind-philosophy](../../../Themes/Sixteen/docs/wiki/concepts/bootstrap-italia-tailwind-philosophy.md).

## Percentuali e metriche

Le percentuali sono **tipizzate**: non mescolare numeri di origine diversa senza leggere l’etichetta.

### A — Numeri dichiarati da DaisyUI (materiale promozionale / confronti)

Fonte tipica: comunicazioni sul sito DaisyUI (landing, blog). **Non** sono misurazioni indipendenti sul repository Fixcity.

| Metrica | Valore dichiarato | Nota |
|---------|-------------------|------|
| Riduzione **numero di classi** nell’HTML di esempio | fino a **~88%** | Scenario dimostrativo vendor; dipende dal markup prima/dopo. |
| Riduzione **dimensione DOM** (sempre scenario demo) | fino a **~79%** | Stesso caveat: non replicato automaticamente sul nostro frontoffice. |

**Uso interno:** utili per **storytelling** e orientamento (“meno verbosity”), non come KPI di sprint senza benchmark locale.

### B — Pesi governance visiva (progetto Fixcity / pub_theme Sixteen)

Ordine di priorità quando due approcci entrano in conflitto. **Somma = 100%** (modello decisionale, non LOC né byte CSS).

| Layer | Peso | Ruolo |
|-------|------|--------|
| Contratto **Design Comuni** / classi `.it-*`, `.cmp-*`, semantica PA | **45%** | Vincolante su header, stepper pubblici, pagine istituzionali. |
| **Tailwind** (utility + `@apply` nel tema) | **30%** | Fondamento del build Sixteen. |
| **DaisyUI** (classi componente) | **15%** | Solo dove non viola il layer PA e non duplica Filament senza motivo. |
| **Filament v5** + CSS di parity (`.fi-*`) | **10%** | Wizard, form livewire, aree admin / bridge pub. |

### C — Quota tecnica nel bundle (indicativa, non congelata)

| Voce | Ordine di grandezza | Come aggiornare |
|------|---------------------|-----------------|
| Contributo **DaisyUI** al CSS compilato | variabile (purge + tema) | `cd laravel/Themes/Sixteen && npm run build` → analizzare chunk CSS (es. `app-*.css`) rispetto a commit baseline. |
| Uso classi “stile Daisy” nel markup (`btn btn-primary`, `toggle`, `input-bordered`, …) | diffuso in **overlap** con BI | Le classi `btn-*` sono condivise tra mondi; conta **chi applica lo stile** (ordine layer + `tailwind.config`). |

Non pubblicare percentuali “di adozione DaisyUI” senza uno script di audit concordato (es. regex su classi esclusive `*-bordered`, `toggle-*`, `collapse-title`, ecc.).

## Collegamenti

- [DaisyUI componenti (guida lunga)](./daisyui-componenti.md)
- [Documentazione ufficiale](https://daisyui.com/docs/)
- Mapping PA / Tailwind / Filament: [design-comuni-class-mapping](../../../Themes/Sixteen/docs/wiki/entities/design-comuni-class-mapping.md)
- Sintesi **tema Sixteen** (overlay): [daisyui-pro-contro-metriche](../../../Themes/Sixteen/docs/wiki/concepts/daisyui-pro-contro-metriche.md)
