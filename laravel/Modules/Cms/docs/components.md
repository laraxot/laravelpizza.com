# Componenti del CMS

## Introduzione

Il CMS utilizza un sistema di componenti modulare per gestire il rendering delle pagine e dei contenuti. Questa documentazione fornisce una panoramica dei componenti principali e delle best practices per il loro utilizzo.

## Componenti Principali

### Page Component

Il componente Page è uno dei componenti fondamentali del CMS. Per una documentazione dettagliata sulle best practices di implementazione e utilizzo, consultare:

- [Best Practices per il Rendering delle Pagine](best-practices/page-rendering.md)

#### Utilizzo Base
```blade
<x-page slug="home" />
```

### Altri Componenti Chiave

- Layout Components
- Block Components
- Navigation Components
- Form Components

## Best Practices Generali

1. **Utilizzare Componenti Blade**
   - Preferire i componenti Blade rispetto alle variabili globali
   - Sfruttare il sistema di componenti di Laravel
   - Mantenere una chiara separazione delle responsabilità

2. **Documentazione**
   - Documentare tutti i componenti pubblici
   - Includere esempi di utilizzo
   - Mantenere aggiornati i riferimenti tra i file di documentazione

3. **Testing**
   - Scrivere test per ogni componente
   - Verificare casi d'uso comuni e edge case
   - Mantenere una buona copertura del codice

## Collegamenti Bidirezionali

- [README](README.md) - Documentazione principale del modulo
- [DaisyUI Componenti](daisyui-componenti.md) - Componenti basati su DaisyUI
- [Componenti Blocchi](componenti-blocchi-contenuto.md) - Componenti per i blocchi di contenuto
- [Componenti Header](componenti-header.md) - Componenti per l'header
- [Componenti Footer](componenti-footer.md) - Componenti per il footer
- [Filament Components](filament-components.md) - Componenti Filament
- [Custom Components](custom-components.md) - Creazione di componenti personalizzati

## Vedi Anche
- [Modulo UI](../UI/docs/README.md) - Componenti UI riutilizzabili
- [Namespace Componenti](namespace-componenti-blocchi.md) - Convenzioni di namespace
- [Standard UI](standard_ui_components.md) - Standard per i componenti UI

## Riferimenti ai File di Implementazione

- `laravel/Modules/Cms/View/Components/`
- `laravel/Modules/Cms/resources/views/components/`
- `laravel/Themes/*/resources/views/components/`

---
@see laravel/Modules/Cms/docs/best-practices/page-rendering.md 

## Collegamenti tra versioni di components.md
* [components.md](laravel/Modules/UI/docs/components.md)
* [components.md](laravel/Modules/UI/docs/themes/components.md)
* [components.md](laravel/Modules/Cms/docs/components.md)
* [components.md](laravel/Themes/One/docs/components.md)

