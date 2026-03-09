# PSR-4 Autoload Remediation (2026-03-09)

## Contesto

Warning autoload PSR-4 su file test Feature/CMS causati da pattern testuali ambigui per il parser di discovery classi.

## Intervento

1. cleanup dei commenti/pattern che possono generare match `class <token>` non intenzionali
2. mantenimento del namespace `Modules\\Cms\\Tests\\Feature`
3. nessun impatto sul comportamento funzionale dei test

## Nota

Intervento di igiene autoload: migliora signal/noise in `composer dump-autoload`.

