# MCP Servers per UI/UX - Modulo Cms


## Scopo

Il modulo Cms gestisce il rendering dei temi frontend (pub_theme) e la registrazione delle view/componenti Blade. Questo documento descrive come gli MCP UI/UX si integrano con il flusso Cms.

## Flusso Tema → MCP

1. `CmsServiceProvider` legge `pub_theme` da `XotData` (config tenant `xra.php`)
2. Registra view path, traduzioni e componenti Blade del tema attivo
3. Il tema usa Tailwind CSS v4 + Filament v5 + Vite per il build
4. Gli MCP UI/UX forniscono contesto per generare componenti compatibili

## MCP Rilevanti per il Modulo Cms

| MCP Server | Uso nel contesto Cms |
| --- | --- |
| flowbite | Generare layout, navbar, footer, hero sections per i temi |
| shadcn | Cercare e installare componenti da registry |
| daisyui | Generare pagine complete con qualità alta |

## Regole per Componenti Generati via MCP

- Output HTML va adattato a Blade (`<x-componente>` con slot)
- Le view vanno in `Themes/{ThemeName}/resources/views/`
- I componenti condivisi vanno in `Modules/UI/resources/views/components/ui/`
- Nessuna stringa hardcoded — usare file di traduzione del modulo
- Il build Vite del tema deve produrre `manifest.json` in `public_html/themes/{ThemeName}/dist/`

## Collegamenti

- [CmsServiceProvider](../app/Providers/CmsServiceProvider.php)
- [MCP UI/UX Tema Two](../../themes/two/docs/mcp-ui-ux.md)
- [MCP UI/UX Modulo UI](../../../laravel/modules/ui/docs/mcp-ui-ux.md)
- [Status MCP Progetto](../../../docs/mcp-servers-status.md)
