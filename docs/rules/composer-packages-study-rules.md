# Composer Packages Study Rules

1. Eseguire `composer show` prima di ogni sessione chaos monkey.
2. Aggiornare `docs/architecture/composer-packages-study.md` e `composer-packages-full-inventory.md` dopo ogni variazione dipendenze.
3. Trattare come runtime-critical: Laravel/Folio/Livewire/Volt/Filament/Sushi/Localization.
4. Bloccare merge che introducono pacchetti dichiarati ma non installati nei moduli.
5. Aggiornare `Modules/*/docs/dependency-intelligence.md` e `Themes/Meetup/docs/dependency-intelligence.md` ad ogni cambio lock.
