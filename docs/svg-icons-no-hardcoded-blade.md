# SVG nel tema Meetup: file .svg, no inline

## Regola

Nel tema Meetup **non** usare SVG inline nelle Blade. Usare sempre file `.svg` nel modulo Meetup (`Modules/Meetup/resources/svg/`) e richiamarli con `<x-filament::icon icon="meetup-{nome}" class="..." />`.

## Perché

- **DRY**: un’icona definita una sola volta nel file `.svg`.
- **Manutenibilità**: modifiche al disegno solo nel file SVG.
- **Coerenza**: stesso set di icone (prefisso `meetup-`) in header, footer, blocchi.

## Dove sono le icone

- Path: `laravel/Modules/Meetup/resources/svg/`.
- Nomi icona: `meetup-logo`, `meetup-icon-calendar`, `meetup-icon-community`, `meetup-icon-sponsors`, `meetup-icon-chat`, `meetup-icon-language`, `meetup-icon-chevron-down`, `meetup-icon-check`, `meetup-icon-menu`, `meetup-facebook`, `meetup-twitter`, `meetup-github`.

## Logo

Il logo ufficiale è il contenuto attuale di `Modules/Meetup/resources/svg/logo.svg`. Non sovrascrivere questo file con altre interpretazioni a meno che non sia esplicitamente richiesto dal committente. Vedi [logo-branding-guidelines.md](../../modules/meetup/docs/logo-branding-guidelines.md).

## Esempio (header / footer)

```blade
<x-filament::icon icon="meetup-logo" class="h-12 w-12 text-red-500 shrink-0" />
<x-filament::icon icon="meetup-icon-calendar" class="h-5 w-5 group-hover:scale-110 transition-transform" />
<x-filament::icon icon="meetup-icon-chat" class="w-4 h-4 mr-1 shrink-0" />
<x-filament::icon icon="meetup-icon-language" class="w-4 h-4 mr-1 shrink-0" />
<x-filament::icon icon="meetup-icon-chevron-down" class="w-4 h-4 ml-1 shrink-0" />
<x-filament::icon icon="meetup-icon-check" class="w-4 h-4 mr-2 text-red-500 shrink-0" />
<x-filament::icon icon="meetup-icon-menu" class="w-6 h-6" />
<x-filament::icon icon="meetup-facebook" class="w-6 h-6" />
```

## Componenti tema che usano meetup-* (no SVG inline)

- `sections/header.blade.php`, `sections/header/v1.blade.php`, `sections/footer.blade.php`

## Riferimenti

- Regola: [.cursor/rules/svg-no-hardcoded-blade-icons-meetup.mdc](../../../.cursor/rules/svg-no-hardcoded-blade-icons-meetup.mdc)
- Modulo: [Modules/Meetup/docs/svg-icons-no-hardcoded-blade.md](../../modules/meetup/docs/svg-icons-no-hardcoded-blade.md)
