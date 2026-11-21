---
title: "UI Module — Doctrine"
type: doctrine
tags: [ui, design-system, module-doctrine]
created: 2026-09-05
updated: 2026-09-05
qmd: "UI module doctrine BMAD analysis purpose religion philosophy policy why zen gap enhancements split merge"
related:
  - "../../Xot/docs/module.md"
  - "../../Platform/docs/module.md"
---

# UI Module — Doctrine

## Scope (Scopo)

UI è il sistema di design e componenti riutilizzabili del monorepo. Fornisce componenti Filament/Folio/Volt condivisi, temi, pattern di layout, e convenzioni di stile che garantiscono coerenza visiva su tutti i moduli. Ogni modulo Filament usa i componenti UI invece di implementare i propri.

## Religion (Religione)

**"Una libreria di componenti, usi infiniti. Filament per admin, Folio+Volt per pubblico, DRY ovunque."** UI non duplica mai: un componente scritto una volta è usato da tutti i moduli. Il design system è la Bibbia visuale: ogni colore, ogni spacing, ogni tipografia è definito una sola volta.

## Philosophy (Filosofia)

- **Xot-first components**: ogni componente UI estende un componente XotBase, mai Filament diretto
- **Theme-aware styling**: i componenti rispettano il tema attivo (chiaro/scuro/custom)
- **i18n per ogni label**: nessun testo hardcoded, tutto traducibile
- **Composability over inheritance**: i componenti si compongono, non si estendono

## Policy (Politica)

- Nessun colore hardcoded: tutto passa per CSS variables o config
- Ogni componente deve avere varianti: default, success, warning, danger
- Ogni componente deve essere testato in almeno 3 contesti (admin, public, email)
- Accessibilità WCAG 2.1 AA minima per ogni componente

## Why (Perché)

UI esiste perché senza un design system condiviso, ogni modulo avrebbe implementato i propri pulsanti, tabelle, form, layout — con risultati visivamente incoerenti e manutenzione impossibile. UI è il garante della coerenza visiva su 47 moduli.

## Zen

*"Vedi una volta, riutilizza per sempre. Aggiorna una volta, tutto cambia ovunque."*

## Gap

- Theme system documentation incompleta
- TypeScript definitions limitate
- Solo 6 Actions (vs. 20+ in altri moduli) — UI è più dichiarativo che operativo
- Manca documentazione per varianti custom dei componenti

## Add

- Theme presets predefiniti (corporate, minimalist, vibrant)
- Più varianti di componenti (dark mode variants, high-contrast mode)
- Pattern library con esempi visivi per ogni componente
- Storybook-style documentation con preview interattivo
- TypeScript types per tutti i componenti Vue/Livewire

## Split/Merge

**Mantenere come-is, ma estrarre Components/Widgets/Themes come sotto-domini se crescono.** UI è un design system che potrebbe essere frammentato in sotto-sistemi (Components, Widgets, Themes) se la complessità lo giustifica, ma attualmente è coerente come unità singola.

## Future Enhancements

1. **Theme engine visuale**: builder di temi drag-and-drop con preview live
2. **Component marketplace**: repository di componenti UI custom condivisibili tra moduli
3. **Design tokens API**: endpoint REST per consumare design tokens da app esterne
4. **Component performance metrics**: tracciamento di render time per ogni componente
5. **A/B testing framework**: varianti di componenti testabili in produzione
6. **Component accessibility auditor**: tool che verifica WCAG compliance automatica
