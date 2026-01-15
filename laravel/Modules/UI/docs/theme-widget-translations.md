# Regole per Traduzioni Widget nel Tema

## Panoramica

Questo documento descrive le regole e le best practice per gestire le traduzioni dei widget Filament nei temi One e Two del progetto .
Questo documento descrive le regole e le best practice per gestire le traduzioni dei widget Filament nei temi One e Two del progetto <nome progetto>.
Questo documento descrive le regole e le best practice per gestire le traduzioni dei widget Filament nei temi One e Two del progetto .
Questo documento descrive le regole e le best practice per gestire le traduzioni dei widget Filament nei temi One e Two del progetto <nome progetto>.
Questo documento descrive le regole e le best practice per gestire le traduzioni dei widget Filament nei temi One e Two del progetto .
Questo documento descrive le regole e le best practice per gestire le traduzioni dei widget Filament nei temi One e Two del progetto <nome progetto>.

## Struttura File di Traduzione

### File widgets.php
Ogni tema deve contenere un file `widgets.php` in ogni cartella di lingua:

```
laravel/Themes/One/lang/
├── it/
│   └── widgets.php
├── en/
│   └── widgets.php
└── de/
    └── widgets.php
```

### Struttura Standard
```php
<?php

declare(strict_types=1);

return [
    'doctor' => [
        'profile' => [
            'title' => 'I miei dati',
        ],
        'appointments' => [
            'title' => 'I miei appuntamenti',
            'empty' => [
                'title' => 'Nessun appuntamento',
                'description' => 'Non hai appuntamenti programmati',
            ],
        ],
    ],
    'patient' => [
        'profile' => [
            'title' => 'Il mio profilo',
        ],
    ],
];
```

## Namespace del Tema

### Utilizzo Corretto
Le traduzioni del tema utilizzano il namespace `pub_theme::`:

```blade
{{-- ✅ CORRETTO --}}
<h2>{{ __('pub_theme::widgets.doctor.profile.title') }}</h2>
<p>{{ __('pub_theme::widgets.doctor.appointments.empty.description') }}</p>
```

### Namespace Alternativi
- `pub_theme::` - Per traduzioni del tema attivo
- `<nome progetto>::` - Per traduzioni del modulo
- `<nome progetto>::` - Per traduzioni del modulo <nome progetto>
- `<nome progetto>::` - Per traduzioni del modulo
- `<nome progetto>::` - Per traduzioni del modulo <nome progetto>
- `<nome progetto>::` - Per traduzioni del modulo
- `<nome progetto>::` - Per traduzioni del modulo <nome progetto>
- `ui::` - Per traduzioni del modulo UI

## Caso Studio: Profilo Dottore

### Problema Identificato
Il file `/laravel/Themes/One/resources/views/filament/widgets/doctor/profile.blade.php` conteneva testo hardcoded:

```blade
{{-- ❌ ERRATO --}}
<h2>I miei dati</h2>
```

### Soluzione Implementata
1. **Creazione file di traduzione**: `laravel/Themes/One/lang/{locale}/widgets.php`
2. **Struttura gerarchica**: `doctor.profile.title`
3. **Sostituzione hardcoded**: `{{ __('pub_theme::widgets.doctor.profile.title') }}`

### Risultato
- **Italiano**: "I miei dati"
- **Inglese**: "My Data"
- **Tedesco**: "Meine Daten"

## Best Practices

### 1. Struttura Gerarchica
Organizza le traduzioni in gruppi logici:
```php
'doctor' => [
    'profile' => [...],
    'appointments' => [...],
    'calendar' => [...],
],
'patient' => [
    'profile' => [...],
    'bookings' => [...],
],
```

### 2. Naming Convention
- Usa nomi descrittivi e in minuscolo
- Mantieni coerenza tra moduli
- Evita abbreviazioni ambigue

### 3. Gestione Stati Vuoti
Sempre includere traduzioni per stati vuoti:
```php
'empty' => [
    'title' => 'Nessun elemento',
    'description' => 'Non ci sono elementi da visualizzare',
],
```

### 4. Pluralizzazione
Usa `trans_choice` per pluralizzazione:
```blade
{{ trans_choice('pub_theme::widgets.appointments.count', $count, ['count' => $count]) }}
```

## Regole di Qualità

### 1. No Testo Hardcoded
```blade
{{-- ❌ MAI fare questo --}}
<h2>I miei dati</h2>
<button>Salva</button>

{{-- ✅ SEMPRE fare questo --}}
<h2>{{ __('pub_theme::widgets.doctor.profile.title') }}</h2>
<button>{{ __('pub_theme::widgets.actions.save') }}</button>
```

### 2. Struttura Completa
Ogni widget deve avere traduzioni complete:
```php
'widget_name' => [
    'title' => 'Titolo del widget',
    'description' => 'Descrizione del widget',
    'actions' => [
        'save' => 'Salva',
        'cancel' => 'Annulla',
    ],
    'messages' => [
        'success' => 'Operazione completata',
        'error' => 'Si è verificato un errore',
    ],
],
```

### 3. Coerenza Linguistica
- Mantieni lo stesso tono in tutte le lingue
- Usa terminologia coerente
- Rispetta le convenzioni culturali

## Sincronizzazione

### Script Automatico
Lo script `ThemeTranslationSynchronizer` gestisce automaticamente:
- Creazione file mancanti
- Sincronizzazione chiavi
- Mantenimento traduzioni esistenti

### Comando Manuale
```bash
cd var/www/html/_bases/base_<nome progetto>
cd var/www/html/_bases/base_<nome progetto>
cd var/www/html/_bases/base_<nome progetto>
php bashscripts/translations/sync_theme_translations.php
```

## Testing

### Verifica Traduzioni
1. Controlla che tutte le chiavi siano presenti
2. Verifica la sintassi dei file PHP
3. Testa le traduzioni nell'interfaccia

### Controllo Qualità
```bash

# Verifica sintassi PHP
php -l laravel/Themes/One/lang/it/widgets.php

# Controlla chiavi mancanti
grep -r "pub_theme::widgets" laravel/Themes/One/resources/views/
```

## Documentazione

### Aggiornamento Docs
Ogni modifica alle traduzioni widget deve essere documentata:
1. Aggiorna questo documento
2. Aggiorna `theme-translation-sync.md`
3. Crea collegamenti bidirezionali

### Esempi di Utilizzo
Includi sempre esempi pratici:
```blade
{{-- Esempio di widget con traduzioni complete --}}
<div class="widget">
    <h2>{{ __('pub_theme::widgets.doctor.profile.title') }}</h2>
    <p>{{ __('pub_theme::widgets.doctor.profile.description') }}</p>

    @if($items->isEmpty())
        <div class="empty-state">
            <h3>{{ __('pub_theme::widgets.doctor.profile.empty.title') }}</h3>
            <p>{{ __('pub_theme::widgets.doctor.profile.empty.description') }}</p>
        </div>
    @endif
</div>
```

## Collegamenti

- [Sincronizzazione Temi](theme-translation-sync.md)
- [Standard Traduzioni](translation-standards.md)
- [Best Practice Traduzioni](translation-best-practices.md)

---

*Ultimo aggiornamento: Dicembre 2024*
