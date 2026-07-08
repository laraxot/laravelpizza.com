# Regola Critica: Mai Hardcodare Nomi di Progetto nei Moduli Riutilizzabili

## Problema Identificato

Durante l'audit del modulo `Notify`, è stato identificato un **errore critico di architettura**: l'utilizzo di stringhe hardcoded con nomi di progetto specifici (es. "<nome progetto>", "<nome progetto>") in un modulo che deve essere riutilizzabile in progetti diversi.
Durante l'audit del modulo `Notify`, è stato identificato un **errore critico di architettura**: l'utilizzo di stringhe hardcoded con nomi di progetto specifici (es. "<nome progetto>", "<nome progetto>") in un modulo che deve essere riutilizzabile in progetti diversi.

## Impatto del Problema

### Violazioni Architetturali
1. **Principio di Modularità**: Il modulo Notify non è più indipendente
2. **Principio di Riutilizzabilità**: Impossibile utilizzare in altri progetti senza modifiche
3. **Principio di Separazione**: Il modulo conosce il progetto che lo utilizza
4. **Debito Tecnico**: Necessità di refactoring per ogni nuovo progetto

### Esempi di Violazioni Trovate
```php
// ❌ ERRORE CRITICO - Stringhe hardcoded
'subject' => 'Benvenuto su ',
'content' => 'Grazie per esserti registrato su ',
'clinic_name' => 'Studio Dentistico ',
'webhook' => 'https://api.<nome progetto>.com/webhooks',
'author' => 'Team PTVX',
'path' => 'public_html/images/',
'subject' => 'Benvenuto su <nome progetto>',
'content' => 'Grazie per esserti registrato su <nome progetto>',
'clinic_name' => 'Studio Dentistico <nome progetto>',
'webhook' => 'https://api.<nome progetto>.com/webhooks',
'author' => 'Team <nome progetto>',
'path' => 'public_html/images/',
'path' => 'public_html/images/',
```

## Soluzioni Implementate

### 1. File di Configurazione Centralizzato
```php
// Modules/Notify/config/notify.php
return [
    'company' => [
        'name' => env('COMPANY_NAME', 'Default Company'),
        'team' => env('COMPANY_TEAM', 'Default Team'),
        'webhook_base' => env('WEBHOOK_BASE_URL', 'https://api.example.com'),
        'clinic_name' => env('CLINIC_NAME', 'Default Clinic'),
    ],
    'test_data' => [
        'default_subject' => 'Benvenuto su {{company_name}}',
        'default_content' => 'Grazie per esserti registrato al nostro servizio.',
    ],
];
```

### 2. Helper per Sostituzione Variabili
```php
// Modules/Notify/app/Helpers/ConfigHelper.php
class ConfigHelper
{
    public static function replaceTemplateVariables(array $data): array
    {
        // Sostituisce {{company_name}} con il valore configurato
    }
}
```

### 3. Pattern per Test Modulari
```php
// ✅ CORRETTO - Dati configurabili
$testData = ConfigHelper::getTestData();
$notificationData = [
    'subject' => $testData['default_subject'],
    'content' => $testData['default_content'],
];
```

## Regole Assolute

### Moduli che DEVONO essere Generici
- **Notify**: Sistema di notifiche per qualsiasi progetto
- **User**: Gestione utenti per qualsiasi progetto
- **UI**: Componenti UI per qualsiasi progetto
- **Xot**: Base framework per qualsiasi progetto
- **Geo**: Gestione geografica per qualsiasi progetto
- **Media**: Gestione media per qualsiasi progetto

### Moduli Specifici del Progetto
- ****: Solo per progetto
- **<nome progetto>**: Solo per progetto <nome progetto>
- **<nome progetto>**: Solo per progetto <nome progetto>
- **Patient**: Solo per progetti sanitari specifici

## Checklist Pre-Commit

Prima di ogni commit, verificare:

- [ ] Nessuna stringa hardcoded con nomi di progetto specifici
- [ ] Tutti i test utilizzano dati generici o configurabili
- [ ] Factory e seeder sono generici e riutilizzabili
- [ ] Configurazioni sono centralizzate e configurabili
- [ ] Traduzioni non contengono nomi di progetto specifici
- [ ] Path e URL sono configurabili o relativi

## Test di Conformità

Eseguire regolarmente:
```bash
# Cerca stringhe hardcoded nei moduli generici
grep -r "<nome progetto>\|<nome progetto>" laravel/Modules/Notify/ --include="*.php"
grep -r "<nome progetto>\|<nome progetto>" laravel/Modules/User/ --include="*.php"
grep -r "<nome progetto>\|<nome progetto>" laravel/Modules/UI/ --include="*.php"
grep -r "<nome progetto>\|<nome progetto>" laravel/Modules/Xot/ --include="*.php"
grep -r "<nome progetto>\|<nome progetto>" laravel/Modules/Notify/ --include="*.php"
grep -r "<nome progetto>\|<nome progetto>" laravel/Modules/User/ --include="*.php"
grep -r "<nome progetto>\|<nome progetto>" laravel/Modules/UI/ --include="*.php"
grep -r "<nome progetto>\|<nome progetto>" laravel/Modules/Xot/ --include="*.php"
```

## Configurazione per Progetti

### Variabili d'Ambiente
```env
COMPANY_NAME=
COMPANY_TEAM=Team
WEBHOOK_BASE_URL=https://api.<nome progetto>.com
CLINIC_NAME=Studio Dentistico
REPOSITORY_URL=https://github.com/<nome progetto>/notify
COMPANY_NAME=<nome progetto>
COMPANY_TEAM=Team <nome progetto>
WEBHOOK_BASE_URL=https://api.<nome progetto>.com
CLINIC_NAME=Studio Dentistico <nome progetto>
REPOSITORY_URL=https://github.com/<nome progetto>/notify
```

### Override per Progetti Specifici
Ogni progetto può personalizzare i valori tramite variabili d'ambiente senza modificare il codice del modulo.

## Filosofia e Principi

### Approccio Modulare
- **Indipendenza**: Ogni modulo è un'entità autonoma
- **Configurabilità**: Tutto deve essere configurabile
- **Riutilizzabilità**: Un modulo deve funzionare ovunque
- **Separazione**: I moduli non conoscono i progetti
- **Scalabilità**: Crescita senza limiti di progetto

### Benefici della Correzione
1. **Modularità Vera**: Moduli completamente indipendenti
2. **Riutilizzabilità**: Funzionamento in qualsiasi progetto
3. **Manutenibilità**: Configurazione centralizzata
4. **Scalabilità**: Facile aggiunta di nuovi progetti
5. **Qualità**: Rispetto dei principi architetturali

## Documentazione Correlata

- [Testing Guidelines](testing-guidelines.md)
- [ConfigHelper Documentation](config-helper.md)
- [Configuration Guide](configuration-guide.md)

---

**Questa correzione è CRITICA per mantenere l'architettura modulare del sistema. Ogni violazione deve essere corretta immediatamente.**
