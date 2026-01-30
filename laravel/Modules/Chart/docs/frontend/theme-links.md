# Link alle Documentazioni dei Temi

> Questo documento è un indice centralizzato con collegamenti alla documentazione sui temi nei vari moduli.

## Documentazione Temi nel Modulo Cms

- [Compilazione dei Temi](laravel/Modules/Cms/docs/theme_compilation.md) - Processo di compilazione e pubblicazione dei temi
- [Processo di Build del Tema](laravel/Modules/Cms/docs/theme-build-process.md) - Dettagli sul processo di build
- [Collegamenti Temi e UI](laravel/Modules/Cms/docs/themes-ui-link.md) - Collegamenti bidirezionali tra Cms e UI per i temi
- [Frontoffice](laravel/Modules/Cms/docs/frontoffice.md) - Documentazione completa sul frontend

## Documentazione Temi nel Modulo UI

- [Collegamenti ai Temi nel Cms](laravel/Modules/UI/docs/cms-themes-link.md) - Collegamenti bidirezionali tra UI e Cms per i temi
- [Componenti UI](laravel/Modules/UI/docs/README.md) - Panoramica dei componenti UI disponibili

## Tema One (laraxot/theme_one_fila3)

Questo tema è un pacchetto riutilizzabile che può essere utilizzato in progetti diversi.

- [Documentazione Build Process](laravel/Themes/One/docs/build-process.md)
- [Documentazione Componenti](laravel/Themes/One/docs/COMPONENTS.md)
- [Documentazione Assets](laravel/Themes/One/docs/ASSETS.md)
- [Language Switcher Implementation](laravel/Themes/One/docs/language-switcher-implementation.md)
- [Documentazione Best Practices](laravel/Themes/One/docs/best-practices.md)
- [Documentazione Personalizzazione](laravel/Themes/One/docs/README.md)

## Tema Two

- [Documentazione Build Process](laravel/Themes/Two/docs/build-process.md)
- [Documentazione Componenti](laravel/Themes/Two/docs/COMPONENTS.md)
- [Documentazione Assets](laravel/Themes/Two/docs/ASSETS.md)
- [Documentazione Best Practices](laravel/Themes/Two/docs/best-practices.md)

## Guida Rapida alla Compilazione dei Temi

Per compilare e pubblicare un tema:

1. Entrare nella directory del tema:
   ```bash
   cd /var/www/html/base_<nome progetto>/laravel/Themes/One
   ```

2. Compilare gli asset:
   ```bash
   npm run build
   ```

3. Pubblicare gli asset compilati:
   ```bash
   npm run copy
   ```

Per maggiori dettagli, consultare la [documentazione completa sulla compilazione dei temi](laravel/Modules/Cms/docs/theme_compilation.md).

# Collegamenti Temi Frontend

## Componenti Disponibili

### Componenti Blocks
- [Calendar Component](./calendar-component.md) - Componente calendario per appuntamenti
- [Hero Component](../../laravel/Themes/One/resources/views/components/blocks/hero.blade.php)
- [CTA Component](../../laravel/Themes/One/resources/views/components/blocks/cta.blade.php)
- [Stats Component](../../laravel/Themes/One/resources/views/components/blocks/stats.blade.php)

### Integrazione Backend
- [Widget FullCalendar Backend](../../laravel/Modules/<nome progetto>/docs/fullcalendar_widget_implementation.mdc)
- [Configurazione FullCalendar](../../laravel/Modules/<nome progetto>/docs/fullcalendar_configuration.md)

### Compilazione e Build
- [Compilazione Temi](./compilazione_temi.md)
- [Frontend Development](./frontend-development.md)

## Convenzioni

### Naming
- Componenti: PascalCase per file (es. `Calendar.blade.php`)
- Props: kebab-case (es. `studio-id`, `patient-id`)
- CSS Classes: Tailwind CSS + DaisyUI

### Struttura
- Tutti i componenti in `laravel/Themes/One/resources/views/components/`
- Blocks in sottocartella `blocks/`
- UI components in sottocartella `ui/`

### Documentazione
- Ogni componente deve avere documentazione in `docs/frontend/`
- Collegamenti bidirezionali obbligatori
- Esempi di utilizzo inclusi
