# Sistema di Traduzioni

## Collegamenti Bidirezionali
- [Modulo <nome progetto> - Regole Consolidate Traduzioni](../../<nome progetto>/docs/translation-rules-consolidated.md)
- [Modulo <nome progetto> - Implementazione Appointment Report](../../<nome progetto>/docs/appointment_report_translations_implementation.md)
- [Modulo User - Translation Best Practices](../../User/docs/translation_best_practices.md)

## Panoramica
Il sistema di traduzioni utilizza `LangServiceProvider` per gestire le traduzioni in modo centralizzato e efficiente.

## LangServiceProvider

### Struttura Base
```php
namespace Modules\Lang\Providers;

use Illuminate\Support\ServiceProvider;

class LangServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('lang', function ($app) {
            return new LangManager($app);
        });
    }

    public function boot(): void
    {
        $this->loadTranslations();
        $this->publishTranslations();
    }

    protected function loadTranslations(): void
    {
        $this->loadTranslationsFrom(
            module_path('Lang', 'lang'),
            'lang'
        );
    }

    protected function publishTranslations(): void
    {
        $this->publishes([
            module_path('Lang', 'lang') => resource_path('lang/vendor/lang'),
        ], 'lang');
    }
}
```

## Implementazione

### File di Traduzione
```php
// lang/it/doctor.php
return [
    'fields' => [
        'name' => 'Nome',
        'email' => 'Email',
        'phone' => 'Telefono',
    ],
    'status' => [
        'pending' => 'In attesa',
        'approved' => 'Approvato',
        'rejected' => 'Rifiutato',
    ],
    'messages' => [
        'created' => 'Odontoiatra creato con successo',
        'updated' => 'Odontoiatra aggiornato con successo',
        'deleted' => 'Odontoiatra eliminato con successo',
    ],
];
```

### Utilizzo Traduzioni
```php
// ❌ NON FARE MAI
->label('Nome')  // VIETATO: stringa hardcoded
->label(__('doctor.fields.name'))  // VIETATO: qualsiasi ->label()

// ✅ SEMPRE FARE
TextInput::make('name'),  // Traduzione automatica tramite LangServiceProvider
TextInput::make('email'), // Nessun ->label(), gestione centralizzata
```

### Cache
```php
// Cache delle traduzioni
Cache::remember('translations', 3600, function () {
    return Lang::get('doctor');
});

// Invalidazione cache
Cache::forget('translations');
```

## Best Practices

### Organizzazione
- Raggruppare per modulo
- Usare chiavi descrittive
- Mantenere la struttura consistente

### Validazione
- Verificare chiavi mancanti

## Regole Critiche Aggiornate (Gennaio 2025)

### Struttura Espansa Obbligatoria
```php
'fields' => [
    'field_name' => [
        'label' => 'Etichetta Campo',
        'placeholder' => 'Testo segnaposto',
        'help' => 'Testo di aiuto descrittivo',
        'description' => 'Descrizione dettagliata',
        'tooltip' => 'Tooltip informativo',
        'helper_text' => '', // Vuoto se uguale alla chiave
    ],
],
```

### Sintassi Array Moderna
```php
// ✅ CORRETTO
return [
    'field' => [
        'label' => 'Etichetta',
    ],
];

// ❌ ERRATO
return array(
    'field' => array(
        'label' => 'Etichetta',
    ),
);
```

### Strict Types Obbligatorio
```php
<?php

declare(strict_types=1);

return [
    // contenuto del file
];
```

## Esempi di Implementazione Corretta

### Modulo <nome progetto> - Appointment Report
```php
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Referti Appuntamenti',
        'icon' => 'heroicon-o-document-text',
        'group' => 'Gestione Appuntamenti',
        'sort' => 3,
    ],
    'fields' => [
        'patient_id' => [
            'label' => 'Paziente',
            'placeholder' => 'Seleziona il paziente',
            'help' => 'Scegli il paziente per questo appuntamento',
            'description' => 'Identificativo del paziente',
            'tooltip' => 'Paziente responsabile dell\'appuntamento',
            'helper_text' => '',
        ],
    ],
];
```

## Regole per i Sviluppatori

1. **Commit**
   - Non committare mai chiavi di traduzione vuote
   - Aggiornare tutte le lingue supportate
   - Usare sempre sintassi array breve `[]`
   - Includere sempre `declare(strict_types=1);`

2. **Revisione**
   - Verificare che tutte le chiavi siano tradotte
   - Controllare la formattazione
   - Validare helper_text rules

3. **Manutenzione**
   - Rimuovere le chiavi non più utilizzate
   - Aggiornare la documentazione quando si aggiungono nuove chiavi
   - Mantenere collegamenti bidirezionali tra moduli

---

*
*Versione: 2.0*
*Compatibilità: Laravel 12.x, Filament 4.x*
