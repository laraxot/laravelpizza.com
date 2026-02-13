# Struttura Espansa per File di Traduzione - Progetto <nome progetto>

## Scopo
Definizione della struttura standard espansa per tutti i file di traduzione del progetto, seguendo i principi DRY/KISS per massima usabilità e manutenibilità.

## Principi DRY/KISS Applicati

### DRY (Don't Repeat Yourself)
- **Template standardizzato** per tutti i moduli
- **Struttura coerente** tra lingue diverse
- **Riutilizzo pattern** per campi simili

### KISS (Keep It Simple, Stupid)
- **Struttura prevedibile** e facile da navigare
- **Naming consistente** per tutte le proprietà
- **Documentazione chiara** per ogni elemento

## Struttura Standard Espansa

### Template Base per Campi
Ogni campo deve avere la seguente struttura completa:

```php
'field_name' => [
    'label' => 'Etichetta Visibile',
    'tooltip' => 'Suggerimento breve al passaggio del mouse',
    'helper_text' => 'Testo di aiuto sotto il campo',
    'description' => 'Descrizione dettagliata del campo e del suo utilizzo',
    'icon' => 'icon-name',
    'color' => 'primary|secondary|success|warning|danger|info',
    'placeholder' => 'Testo placeholder per input (opzionale)',
    'validation' => [
        'required' => 'Messaggio errore campo obbligatorio',
        'invalid' => 'Messaggio errore formato non valido',
    ],
],
```

### Esempio Pratico - Campo "Città"

#### Italiano (it)
```php
'city' => [
    'label' => 'Città',
    'tooltip' => 'Inserisci il nome della città',
    'helper_text' => 'Seleziona o digita il nome della città di residenza',
    'description' => 'Campo obbligatorio per identificare la località di residenza o sede',
    'icon' => 'heroicon-o-building-office-2',
    'color' => 'primary',
    'placeholder' => 'Es. Milano, Roma, Napoli',
    'validation' => [
        'required' => 'La città è obbligatoria',
        'invalid' => 'Nome città non valido',
    ],
],
```

#### Inglese (en)
```php
'city' => [
    'label' => 'City',
    'tooltip' => 'Enter the city name',
    'helper_text' => 'Select or type the name of your city of residence',
    'description' => 'Required field to identify the location of residence or office',
    'icon' => 'heroicon-o-building-office-2',
    'color' => 'primary',
    'placeholder' => 'e.g. London, New York, Berlin',
    'validation' => [
        'required' => 'City is required',
        'invalid' => 'Invalid city name',
    ],
],
```

#### Tedesco (de)
```php
'city' => [
    'label' => 'Stadt',
    'tooltip' => 'Geben Sie den Stadtnamen ein',
    'helper_text' => 'Wählen Sie den Namen Ihrer Wohnstadt aus oder geben Sie ihn ein',
    'description' => 'Pflichtfeld zur Identifizierung des Wohn- oder Bürostandorts',
    'icon' => 'heroicon-o-building-office-2',
    'color' => 'primary',
    'placeholder' => 'z.B. Berlin, München, Hamburg',
    'validation' => [
        'required' => 'Stadt ist erforderlich',
        'invalid' => 'Ungültiger Stadtname',
    ],
],
```

## Proprietà Obbligatorie

### Core Properties (Sempre Richieste)
- **label**: Etichetta principale visibile nell'interfaccia
- **tooltip**: Suggerimento breve per l'utente
- **helper_text**: Testo di aiuto dettagliato
- **description**: Descrizione completa del campo
- **icon**: Icona Heroicon per identificazione visiva
- **color**: Colore tema per coerenza UI

### Optional Properties (Quando Applicabili)
- **placeholder**: Per campi di input
- **validation**: Messaggi di errore specifici
- **options**: Per campi select/radio
- **format**: Per campi con formato specifico

## Colori Standard

### Palette Colori Approvata
- **primary**: Campi principali (nome, email, città)
- **secondary**: Campi secondari (note, descrizioni)
- **success**: Campi di conferma (password confermata)
- **warning**: Campi di attenzione (data scadenza)
- **danger**: Campi critici (eliminazione)
- **info**: Campi informativi (codici, riferimenti)

## Icone Standard

### Mapping Icone per Campi Comuni
```php
'name' => 'heroicon-o-user',
'email' => 'heroicon-o-envelope',
'phone' => 'heroicon-o-phone',
'address' => 'heroicon-o-map-pin',
'city' => 'heroicon-o-building-office-2',
'province' => 'heroicon-o-map',
'postal_code' => 'heroicon-o-hashtag',
'country' => 'heroicon-o-globe-europe-africa',
'date' => 'heroicon-o-calendar-days',
'time' => 'heroicon-o-clock',
'password' => 'heroicon-o-lock-closed',
'description' => 'heroicon-o-document-text',
```

## Regole di Traduzione

### Consistenza Linguistica
- **Italiano**: Formale, chiaro, professionale
- **Inglese**: Internazionale, conciso, user-friendly
- **Tedesco**: Preciso, dettagliato, formale

### Lunghezza Testi
- **Label**: Max 20 caratteri
- **Tooltip**: Max 50 caratteri
- **Helper_text**: Max 100 caratteri
- **Description**: Max 200 caratteri

## Implementazione Graduale

### Fase 1: Moduli Core
- [x] Documentazione struttura espansa
- [ ] Geo (location, address)
- [ ] User (registration, profile)
- [ ] <nome progetto> (patient, doctor, studio)

### Fase 2: Moduli Secondari
- [ ] <nome progetto>
- [ ] Job
- [ ] Notify

### Fase 3: Validazione e Test
- [ ] Controllo coerenza tra lingue
- [ ] Test UI con nuova struttura
- [ ] Validazione accessibilità

## Benefici Attesi

### Per Sviluppatori
- **Struttura prevedibile** per tutti i campi
- **Manutenzione semplificata** con template standard
- **Debugging facilitato** con informazioni complete

### Per Utenti
- **Esperienza coerente** in tutte le lingue
- **Informazioni complete** per ogni campo
- **Accessibilità migliorata** con tooltip e descrizioni

### Per il Progetto
- **Qualità professionale** dell'interfaccia
- **Scalabilità** per nuove lingue
- **Manutenibilità** a lungo termine

## Collegamenti Bidirezionali

### Documentazione Correlata
- **Modulo Geo**: `/Modules/Geo/docs/translation-structure.md`
- **Modulo User**: `/Modules/User/docs/translation-guidelines.md`
- **Modulo <nome progetto>**: `/Modules/<nome progetto>/docs/multilingual-support.md`
- **Tema One**: `/Themes/One/docs/translations.md`

### File di Implementazione
- Template base: `/resources/lang-templates/`
- Validatori: `/app/Rules/TranslationStructure.php`
- Helper: `/app/Helpers/TranslationHelper.php`

---

**Versione**: 1.0
**Stato**: Implementazione in corso
**Responsabile**: Sistema automatico DRY/KISS
