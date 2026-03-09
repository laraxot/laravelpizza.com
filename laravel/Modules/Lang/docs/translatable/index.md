# Spatie Laravel Translatable

Questa documentazione descrive l'implementazione e l'utilizzo del pacchetto `spatie/laravel-translatable` nel progetto, un potente strumento per la gestione di contenuti multilingua nei modelli Eloquent.
## Indice
1. [Gestione delle traduzioni mancanti](./gestione-traduzioni-mancanti.md)
2. [Implementazione nel progetto](./implementazione-nel-progetto.md)
3. [Best Practices](./best-practices.md)
4. [Gestione Traduzioni Contenuti JSON](./json-content-translation.md)
5. [API e utilizzo comune](#api-e-utilizzo-comune)
## Introduzione
Il pacchetto `spatie/laravel-translatable` consente di salvare traduzioni di attributi dei modelli Eloquent. Le traduzioni vengono archiviate come file JSON, rendendo semplice l'aggiunta o la rimozione di lingue.
## Installazione e Configurazione
Il pacchetto è già installato nel progetto. La configurazione principale si trova in:
- `Modules/Lang/app/Providers/TranslatableServiceProvider.php`
## Integrazione con Filament
Il progetto utilizza il plugin ufficiale `filament/spatie-laravel-translatable-plugin` per l'integrazione con Filament, configurato in:
- `Modules/<nome modulo>/app/Providers/Filament/AdminPanelProvider.php`
<<<<<<< HEAD
- `Modules/Laraxot/app/Providers/Filament/AdminPanelProvider.php`
=======
- `Modules/healthcare_app/app/Providers/Filament/AdminPanelProvider.php`
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
- `Modules/UI/app/Providers/Filament/AdminPanelProvider.php`
- `Modules/Lang/app/Providers/Filament/AdminPanelProvider.php`
## API e utilizzo comune
### Dichiarazione di campi traducibili
```php
use Spatie\Translatable\HasTranslations;
class MailTemplate extends Model
{
    use HasTranslations;
    
    public $translatable = ['subject', 'html_template', 'text_template'];
}
```
### Accesso alle traduzioni
// Imposta traduzioni
$model->setTranslation('field_name', 'it', 'Valore in italiano');
$model->setTranslation('field_name', 'en', 'English value');
$model->save();
// Imposta tutte le traduzioni contemporaneamente
$model->setTranslations('field_name', [
    'it' => 'Valore in italiano',
    'en' => 'English value',
]);
// Ottieni traduzione specifica
$model->getTranslation('field_name', 'it'); // 'Valore in italiano'
// Ottieni tutte le traduzioni
$model->getTranslations('field_name'); // ['it' => 'Valore in italiano', 'en' => 'English value']
// Ottieni traduzione nella lingua corrente
$model->field_name; // Restituisce nella lingua di app()->getLocale()
### Rimozione di traduzioni
$model->forgetTranslation('field_name', 'en');
## Gestione Contenuti JSON
Il sistema supporta anche la traduzione di contenuti JSON per pagine dinamiche. Vedi [Gestione Traduzioni Contenuti JSON](./json-content-translation.md) per dettagli completi.
### Esempio di Contenuto JSON Traducibile
```json
    "title": {
        "it": "Area Dottore - ",
        "en": "Doctor Area - "
<<<<<<< HEAD
        "it": "Area Dottore - Laraxot",
        "en": "Doctor Area - Laraxot"
=======
        "it": "Area Dottore - healthcare_app",
        "en": "Doctor Area - healthcare_app"
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
    },
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "title": "Benvenuto nella tua Area Dottore",
                    "subtitle": "Gestisci le tue pazienti e monitora i loro percorsi ",
                    "cta_text": "Continua la registrazione"
                }
            }
        ],
        "en": [
                    "title": "Welcome to your Doctor Area",
                    "subtitle": "Manage your patients and monitor their oral health pathways",
                    "cta_text": "Continue registration"
        ]
    }
## Best Practices
1. **Traduzione di tutti i campi necessari**:
   - Assicurarsi di tradurre tutti i campi dichiarati in `$translatable` per tutte le lingue supportate
2. **Validazione delle traduzioni**:
   - Implementare regole di validazione specifiche per ciascuna lingua
3. **Gestione fallback coerente**:
   - Definire una strategia di fallback chiara e coerente in tutta l'applicazione
4. **Performance**:
   - Le traduzioni sono archiviate come JSON, quindi evitare campi troppo grandi o numerosi
5. **Integrazione con l'UI**:
   - Utilizzare componenti UI che supportano la modifica di contenuti multilingua
6. **Contenuti JSON**:
   - Tradurre solo i campi testuali (title, subtitle, cta_text, description)
   - Non tradurre percorsi, widget, immagini o link
   - Mantenere la stessa struttura tra le diverse lingue
## Risorse
- [Documentazione ufficiale](https://spatie.be/docs/laravel-translatable)
- [Repository GitHub](https://github.com/spatie/laravel-translatable)
- [Issues e discussioni](https://github.com/spatie/laravel-translatable/issues)
- [Plugin Filament](https://filamentphp.com/plugins/filament-spatie-translatable)
