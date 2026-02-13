# Filament nel modulo Lang

## Scopo
Questa nota sintetizza la versione corrente di Filament e i punti di integrazione rilevanti per le funzionalità di traduzione del modulo.

## Versione corrente
- Filament 5.x
- Livewire 4.x
- Volt 1.x (se presente nel progetto)

## Dipendenza locale: lara-zeus/spatie-translatable

Il modulo Lang utilizza una versione locale del pacchetto `lara-zeus/spatie-translatable` situata in:
```
Modules/Lang/packages/lara-zeus/spatie-translatable
```

### Configurazione (CRITICO)

La definizione del path repository **DEVE** essere nel `composer.json` root, NON nel composer.json del modulo:

```json
// laravel/composer.json (ROOT)
{
    "repositories": [
        {
            "type": "path",
            "url": "Modules/Lang/packages/lara-zeus/spatie-translatable",
            "options": { "symlink": true }
        },
        {
            "type": "composer",
            "url": "https://repo.packagist.org",
            "canonical": false
        }
    ]
}
```

Il constraint nel modulo rimane:
```json
// Modules/Lang/composer.json
{
    "require": {
        "lara-zeus/spatie-translatable": "dev-local"
    }
}
```

### Perché questa configurazione

Quando si utilizza `wikimedia/composer-merge-plugin`:
1. I repository vengono uniti da tutti i composer.json dei moduli
2. Packagist è canonico di default in Composer 2.x
3. Se Packagist non ha la versione `dev-local`, il composer fallisce
4. Definendo il path repo nel root PRIMA di Packagist, viene trovato correttamente

Per dettagli completi, vedere: `laravel/docs/composer-merge-plugin.md`

## Impatti principali
- Le risorse Filament devono essere compatibili con Livewire 4.
- Eventuali plugin Filament v4 vanno verificati o aggiornati prima dell'upgrade.
- Le traduzioni restano gestite dal LangServiceProvider senza label/placeholder/hint hardcoded.

## Aggiornamento a Filament v5

### Prerequisiti
- PHP 8.2+
- Laravel 11.28+
- Livewire 4.0+
- Tailwind CSS 4.0+

### Processo
1. Assicurarsi che i path package siano configurati correttamente (vedi sopra)
2. Installare il tool di upgrade:
   ```bash
   composer require filament/upgrade:"^5.0" -W --dev
   ```
3. Eseguire lo script di upgrade:
   ```bash
   vendor/bin/filament-v5
   ```
4. Verificare e committare le modifiche

## Collegamenti correlati
- [Integrazione Filament](filament-integration.md)
- [Widget Filament](filament-widgets-integration.md)
- [Traduzioni Filament](filament-translations.md)
- [Regole label Filament](filament-label.md)
- [LangServiceProvider](lang-service-provider.md)
- [Indice modulo](index.md)
- [Documentazione UI](../../UI/docs/README.md)
- [Indice root](../../../docs/index.md)
- [Composer Merge Plugin](../../../docs/composer-merge-plugin.md)

## Collegamenti tra versioni di filament.md
- [Filament (Chart)](../../Chart/docs/filament.md)
- [Filament (Gdpr)](../../Gdpr/docs/filament.md)
- [Filament (Xot technical)](../../Xot/docs/technical/filament.md)
- [Filament (Xot roadmap)](../../Xot/docs/roadmap/integration/filament.md)
- [Filament (Job)](../../Job/docs/filament.md)
- [Filament (Activity)](../../Activity/docs/filament.md)
- [Filament (Cms)](../../Cms/docs/filament.md)

## Risorse esterne
- https://github.com/statikbe/laravel-filament-chained-translation-manager
- https://filamentphp.com/plugins/34ml-translatable-field
- https://filamentphp.com/docs/5.x/upgrade-guide

---
**Ultimo aggiornamento:** Gennaio 2026
