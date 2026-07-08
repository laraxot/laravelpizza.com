# Quick Start per Script di Seeding Database

## Panoramica
Questa cartella contiene script di seeding generici che possono essere utilizzati in qualsiasi progetto Laravel con moduli.

## Regole Importanti
⚠️ **ATTENZIONE**: Nessun file in questa cartella deve riferirsi specificatamente a questo progetto (<nome progetto>).

### ✅ Cosa DEVE essere qui:
- Script di utilità generale per seeding database
- Template riutilizzabili per progetti diversi
- Funzioni helper comuni
- Script che utilizzano variabili di ambiente o configurazione

### ❌ Cosa NON deve essere qui:
- Script con nomi specifici del progetto (es. `<nome progetto>-*`, `<nome progetto>-*`)
- Hardcoded references a moduli specifici
- Logica business specifica del progetto
- Dati specifici del dominio sanitario

## Script Generici Disponibili
Tutti gli script in questa cartella devono essere generici e riutilizzabili.

## Script Specifici del Progetto
Gli script specifici per <nome progetto> sono stati spostati nelle cartelle appropriate:

### Script <nome progetto>
- **Posizione**: `laravel/Modules/<nome progetto>/scripts/seeding/`
- **Contenuto**: Script di seeding specifici per il modulo <nome progetto>

### Script <nome progetto>
- **Posizione**: `laravel/Modules/<nome progetto>/scripts/seeding/`
- **Contenuto**: Script di seeding specifici per il modulo <nome progetto>

### Script Generatori
- **Posizione**: `laravel/Modules/{ModuleName}/scripts/generators/`
- **Contenuto**: Script per generare factory e seeder specifici del modulo

## Template per Script Generico
Esempio di come dovrebbe essere strutturato uno script generico:

```php
<?php
/**
 * Generic Database Seeding Script
 * Can be used in any Laravel project with modules
 */

// Use environment variables or config for project-specific data
$moduleName = env('SEEDING_MODULE', 'DefaultModule');
$recordCount = env('SEEDING_COUNT', 100);

function seedGenericData($module, $count) {
    // Generic seeding logic that works with any module
    $modelClass = "\\Modules\\{$module}\\Models\\User";
    
    if (class_exists($modelClass)) {
        $modelClass::factory()->count($count)->create();
    }
}
```

## Utilizzo
Per utilizzare gli script specifici del progetto:

```bash
# Script <nome progetto>
php laravel/Modules/<nome progetto>/scripts/seeding/mass-seeding.php

# Script <nome progetto>  
php laravel/Modules/<nome progetto>/scripts/seeding/database-seeding.php

# Generatori
bash laravel/Modules/<nome progetto>/scripts/generators/generate_factories_and_seeders.sh
```

## Principi di Organizzazione
1. **Bashscripts generici**: Script riutilizzabili tra progetti
2. **Script modulo-specifici**: Nella cartella `scripts/` del modulo
3. **Nessun riferimento specifico**: I file in bashscripts/ non devono riferirsi a progetti specifici
4. **Portabilità**: Tutti gli script devono essere portabili tra ambienti
5. **Configurabilità**: Usare variabili d'ambiente per personalizzazioni

## Controllo di Qualità
Prima di aggiungere uno script in questa cartella, verificare:
- [ ] Non contiene riferimenti hardcoded al progetto
- [ ] Utilizza variabili di configurazione per personalizzazioni
- [ ] È riutilizzabile in altri progetti
- [ ] Ha documentazione generica
- [ ] Non contiene logica business specifica

*Ultimo aggiornamento: Gennaio 2025*
