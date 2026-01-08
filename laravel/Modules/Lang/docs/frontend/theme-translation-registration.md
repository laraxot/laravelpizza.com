# Registrazione Traduzioni Temi - Standard Laraxot

## Principio Fondamentale

**REGOLA CRITICA**: Ogni tema DEVE registrare le traduzioni con doppio namespace:
1. Il proprio namespace specifico (es. `one`, `two`)
2. Il namespace generico `pub_theme`

## Implementazione Standard

### ThemeServiceProvider Pattern
```php
public function boot(): void
{
    parent::boot();
    
    // Registra il namespace pub_theme per le traduzioni
    $this->loadTranslationsFrom($this->module_dir.'/../lang', 'pub_theme');
    
    // Registra anche le view con il namespace pub_theme
    $this->loadViewsFrom($this->module_dir.'/../resources/views', 'pub_theme');
}
```

### Motivazione
- **Compatibilità**: Le view possono usare `pub_theme::` indipendentemente dal tema attivo
- **Flessibilità**: Cambio tema senza modificare le view
- **Coerenza**: Standard uniforme per tutti i temi

## Errori da Evitare

### ❌ Registrazione Singola
```php
// ERRATO - Solo namespace specifico
$this->loadTranslationsFrom($path, 'one');
```

### ❌ Traduzioni Hardcoded
```php
// ERRATO - Stringa hardcoded nelle view
<p><strong>Data:</strong> {{ $date }}</p>
```

### ✅ Implementazione Corretta
```php
// CORRETTO - Doppia registrazione
$this->loadTranslationsFrom($path, $this->nameLower);
$this->loadTranslationsFrom($path, 'pub_theme');
```

```blade
{{-- CORRETTO - Namespace generico --}}
<p><strong>@lang('pub_theme::appointment.fields.date.label'):</strong> {{ $date }}</p>
```

## Test di Validazione

### Comando di Test
```bash
php artisan tinker --execute="
echo 'Date: ' . trans('pub_theme::appointment.fields.date.label') . PHP_EOL;
echo 'Time: ' . trans('pub_theme::appointment.fields.time.label') . PHP_EOL;
"
```

### Output Atteso
```
Date: Data
Time: Ora
```

## Filosofia DRY + KISS

### DRY (Don't Repeat Yourself)
- Un solo metodo di registrazione per tutti i temi
- Riutilizzo delle traduzioni esistenti
- Nessuna duplicazione di logica

### KISS (Keep It Simple, Stupid)
- Pattern semplice e uniforme
- Test immediati e chiari
- Documentazione concisa

## Checklist Implementazione

- [ ] ThemeServiceProvider estende XotBaseThemeServiceProvider
- [ ] Registrazione doppio namespace (specifico + pub_theme)
- [ ] Test traduzioni con comando tinker
- [ ] Documentazione aggiornata nel tema
- [ ] Collegamenti bidirezionali con docs tema

## Moduli Correlati

### Temi Implementati
- [Themes/One/docs/pub_theme_namespace_registration.md](../../Themes/One/docs/pub_theme_namespace_registration.md)
- [Themes/Two/docs/theme-translations.md](../../Themes/Two/docs/theme-translations.md)

### Documentazione Base
- [Modules/Xot/docs/theme-service-provider-rules.md](../../Modules/Xot/docs/theme-service-provider-rules.md)
- [docs/frontend/widget-view-namespaces.md](widget-view-namespaces.md)

## Risoluzione Problemi

### Traduzione Non Trovata
1. Verificare registrazione doppio namespace
2. Controllare path file traduzione
3. Testare con comando tinker
4. Verificare sintassi file PHP

### Namespace Errato
1. Controllare configurazione xra.php
2. Verificare ServiceProvider registrato
3. Pulire cache traduzioni: `php artisan config:clear`

*Standard Laraxot - Ultimo aggiornamento: 2025-08-07*
