# Implementazione delle Icone Personalizzate

## Introduzione
Questa guida fornisce istruzioni dettagliate su come implementare e utilizzare icone personalizzate nel sistema Xot.

## Prerequisiti
Prima di procedere, assicurarsi di aver compreso il [processo di registrazione delle icone](registerBladeIcons.md).

## Processo di Implementazione

### 1. Creazione della Struttura
```bash
Modules/
  └── IlTuoModulo/
      └── assets/
          └── svg/
              └── mia-icona.svg
```

### 2. Formato SVG
```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <!-- Il tuo codice SVG qui -->
</svg>
```

### 3. Registrazione nel Service Provider
```php
public function register(): void
{
    $this->registerBladeIcons();
}
```

## Best Practices per SVG
1. Ottimizzare i file SVG per le prestazioni
2. Utilizzare viewBox appropriati
3. Mantenere la compatibilità cross-browser

## Utilizzo nelle Viste
```blade
{{-- Utilizzo base --}}
<x-icon name="modulo::mia-icona" />

{{-- Con attributi aggiuntivi --}}
<x-icon name="modulo::mia-icona" class="w-6 h-6" />
```

## Troubleshooting
Per problemi comuni e soluzioni, consultare la [documentazione di registerBladeIcons](registerBladeIcons.md).

## Risorse Aggiuntive
- [Panoramica delle Blade Icons](blade-icons-overview.md)
- [Documentazione dettagliata di registerBladeIcons](registerBladeIcons.md) 