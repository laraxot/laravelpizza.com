# Struttura Completa dei Campi di Traduzione - Standard Laraxot <nome progetto>

## Principi Fondamentali DRY + KISS

### Struttura Obbligatoria per Ogni Campo
Ogni campo di traduzione DEVE includere tutti questi elementi:

```php
<?php

declare(strict_types=1);

return [
    'fields' => [
        'field_name' => [
            'label' => 'Campo Label',                    // OBBLIGATORIO
            'placeholder' => 'Inserisci valore',        // OBBLIGATORIO
            'tooltip' => 'Suggerimento breve',          // OBBLIGATORIO
            'helper_text' => 'Testo di aiuto dettagliato', // OBBLIGATORIO
            'description' => 'Descrizione completa del campo', // OBBLIGATORIO
            'icon' => 'heroicon-o-icon-name',           // OBBLIGATORIO
            'color' => 'primary|secondary|success|danger|warning|info', // OBBLIGATORIO
        ],
    ],
];
```

## Regole Specifiche per Campi Geografici

### Campo "Città"

### Italiano (Riferimento)
```php
'city' => [
    'label' => 'Città',
    'placeholder' => 'Inserisci la città',
    'tooltip' => 'Città di residenza o ubicazione',
    'helper_text' => 'Inserisci il nome della città dove ti trovi o dove si trova lo studio',
    'description' => 'Campo per specificare la città di residenza del paziente o ubicazione dello studio medico',
    'icon' => 'heroicon-o-map-pin',
    'color' => 'primary',
],
```

### Tedesco (Standard)
```php
'city' => [
    'label' => 'Stadt',
    'placeholder' => 'Stadt eingeben',
    'tooltip' => 'Stadt des Wohnsitzes oder Standorts',
    'helper_text' => 'Geben Sie den Namen der Stadt ein, in der Sie sich befinden oder in der sich die Praxis befindet',
    'description' => 'Feld zur Angabe der Wohnsitzstadt des Patienten oder des Standorts der Arztpraxis',
    'icon' => 'heroicon-o-map-pin',
    'color' => 'primary',
],
```

### Inglese (Standard)
```php
'city' => [
    'label' => 'City',
    'placeholder' => 'Enter city',
    'tooltip' => 'City of residence or location',
    'helper_text' => 'Enter the name of the city where you are located or where the practice is located',
    'description' => 'Field to specify the patient\'s city of residence or medical practice location',
    'icon' => 'heroicon-o-map-pin',
    'color' => 'primary',
],
```

### Campo "Provincia/Province"

#### Italiano (Riferimento)
```php
'province' => [
    'label' => 'Provincia',
    'placeholder' => 'Inserisci la provincia',
    'tooltip' => 'Provincia di residenza o ubicazione',
    'helper_text' => 'Inserisci il nome della provincia dove risiedi o dove si trova lo studio',
    'description' => 'Campo per specificare la provincia di residenza del paziente o ubicazione dello studio medico',
    'icon' => 'heroicon-o-map',
    'color' => 'secondary',
],
```

#### Tedesco (Standard)
```php
'province' => [
    'label' => 'Provinz',
    'placeholder' => 'Provinz eingeben',
    'tooltip' => 'Provinz des Wohnsitzes oder Standorts',
    'helper_text' => 'Geben Sie den Namen der Provinz ein, in der Sie wohnen oder in der sich die Praxis befindet',
    'description' => 'Feld zur Angabe der Wohnsitzprovinz des Patienten oder des Standorts der Arztpraxis',
    'icon' => 'heroicon-o-map',
    'color' => 'secondary',
],
```

#### Inglese (Standard)
```php
'province' => [
    'label' => 'Province',
    'placeholder' => 'Enter province',
    'tooltip' => 'Province of residence or state',
    'helper_text' => 'Enter the name of your province or state of residence',
    'description' => 'Field to specify the user\'s province or state for registration and location purposes',
    'icon' => 'heroicon-o-map',
    'color' => 'secondary',
],
```

### Campo "Regione/Region"

#### Italiano (Riferimento)
```php
'region' => [
    'label' => 'Regione',
    'placeholder' => 'Seleziona la regione',
    'tooltip' => 'Regione amministrativa di appartenenza',
    'helper_text' => 'Seleziona la regione amministrativa dove risiedi o dove si trova lo studio',
    'description' => 'Campo per specificare la regione amministrativa per la localizzazione geografica',
    'icon' => 'heroicon-o-globe-europe-africa',
    'color' => 'info',
],
```

#### Tedesco (Standard)
```php
'region' => [
    'label' => 'Region',
    'placeholder' => 'Region auswählen',
    'tooltip' => 'Verwaltungsregion der Zugehörigkeit',
    'helper_text' => 'Wählen Sie die Verwaltungsregion aus, in der Sie wohnen oder in der sich die Praxis befindet',
    'description' => 'Feld zur Angabe der Verwaltungsregion für die geografische Lokalisierung',
    'icon' => 'heroicon-o-globe-europe-africa',
    'color' => 'info',
],
```

#### Inglese (Standard)
```php
'region' => [
    'label' => 'Region',
    'placeholder' => 'Select region',
    'tooltip' => 'Administrative region of belonging',
    'helper_text' => 'Select the administrative region where you reside or where the practice is located',
    'description' => 'Field to specify the administrative region for geographical localization',
    'icon' => 'heroicon-o-globe-europe-africa',
    'color' => 'info',
],
```

### Campo "Accedi/Login"

#### Italiano (Riferimento)
```php
'login' => [
    'label' => 'Accedi',
    'placeholder' => 'Clicca per accedere',
    'tooltip' => 'Accedi al tuo account personale',
    'helper_text' => 'Clicca qui per accedere alla tua area riservata con le tue credenziali',
    'description' => 'Pulsante per accedere al sistema con le proprie credenziali di autenticazione',
    'icon' => 'heroicon-o-arrow-right-on-rectangle',
    'color' => 'success',
],
```

#### Tedesco (Standard)
```php
'login' => [
    'label' => 'Anmelden',
    'placeholder' => 'Klicken Sie zum Anmelden',
    'tooltip' => 'Melden Sie sich in Ihrem persönlichen Konto an',
    'helper_text' => 'Klicken Sie hier, um sich mit Ihren Anmeldedaten in Ihren reservierten Bereich einzuloggen',
    'description' => 'Schaltfläche zum Anmelden im System mit den eigenen Authentifizierungsdaten',
    'icon' => 'heroicon-o-arrow-right-on-rectangle',
    'color' => 'success',
],
```

#### Inglese (Standard)
```php
'login' => [
    'label' => 'Login',
    'placeholder' => 'Click to login',
    'tooltip' => 'Access your personal account',
    'helper_text' => 'Click here to access your reserved area with your credentials',
    'description' => 'Button to access the system with your authentication credentials',
    'icon' => 'heroicon-o-arrow-right-on-rectangle',
    'color' => 'success',
],
```

## Regola Critica: helper_text Normalizzazione

**Se il valore di `helper_text` è uguale alla chiave del campo padre, DEVE essere impostato a stringa vuota (`''`).**

### Esempio Errato
```php
'province' => [
    'description' => 'province',
    'helper_text' => 'province', // ❌ ERRATO
    'placeholder' => 'province',
    'label' => 'province',
],
```

### Esempio Corretto
```php
'province' => [
    'description' => 'province',
    'helper_text' => '', // ✅ CORRETTO
    'placeholder' => 'province',
    'label' => 'province',
],
```

### Motivazione
- Evita ridondanza inutile nell'interfaccia utente
- Migliora la leggibilità e l'esperienza utente
- Mantiene coerenza nella struttura delle traduzioni
- Segue principi DRY (Don't Repeat Yourself)

## Terminologia Medica Standard

### Tedesco
- **Stadt**: Città
- **Praxis**: Studio medico/odontoiatrico
- **Arzt**: Medico
- **Zahnarzt**: Dentista
- **Patient**: Paziente
- **Termin**: Appuntamento
- **Behandlung**: Trattamento
- **Wohnsitz**: Residenza
- **Standort**: Ubicazione
- **eingeben**: inserire
- **auswählen**: selezionare

### Inglese
- **City**: Città
- **Practice**: Studio medico/odontoiatrico
- **Doctor**: Medico
- **Dentist**: Dentista
- **Patient**: Paziente
- **Appointment**: Appuntamento
- **Treatment**: Trattamento
- **Residence**: Residenza
- **Location**: Ubicazione
- **Enter**: inserire
- **Select**: selezionare

## Icone Standard per Contesti

### Geografici
- `heroicon-o-map-pin`: Città, indirizzo, ubicazione
- `heroicon-o-globe-alt`: Paese, nazione
- `heroicon-o-building-office`: Edificio, studio

### Medici
- `heroicon-o-user`: Paziente, utente
- `heroicon-o-user-group`: Team medico
- `heroicon-o-calendar`: Appuntamenti
- `heroicon-o-clipboard-document-list`: Documentazione medica

### Comunicazione
- `heroicon-o-phone`: Telefono
- `heroicon-o-envelope`: Email
- `heroicon-o-chat-bubble-left-right`: Messaggi

## Colori Standard per Contesti

### Priorità
- `primary`: Campi principali (nome, città, email)
- `secondary`: Campi secondari (note, descrizioni)
- `success`: Conferme, stati positivi
- `danger`: Errori, eliminazioni, stati critici
- `warning`: Attenzioni, stati intermedi
- `info`: Informazioni aggiuntive, aiuti

## Checklist di Verifica

### Per Ogni File di Traduzione
- [ ] Include `declare(strict_types=1);`
- [ ] Utilizza sintassi breve `[]`
- [ ] Ogni campo ha tutti i 7 elementi obbligatori
- [ ] Terminologia coerente con la lingua
- [ ] Icone appropriate al contesto
- [ ] Colori coerenti con la funzione
- [ ] Nessun testo in italiano nei file non italiani

### Per Ogni Campo "Città"
- [ ] Label tradotta correttamente
- [ ] Placeholder con verbo appropriato ("eingeben", "enter", "inserisci")
- [ ] Tooltip conciso e descrittivo
- [ ] Helper_text dettagliato e contestuale
- [ ] Description completa del campo
- [ ] Icona `heroicon-o-map-pin`
- [ ] Colore `primary`

## File da Aggiornare (Priorità)

### Alta Priorità - Tedeschi
1. `/laravel/Modules/<nome progetto>/lang/de/patient-resource.php`
2. `/laravel/Modules/User/lang/de/registration.php`
3. `/laravel/Modules/User/lang/de/register_tenant.php`

### Media Priorità - Inglesi
1. `/laravel/Modules/User/lang/en/registration.php`
2. `/laravel/Modules/User/lang/en/register_tenant.php`

## Collegamenti Bidirezionali

- [<nome progetto> Translation Audit](../Modules/<nome progetto>/docs/translation_audit_city_fields.md)
- [User Module Translation Rules](../Modules/User/docs/widget-translation-rules.md)
- [Translation Syntax Fixes](translation_syntax_fixes.md)
- [Windsurf Translation Rules](../.windsurf/rules/translation-complete-structure.mdc)

## Implementazione

### Script di Verifica
```bash
# Verifica struttura campi traduzione
grep -r "label.*Città" laravel/Modules/*/lang/de/ laravel/Modules/*/lang/en/
```

### Comando PHPStan
```bash
cd laravel && ./vendor/bin/phpstan analyze Modules/*/lang/ --level=9
```

*Ultimo aggiornamento: [DATE] - Struttura completa standardizzata*
