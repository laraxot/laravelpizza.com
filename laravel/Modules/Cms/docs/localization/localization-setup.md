# Configurazione della Localizzazione

## Pacchetto mcamara/laravel-localization

Il progetto utilizza il pacchetto `mcamara/laravel-localization` per gestire la localizzazione e gli URL multilingua.

## Configurazione corretta

### 1. File .env

Il file `.env` deve contenere la configurazione della locale predefinita:

```env
APP_LOCALE=it
APP_FALLBACK_LOCALE=en
```

### 2. File config/laravellocalization.php

**IMPORTANTE**: Ogni locale definita in `APP_LOCALE` DEVE essere presente nell'array `supportedLocales` del file `config/laravellocalization.php`:

```php
'supportedLocales' => [
    'it' => [
        'name' => 'Italian',
        'script' => 'Latn',
        'native' => 'italiano',
        'regional' => 'it_IT',
    ],
    'en' => [
        'name' => 'English',
        'script' => 'Latn',
        'native' => 'English',
        'regional' => 'en_GB',
    ],
    // Altre lingue supportate...
],
```

### 3. Aggiungere una nuova lingua

Per aggiungere una nuova lingua al progetto:

1. Aggiungerla all'array `supportedLocales` in `config/laravellocalization.php`
2. Creare i file di traduzione corrispondenti in `resources/lang/{locale}/`
3. Eseguire `php artisan config:clear` per aggiornare la cache

## Errori comuni

### UnsupportedLocaleException

Se si riceve l'errore:

```
Mcamara\LaravelLocalization\Exceptions\UnsupportedLocaleException
Laravel default locale is not in the supportedLocales array.
```

Significa che la locale predefinita configurata in `APP_LOCALE` non è presente nell'array `supportedLocales`.

**Soluzione**:
1. Verificare il valore di `APP_LOCALE` nel file `.env`
2. Assicurarsi che questa locale sia presente nell'array `supportedLocales` in `config/laravellocalization.php`
3. Eseguire `php artisan config:clear` dopo ogni modifica

## Best Practices

1. **Convenzioni di naming**:
   - Utilizzare codici lingua standard ISO (`it`, `en`, `es`, ecc.)
   - Mantenere coerenza nelle chiavi di traduzione

2. **Organizzazione file**:
   - Suddividere le traduzioni per modulo
   - Utilizzare namespace gerarchici nelle chiavi

3. **URL localizzati**:
   - Seguire sempre lo schema `/{locale}/{path}`
   - Usare i metodi del pacchetto per generare URL
   - Verificare che tutti i link includano il prefisso della lingua
