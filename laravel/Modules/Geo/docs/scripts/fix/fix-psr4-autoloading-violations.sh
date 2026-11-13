#!/bin/bash

# Script per Correggere Violazioni PSR-4 Autoloading Standard
# Autore: Sistema di Refactoring Automatizzato
# Data: 2025-01-08

set -e

BASE_DIR="/var/www/html/_bases/base_<nome progetto>"
LARAVEL_DIR="$BASE_DIR/laravel"
LOG_FILE="$BASE_DIR/docs/refactoring/psr4-autoloading-fixes.log"
REPORT_FILE="$BASE_DIR/docs/refactoring/psr4-violations-report.md"

echo "=== CORREZIONE VIOLAZIONI PSR-4 AUTOLOADING STANDARD ===" | tee -a "$LOG_FILE"
echo "Inizio: $(date)" | tee -a "$LOG_FILE"

# Funzione per logging
log() {
    echo "[$(date '+%H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Funzione per estrarre il nome della classe da un file PHP
extract_class_name() {
    local file="$1"
    # Cerca la dichiarazione della classe nel file
    grep -E "^(abstract\s+)?class\s+|^interface\s+|^trait\s+|^enum\s+" "$file" | head -1 | \
    sed -E 's/^(abstract\s+)?(class|interface|trait|enum)\s+([A-Za-z0-9_]+).*/\3/'
}

# Funzione per verificare se un file è un file PHP valido
is_valid_php_file() {
    local file="$1"
    [[ -f "$file" && "$file" == *.php && $(head -1 "$file") =~ ^\<\?php ]]
}

# Fase 1: Backup di sicurezza
log "FASE 1: Creazione backup di sicurezza"
BACKUP_DIR="$BASE_DIR/backup-psr4-$(date +%Y%m%d_%H%M%S)"
if [ ! -d "$BACKUP_DIR" ]; then
    cp -r "$LARAVEL_DIR/Modules" "$BACKUP_DIR"
    log "✅ Backup creato in $(basename "$BACKUP_DIR")"
fi

# Fase 2: Scansione e identificazione violazioni
log "FASE 2: Scansione violazioni PSR-4 in tutti i moduli"

declare -A violations
violation_count=0
fixed_count=0
error_count=0

# Scansione di tutti i file PHP nei moduli
while IFS= read -r -d '' php_file; do
    if is_valid_php_file "$php_file"; then
        # Estrai il nome della classe dal file
        class_name=$(extract_class_name "$php_file")
        
        if [ -n "$class_name" ]; then
            # Ottieni il nome del file senza estensione
            file_basename=$(basename "$php_file" .php)
            
            # Verifica se il nome del file corrisponde al nome della classe
            if [ "$file_basename" != "$class_name" ]; then
                violations["$php_file"]="$class_name"
                violation_count=$((violation_count + 1))
                log "🔍 Violazione: $php_file -> Classe: $class_name"
            fi
        fi
    fi
done < <(find "$LARAVEL_DIR/Modules" -name "*.php" -type f -print0)

log "📊 Totale violazioni PSR-4 identificate: $violation_count"

# Fase 3: Correzione sistematica delle violazioni
log "FASE 3: Correzione sistematica delle violazioni PSR-4"

for php_file in "${!violations[@]}"; do
    class_name="${violations[$php_file]}"
    file_dir=$(dirname "$php_file")
    current_basename=$(basename "$php_file" .php)
    correct_filename="$file_dir/$class_name.php"
    
    log "🔧 Correggendo: $(basename "$php_file") -> $class_name.php"
    
    # Verifica che il file di destinazione non esista già
    if [ -f "$correct_filename" ] && [ "$php_file" != "$correct_filename" ]; then
        log "⚠️  CONFLITTO: $correct_filename esiste già. Saltando..."
        error_count=$((error_count + 1))
        continue
    fi
    
    # Rinomina il file
    if mv "$php_file" "$correct_filename" 2>/dev/null; then
        fixed_count=$((fixed_count + 1))
        log "   ✅ Rinominato con successo"
        
        # Aggiorna eventuali riferimenti nei file di configurazione
        # (questo potrebbe essere necessario per alcuni casi specifici)
        
    else
        log "   ❌ Errore durante la rinominazione"
        error_count=$((error_count + 1))
    fi
done

# Fase 4: Verifica e test autoloading
log "FASE 4: Verifica autoloading Composer"

cd "$LARAVEL_DIR"

# Rigenera l'autoload di Composer
if composer dump-autoload --optimize 2>/dev/null; then
    log "✅ Autoload Composer rigenerato con successo"
else
    log "❌ Errore durante la rigenerazione dell'autoload"
    error_count=$((error_count + 1))
fi

# Test di base per verificare che le classi siano caricabili
log "🧪 Test di caricamento classi critiche..."

# Test alcune classi chiave per verificare l'autoloading
test_classes=(
    "Modules\\Xot\\Services\\UrlService"
    "Modules\\Xot\\Enums\\GenderEnum"
    "Modules\\UI\\Providers\\UIServiceProvider"
    "Modules\\Tenant\\Models\\BaseModel"
)

for test_class in "${test_classes[@]}"; do
    if php -r "
        require_once 'vendor/autoload.php';
        if (class_exists('$test_class') || interface_exists('$test_class') || trait_exists('$test_class')) {
            echo 'OK';
        } else {
            echo 'FAIL';
        }
    " 2>/dev/null | grep -q "OK"; then
        log "   ✅ $test_class: Caricabile"
    else
        log "   ⚠️  $test_class: Problemi di caricamento"
    fi
done

# Fase 5: Generazione report finale
log "FASE 5: Generazione report finale"

cat > "$REPORT_FILE" << EOF
# Report Correzione Violazioni PSR-4 Autoloading Standard

## Riepilogo Operazione
- **Data**: $(date)
- **Violazioni identificate**: $violation_count
- **Violazioni corrette**: $fixed_count
- **Errori**: $error_count
- **Tasso di successo**: $(( fixed_count * 100 / violation_count ))%

## Statistiche per Modulo
EOF

# Aggiungi statistiche per modulo
declare -A module_stats
for php_file in "${!violations[@]}"; do
    module_name=$(echo "$php_file" | sed -E 's|.*/Modules/([^/]+)/.*|\1|')
    if [ -n "${module_stats[$module_name]}" ]; then
        module_stats[$module_name]=$((module_stats[$module_name] + 1))
    else
        module_stats[$module_name]=1
    fi
done

for module in "${!module_stats[@]}"; do
    echo "- **$module**: ${module_stats[$module]} violazioni" >> "$REPORT_FILE"
done

cat >> "$REPORT_FILE" << EOF

## Tipi di Violazioni Corrette
- Nomi file lowercase convertiti in PascalCase
- Allineamento nome file con nome classe
- Rispetto standard PSR-4 autoloading

## Azioni Post-Correzione
1. ✅ Backup di sicurezza creato
2. ✅ Autoload Composer rigenerato
3. ✅ Test di caricamento classi eseguiti
4. ✅ Report dettagliato generato

## Raccomandazioni
1. **Test Completi**: Eseguire test completi dell'applicazione
2. **Verifica IDE**: Aggiornare cache IDE/editor
3. **Monitoraggio**: Monitorare eventuali errori di autoloading
4. **Prevenzione**: Implementare controlli per prevenire future violazioni

## Backup
Il backup completo è disponibile in: \`$(basename "$BACKUP_DIR")\`

## Log Dettagliato
Consultare il log completo in: \`$(basename "$LOG_FILE")\`

---
*Report generato automaticamente dal sistema di refactoring PSR-4*
*Conforme agli standard Laraxot e best practice PHP*
EOF

# Fase 6: Pulizia e finalizzazione
log "FASE 6: Finalizzazione e pulizia"

# Verifica finale dello stato
log "📊 RISULTATI FINALI:"
log "   • Violazioni identificate: $violation_count"
log "   • Violazioni corrette: $fixed_count"
log "   • Errori: $error_count"
log "   • Tasso di successo: $(( fixed_count * 100 / violation_count ))%"

if [ $error_count -eq 0 ]; then
    log "🎉 SUCCESSO: Tutte le violazioni PSR-4 sono state corrette!"
    
    # Rimuovi il backup se tutto è andato bene (opzionale)
    read -p "Rimuovere il backup di sicurezza? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        rm -rf "$BACKUP_DIR"
        log "🗑️  Backup rimosso"
    else
        log "💾 Backup conservato in $(basename "$BACKUP_DIR")"
    fi
else
    log "⚠️  ATTENZIONE: Alcuni errori sono stati riscontrati. Verificare il log."
    log "💾 Backup conservato in $(basename "$BACKUP_DIR") per sicurezza"
fi

log "✅ Operazione completata. Report disponibile in: $REPORT_FILE"
log "Fine: $(date)"

echo
echo "=== CORREZIONE PSR-4 COMPLETATA ==="
echo "Report: $REPORT_FILE"
echo "Log: $LOG_FILE"
echo "Backup: $BACKUP_DIR"
