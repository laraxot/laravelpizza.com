# Testing del Tema Meetup

## Relazione con i Moduli

I **temi** non hanno una cartella `tests/` propria. Il tema Meetup viene testato indirettamente tramite:

- **Modulo Cms**: test delle pagine CMS-driven (Folio, Volt, blocchi)
- **Modulo Meetup**: test delle pagine eventi, profili, dashboard

Le view del tema (`pub_theme::`) sono caricate a runtime in base alla configurazione tenant (`pub_theme` in `config/local/{tenant}/xra.php`).

## Riferimenti

- [Laravel Modules Tests](https://laravelmodules.com/docs/12/advanced/tests)
- [Guida Pest + Laravel Modules](../../../docs/testing/laravel-modules-pest-guide.md)
- [Database Testing Configuration](./database-testing-configuration.md) — configurazione critica per `.env.testing`

## Comandi per Testare il Tema

```bash
# Test del modulo Meetup (include rendering del tema)
php artisan test --filter 'Meetup'

# Test del modulo Cms (include pagine Folio/Volt)
php artisan test --filter 'Cms'

# Test singolo file
php artisan test --filter 'MeetupHomePageTest'
```

## TestCase per Tema

I test del tema usano `Modules\Meetup\Tests\TestCase`, che **estende XotBaseTestCase** (DRY + KISS + Laraxot). Mai estendere `Illuminate\Foundation\Testing\TestCase`.

Quando si testano pagine che usano `pub_theme`, il TestCase del modulo Meetup configura il tema via `getPackageProviders()` e setUp se necessario.

Vedi [testcase-xotbase-extends](../../../.cursor/rules/testcase-xotbase-extends.mdc).

## Checklist per Modifiche al Tema

1. **Build**: `cd Themes/Meetup && npm run build && npm run copy`
2. **Test correlati**: eseguire `php artisan test --filter 'Meetup'` e `--filter 'Cms'`
3. **Verifica browser**: `http://127.0.0.1:8000/it`
