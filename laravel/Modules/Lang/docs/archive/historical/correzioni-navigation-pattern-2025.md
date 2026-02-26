# Correzioni Pattern ".navigation" - Gennaio 2025

## Data Intervento
**2025-01-22** - Sistemazione traduzioni secondo regole DRY + KISS

## Problema Identificato

I file di traduzione contenevano valori con pattern `.navigation` invece di traduzioni localizzate appropriate:

```php
// ❌ ERRATO
'navigation' => [
    'label' => 'criteri esclusione.navigation',
    'group' => 'criteri esclusione.navigation',
    'icon' => 'criteri esclusione.navigation',
],
```

**Problemi causati**:
- Valori non tradotti visibili nell'interfaccia
- Chiavi circolari che causano loop di traduzione
- Mancanza di localizzazione appropriata
- Icone non valide

## File Corretti

### 1. `Modules/Ptv/lang/it/criteri_esclusione.php`

**Prima**:
```php
'navigation' => [
    'sort' => 96,
    'icon' => 'criteri esclusione.navigation',
    'group' => 'criteri esclusione.navigation',
    'label' => 'criteri esclusione.navigation',
],
```

**Dopo**:
```php
'navigation' => [
    'name' => 'Criterio di Esclusione',
    'plural' => 'Criteri di Esclusione',
    'sort' => 96,
    'icon' => 'heroicon-o-x-circle',
    'group' => 'Configurazione',
    'label' => 'Criteri di Esclusione',
],
```

### 2. `Modules/Performance/lang/it/organizzativa.php`

**Prima**:
```php
'navigation' => [
    'label' => 'organizzativa.navigation',
    'sort' => 80,
    'icon' => 'organizzativa.navigation',
    'group' => 'organizzativa.navigation',
],
```

**Dopo**:
```php
'navigation' => [
    'name' => 'Organizzativa',
    'plural' => 'Organizzative',
    'label' => 'Organizzative',
    'sort' => 80,
    'icon' => 'heroicon-o-chart-bar',
    'group' => 'Performance',
],
```

### 3. `Modules/Pdnd/lang/it/pdnd.php`

**Prima**:
```php
'navigation' => [
    'group' => 'pdnd.navigation',
],
```

**Dopo**:
```php
'navigation' => [
    'name' => 'PDND',
    'plural' => 'PDND',
    'label' => 'PDND',
    'group' => 'Servizi Esterni',
    'icon' => 'heroicon-o-globe-alt',
    'sort' => 50,
],
```

### 4. `Modules/Ptv/lang/it/message.php`

**Prima**:
```php
'navigation' => [
    'name' => 'message',
    'plural' => 'messages',
    'group' => [
        'name' => 'Admin',
    ],
    'sort' => 80,
    'icon' => 'message.navigation',
    'label' => 'message.navigation',
],
```

**Dopo**:
```php
'navigation' => [
    'name' => 'Messaggio',
    'plural' => 'Messaggi',
    'group' => [
        'name' => 'Admin',
        'description' => 'Amministrazione e configurazione',
    ],
    'sort' => 80,
    'icon' => 'heroicon-o-chat-bubble-left-right',
    'label' => 'Messaggi',
],
```

### 5. `Modules/Ptv/lang/it/option.php`

**Prima**:
```php
'navigation' => [
    'label' => 'option.navigation',
    'group' => 'option.navigation',
    'icon' => 'option.navigation',
    'sort' => 96,
],
```

**Dopo**:
```php
'navigation' => [
    'name' => 'Opzione',
    'plural' => 'Opzioni',
    'label' => 'Opzioni',
    'group' => 'Configurazione',
    'icon' => 'heroicon-o-cog-6-tooth',
    'sort' => 96,
],
```

### 6. `Modules/Incentivi/lang/it/department.php`

**Prima**:
```php
'navigation' => [
    'label' => 'Settori',
    'sort' => 16,
    'icon' => 'department.navigation',
    'group' => 'Tabelle di supporto',
],
```

**Dopo**:
```php
'navigation' => [
    'name' => 'Settore',
    'plural' => 'Settori',
    'label' => 'Settori',
    'sort' => 16,
    'icon' => 'heroicon-o-building-office-2',
    'group' => 'Tabelle di supporto',
],
```

## Regole Applicate

### DRY (Don't Repeat Yourself)
- Eliminata duplicazione di chiavi non tradotte
- Raggruppamento logico coerente
- Icone standard Heroicons per consistenza

### KISS (Keep It Simple, Stupid)
- Traduzioni dirette e chiare
- Nomi descrittivi e intuitivi
- Struttura semplice e leggibile

## Struttura Navigation Completa

Ogni sezione `navigation` deve includere:

```php
'navigation' => [
    'name' => 'Nome Singolare',        // Obbligatorio
    'plural' => 'Nome Plurale',        // Obbligatorio
    'label' => 'Etichetta Menu',       // Obbligatorio
    'group' => 'Gruppo Menu',          // Obbligatorio
    'icon' => 'heroicon-o-icon-name',  // Raccomandato
    'sort' => 50,                      // Opzionale
],
```

## Icone Heroicons Utilizzate

- `heroicon-o-x-circle` - Criteri di esclusione
- `heroicon-o-chart-bar` - Organizzative/Performance
- `heroicon-o-globe-alt` - Servizi esterni (PDND)
- `heroicon-o-chat-bubble-left-right` - Messaggi
- `heroicon-o-cog-6-tooth` - Configurazione/Opzioni
- `heroicon-o-building-office-2` - Settori/Departmenti

## Gruppi Navigation Standardizzati

- **Configurazione** - Impostazioni e opzioni di sistema
- **Performance** - Gestione performance e valutazioni
- **Servizi Esterni** - Integrazioni e servizi esterni
- **Admin** - Amministrazione e configurazione avanzata
- **Tabelle di supporto** - Tabelle di riferimento

## Benefici Ottenuti

1. **Localizzazione Corretta**: Traduzioni in italiano appropriate
2. **Coerenza UI**: Raggruppamento logico coerente
3. **Manutenibilità**: Eliminazione di chiavi hardcoded
4. **Standard Compliance**: Rispetto delle regole di traduzione Laraxot
5. **Icone Valide**: Utilizzo di icone Heroicons standard

## Validazione

- ✅ Nessuna chiave hardcoded con ".navigation"
- ✅ Traduzioni appropriate e localizzate
- ✅ Icone standard Heroicons
- ✅ Raggruppamento logico coerente
- ✅ Struttura completa con name, plural, label, group, icon, sort

## Collegamenti

- [Errori Comuni Traduzione](errori-comuni-traduzione.md)
- [Traduzioni Navigation Audit](traduzioni-navigation-2025.md)
- [Best Practices Traduzioni](../../Xot/docs/translation-standards.md)
- [NavigationLabelTrait Explained](../../Xot/docs/filament/navigation-label-trait-explained.md)

## Note Tecniche

- Mantenuta la struttura espansa esistente
- Preservata la sintassi array breve `[]`
- Rispettato il `declare(strict_types=1);`
- Icone scelte per semantica appropriata
- Gruppi organizzati per dominio logico

*Intervento completato il: 2025-01-22*
*Conforme alle regole DRY + KISS*

