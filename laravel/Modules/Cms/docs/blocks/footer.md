# Footer

## Panoramica
Il footer è una sezione **generica** che consente di inserire **qualsiasi** blocco disponibile nel sistema. Non ci sono blocchi dedicati esclusivamente al footer: si possono usare Hero, Paragraph, Navigation, Stats, CTA, ecc.

## Configurazione
I blocchi del footer si configurano come nelle altre sezioni tramite PageContentBuilder:
```php
PageContentBuilder::make('footer_blocks')
    ->columnSpanFull();
```
Questo permette di aggiungere, ordinare e rimuovere ogni tipo di blocco.

## Best Practices
1. Scegliere blocchi coerenti con il layout generale del footer.
2. Verificare leggibilità e accessibilità del contenuto.
3. Testare su diversi dispositivi per la responsività.

## Collegamenti
- [Documentazione Blocchi](../blocks/README.md)
- [PageContentBuilder](../filament-forms.md)
- [Gestione Sezioni](../sections/footer-section.md)
- [Documentazione UI](../../UI/docs/README.md)
- [Documentazione Moduli](../../Xot/docs/modules.md)
- [Linee guida etichette Filament](/docs/filament-block-labels.md)

## Note
- I blocchi sono progettati per essere modulari e riutilizzabili in qualsiasi progetto
- La configurazione è salvata nel file JSON della sezione
- Le traduzioni sono gestite centralmente nel modulo
- I blocchi seguono le convenzioni di namespace standard dei moduli

## Label Translation
Le etichette dei Filament Blocks **NON** devono essere definite con `->label()`. Tutte le etichette vengono risolte tramite i file di traduzione del modulo e il LangServiceProvider.

## Collegamenti tra versioni di footer.md
* [footer.md](docs/laravel-app/themes/one/components/footer.md)
* [footer.md](docs/sections/footer.md)
* [footer.md](laravel/Modules/UI/docs/components/footer.md)
* [footer.md](laravel/Modules/Cms/docs/blocks/footer.md)
* [footer.md](laravel/Modules/Cms/docs/themes/one/footer.md)
* [footer.md](laravel/Modules/Cms/docs/components/footer.md)
* [footer.md](laravel/Themes/One/docs/components/layouts/footer.md)
* [footer.md](laravel/Themes/One/docs/sections/footer.md)

