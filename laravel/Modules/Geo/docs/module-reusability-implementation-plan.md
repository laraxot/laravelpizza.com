# Piano di Implementazione Riusabilità Moduli

## Stato Attuale
Lo script di verifica ha identificato **15 moduli** con problemi di riusabilità e oltre **1000 occorrenze** di hardcoding.

## Priorità di Correzione

### 1. CRITICO - File di Traduzione
I file di traduzione nei moduli riutilizzabili contengono placeholder e testi hardcoded:

**File da correggere:**
- `Modules/Notify/lang/en/test_smtp.php` - "<nome progetto>" in placeholder
- `Modules/Notify/lang/de/test_smtp.php` - "<nome progetto>" in placeholder  
- `Modules/Notify/lang/en/test_smtp.php` - "<nome progetto>" in placeholder
- `Modules/Notify/lang/de/test_smtp.php` - "<nome progetto>" in placeholder  
- Altri file di traduzione con hardcoding

**Pattern di correzione:**
```php
// ❌ PRIMA
'placeholder' => 'Test configurazione SMTP - <nome progetto>',
'placeholder' => 'Test configurazione SMTP - <nome progetto>',

// ✅ DOPO
'placeholder' => 'Test configurazione SMTP - {{app_name}}',
```

### 2. CRITICO - Helper e Configurazioni
**File critici identificati:**
- `Modules/Xot/Helpers/PathHelper.php` - Path hardcoded
- Configurazioni database hardcoded
- URL API hardcoded

**Correzioni richieste:**
```php
// ❌ PRIMA
public static string $projectBasePath = '/var/www/html/<nome progetto>';
public static string $projectBasePath = '/var/www/html/<nome progetto>';

// ✅ DOPO  
public static function getProjectBasePath(): string
{
    return config('app.project_path', '/var/www/html/project');
}
```

### 3. IMPORTANTE - Documentazione
Aggiornare tutti i file di documentazione per rimuovere riferimenti specifici al progetto.

**Pattern di correzione:**
```markdown
<!-- ❌ PRIMA -->
# Implementazione Pagina Servizi - <nome progetto>
# Implementazione Pagina Servizi - <nome progetto>

<!-- ✅ DOPO -->
# Implementazione Pagina Servizi - Progetto Laraxot
```

### 4. NORMALE - File di Test
Aggiornare i test per utilizzare pattern dinamici con XotData.

## Azioni Implementate

### ✅ Completate
1. **NotificationManagementBusinessLogicTest.php** - Rimosso hardcoding "<nome progetto>"
1. **NotificationManagementBusinessLogicTest.php** - Rimosso hardcoding "<nome progetto>"
2. **NotifyThemeableFactory.php** - Implementato `getProjectNamespace()` 
3. **Documentazione base** - Creata `docs/module_reusability_guidelines.md`
4. **Regole Cursor/Windsurf** - Aggiornate con nuove regole critiche
5. **Script di controllo** - Creato `bashscripts/check_module_reusability.sh`

### 🔄 In Corso
1. **File di traduzione** - Correzione placeholder hardcoded
2. **Helper PathHelper.php** - Implementazione pattern dinamici
3. **Documentazione moduli** - Rimozione riferimenti specifici

### ⏳ Da Fare
1. **Modulo User** - 141 occorrenze da correggere
2. **Modulo UI** - 115 occorrenze da correggere  
3. **Modulo Cms** - 194 occorrenze da correggere
4. **Modulo Geo** - 86 occorrenze da correggere

## Strategia di Implementazione

### Fase 1: File Critici (Questa settimana)
- Correggere PathHelper.php nel modulo Xot
- Aggiornare file di traduzione con placeholder dinamici
- Correggere configurazioni database hardcoded

### Fase 2: Documentazione (Prossima settimana)  
- Aggiornamento sistematico di tutti i file .md
- Rimozione riferimenti specifici ai progetti
- Aggiornamento link e path

### Fase 3: Test e Validazione (Settimana successiva)
- Aggiornamento test per utilizzare XotData
- Validazione completa con script di controllo
- Test di integrazione multi-progetto

## Pattern di Automazione

### Script di Correzione Automatica
```bash
#!/bin/bash
# Correzione automatica per file di traduzione

find Modules/*/lang/ -name "*.php" -exec sed -i 's/<nome progetto>/{{app_name}}/g' {} \;
find Modules/*/lang/ -name "*.php" -exec sed -i 's/<nome progetto>\.com/{{app_domain}}/g' {} \;
find Modules/*/lang/ -name "*.php" -exec sed -i 's/<nome progetto>/{{app_name}}/g' {} \;
find Modules/*/lang/ -name "*.php" -exec sed -i 's/<nome progetto>\.com/{{app_domain}}/g' {} \;
```

### Validazione Continua
- Hook pre-commit per verificare hardcoding
- CI/CD pipeline con controlli automatici
- Review automatica per moduli riutilizzabili

## Metriche di Successo

### Target da Raggiungere
- **0 occorrenze** di nomi progetti nei moduli riutilizzabili
- **100% utilizzo** di XotData per classi dinamiche
- **Script di controllo** che passa senza errori
- **Documentazione** completamente project-agnostic

### Controllo Finale
```bash
# Deve restituire 0 errori
./bashscripts/check_module_reusability.sh
```

## Collegamenti

- [module_reusability_guidelines.md](module_reusability_guidelines.md)
- [Modules/Notify/docs/reusability_guidelines.md](../laravel/Modules/Notify/docs/reusability_guidelines.md)
- [.cursor/rules/module_reusability_critical.md](../.cursor/rules/module_reusability_critical.md)

*Ultimo aggiornamento: gennaio 2025*
