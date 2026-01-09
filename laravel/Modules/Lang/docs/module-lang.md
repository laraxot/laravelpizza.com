# Modulo Lang

## Informazioni Generali
- **Nome**: `laraxot/module_lang_fila3`
- **Descrizione**: Modulo per la gestione delle traduzioni e localizzazione
- **Namespace**: `Modules\Lang`
- **Repository**: https://github.com/laraxot/module_lang_fila3.git

### Versione HEAD

## Collegamenti ai Moduli

### Moduli con Traduzioni
- [Modulo Patient](../../Patient/docs/translations.md) - Traduzioni per il modulo paziente
- [Modulo User](../../User/docs/translations.md) - Traduzioni per la gestione utenti
- [Modulo UI](../../UI/docs/translations.md) - Traduzioni per i componenti UI
- [Modulo Cms](../../Cms/docs/translations.md) - Traduzioni per il CMS
- [Modulo Media](../../Media/docs/translations.md) - Traduzioni per la gestione media
- [Modulo Dental](../../Dental/docs/translations.md) - Traduzioni per il modulo dentale
- [Modulo Activity](../../Activity/docs/translations.md) - Traduzioni per le attività
- [Modulo Chart](../../Chart/docs/translations.md) - Traduzioni per i grafici
- [Modulo Gdpr](../../Gdpr/docs/translations.md) - Traduzioni per la privacy
- [Modulo Job](../../Job/docs/translations.md) - Traduzioni per i job
- [Modulo Notify](../../Notify/docs/translations.md) - Traduzioni per le notifiche
- [Modulo Reporting](../../Reporting/docs/translations.md) - Traduzioni per i report
- [Modulo Tenant](../../Tenant/docs/translations.md) - Traduzioni per il multi-tenant

### Regole Generali
- [Regole Traduzioni](../../Xot/docs/translations.md) - Documentazione base sulle traduzioni


### Versione Incoming


---

## Service Providers
1. `Modules\Lang\Providers\LangServiceProvider`
2. `Modules\Lang\Providers\Filament\AdminPanelProvider`

## Struttura
```
app/
├── Filament/       # Componenti Filament
├── Http/           # Controllers e Middleware
├── Models/         # Modelli del dominio
├── Providers/      # Service Providers
└── Services/       # Servizi di localizzazione
```

## Dipendenze
### Pacchetti Required
- `mcamara/laravel-localization`
- `spatie/laravel-sluggable`

### Moduli Required
- Xot
- Tenant
- UI

## Database
### Factories
Namespace: `Modules\Lang\Database\Factories`

### Seeders
Namespace: `Modules\Lang\Database\Seeders`

## Testing
Comandi disponibili:
```bash
composer test           # Esegue i test
composer test-coverage  # Genera report di copertura
composer analyse       # Analisi statica del codice
composer format        # Formatta il codice
```

## Funzionalità
- Gestione traduzioni
- URL localizzati
- Slug multilingua
- Middleware di localizzazione
- Interfaccia admin per traduzioni
- Supporto RTL
- Fallback language
- Cache traduzioni

## Configurazione
### Localizzazione
- Configurazione in `config/laravellocalization.php`
- Lingue supportate
- Formati data/ora
- Timezone

### Slug
- Configurazione generazione slug
- Supporto caratteri speciali
- Unicità per lingua

## Best Practices
1. Seguire le convenzioni di naming Laravel
2. Documentare tutte le classi e i metodi pubblici
3. Mantenere la copertura dei test
4. Utilizzare il type hinting
5. Seguire i principi SOLID
6. Utilizzare file di lingua
7. Implementare fallback
8. Ottimizzare cache traduzioni

## Troubleshooting
### Problemi Comuni
1. **Errori di Routing**
   - Verificare middleware
   - Controllare prefissi lingua
   - Verificare redirect

2. **Problemi di Slug**
   - Verificare unicità
   - Controllare caratteri speciali
   - Gestire collisioni

3. **Cache Traduzioni**
   - Pulire cache dopo modifiche
   - Verificare permessi file
   - Controllare chiavi mancanti

## Internazionalizzazione
### Formati
- Date e orari
- Numeri e valute
- Pluralizzazione

### File di Lingua
- Struttura
- Convenzioni di naming
- Gestione gruppi

### Middleware
- Rilevamento lingua
- Redirect
- SEO

## Links
- Documentazione Laravel Localization
- Guida all'upgrade
- Introduzione al modulo
- Tutorial e esempi

## Changelog
### Versione HEAD

Le modifiche vengono tracciate nel repository GitHub.

## Nuove Best Practices

### 1. Gestione Errori
- Traduzioni per messaggi di errore
- Codici errore standardizzati
- Messaggi di errore descrittivi
- Supporto multilingua per errori

### 2. Validazione
- Traduzioni per regole di validazione
- Messaggi di validazione personalizzati
- Supporto per regole custom
- Coerenza nei messaggi

### 3. SEO
- Traduzioni per meta tag
- Descrizioni multilingua
- Keywords localizzate
- URL localizzati

### 4. Accessibilità
- Testi alternativi per immagini
- Descrizioni per elementi interattivi
- Messaggi di stato
- Supporto per screen reader

### 5. Performance
- Lazy loading traduzioni
- Bundle per lingua
- Preload traduzioni critiche
- Ottimizzazione cache

### 6. Testing
- Verifica traduzioni mancanti
- Test di coerenza
- Validazione formati
- Test di performance

## Esempi di Implementazione

### 1. Gestione Errori
```php
// Definizione errori
'errors' => [
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'email' => 'Inserisci un indirizzo email valido',
    ],
    'auth' => [
        'failed' => 'Credenziali non valide',
        'throttle' => 'Troppi tentativi di accesso',
    ],
],

// Utilizzo
throw new ValidationException($validator);
```

### 2. Validazione
```php
// Definizione regole
'rules' => [
    'email' => [
        'required' => 'L\'email è obbligatoria',
        'email' => 'Inserisci un\'email valida',
    ],
    'password' => [
        'required' => 'La password è obbligatoria',
        'min' => 'La password deve essere di almeno :min caratteri',
    ],
],

// Utilizzo
$validator = Validator::make($data, $rules);
```

### 3. SEO
```php
// Definizione meta
'meta' => [
    'title' => 'Titolo della Pagina',
    'description' => 'Descrizione della pagina',
    'keywords' => 'keyword1, keyword2, keyword3',
],

// Utilizzo
<meta name="title" content="{{ __('meta.title') }}">
```

### 4. Accessibilità
```php
// Definizione accessibilità
'accessibility' => [
    'alt' => [
        'logo' => 'Logo dell\'azienda',
        'banner' => 'Banner promozionale',
    ],
    'aria' => [
        'button' => 'Pulsante per :action',
        'link' => 'Link a :destination',
    ],
],

// Utilizzo
<img src="logo.png" alt="{{ __('accessibility.alt.logo') }}">
```

### 5. Performance
```php
// Configurazione cache
'cache' => [
    'enabled' => true,
    'key' => 'translations',
    'duration' => 3600,
],

// Utilizzo
Cache::remember('translations', 3600, function () {
    return Lang::loadTranslations();
});
```

### 6. Testing
```php
// Test traduzioni
public function testTranslations()
{
    $this->assertTrue(Lang::has('errors.validation.required'));
    $this->assertEquals(
        'Il campo :attribute è obbligatorio',
        Lang::get('errors.validation.required')
    );
}
```

## Collegamenti

- [Modulo Patient](../../Patient/docs/translations.md) - Esempio di implementazione delle traduzioni
- [Regole Generali Traduzioni](../../Xot/docs/translations.md)

## Esempi

```php
// Accesso alle traduzioni
$translation = Lang::get('patient.registration.label');
``` 

### Versione Incoming

Le modifiche vengono tracciate nel repository GitHub. 

---

