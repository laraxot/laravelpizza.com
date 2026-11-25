#!/bin/bash

# Script per correggere naming file docs del modulo User secondo regole Laraxot
# Data: Gennaio 2025
# Regola: Solo README.md può avere caratteri maiuscoli

set -e

USER_DOCS_DIR="/var/www/html/ptvx/laravel/Modules/User/docs"

cd "$USER_DOCS_DIR"

echo "🔧 Correzione naming file docs modulo User..."

# Array di coppie: nome_vecchio -> nome_nuovo
declare -a RENAMES=(
    "hasteams-currentteam-method-choice-4.md:hasteams-currentteam-method-choice-4.md"
    "user-moderation-strategy-3.md:user-moderation-strategy-3.md"
    "actions-structure-4.md:actions-structure-4.md"
    "database-errors-2.md:database-errors-2.md"
    "moderation-doctor-2.md:moderation-doctor-2.md"
    "INDEX.md:index.md"
    "BaseUser.md:baseuser.md"
    "team-contract-usage-reasoning-2.md:team-contract-usage-reasoning-2.md"
    "dentist-moderation-approach-2.md:dentist-moderation-approach-2.md"
    "generic-user-moderation-strategy-3.md:generic-user-moderation-strategy-3.md"
    "database-issues-2.md:database-issues-2.md"
    "ACTIVITYLOG_MODERATION_BEST_PRACTICES.mdc:activitylog_moderation_best_practices.mdc"
    "moderation-wizard-generic-2.md:moderation-wizard-generic-2.md"
    "MODERATION_WIZARD_GENERIC.mdc:moderation_wizard_generic.mdc"
    "USER_STATES.mdc:user_states.mdc"
    "XOTBASEMIGRATION_BEST_PRACTICES.mdc:xotbasemigration_best_practices.mdc"
    "MODERATION_ACTIONS.mdc:moderation_actions.mdc"
    "MODERATION_CONTRACTS.mdc:moderation_contracts.mdc"
    "MODERATION_NOTIFICATIONS.mdc:moderation_notifications.mdc"
)

# Rinomina file nella directory principale
for rename_pair in "${RENAMES[@]}"; do
    old_name="${rename_pair%%:*}"
    new_name="${rename_pair##*:}"
    
    if [[ -f "$old_name" ]]; then
        echo "✅ Rinominando: $old_name -> $new_name"
        mv "$old_name" "$new_name"
    else
        echo "⚠️  File non trovato: $old_name"
    fi
done

# Rinomina file nelle sottocartelle
find . -type f -name "*.md" -o -name "*.mdc" | while read -r file; do
    if [[ "$file" == "./README.md" ]]; then
        continue  # Skip README.md
    fi
    
    dir=$(dirname "$file")
    basename=$(basename "$file")
    
    # Controlla se ha caratteri maiuscoli
    if [[ "$basename" =~ [A-Z] ]]; then
        new_basename=$(echo "$basename" | tr '[:upper:]' '[:lower:]')
        new_file="$dir/$new_basename"
        
        if [[ "$file" != "$new_file" ]]; then
            echo "✅ Sottocartella: $file -> $new_file"
            mv "$file" "$new_file"
        fi
    fi
done

echo "🎉 Correzione naming completata!"
echo "📁 Directory: $USER_DOCS_DIR"
echo "🔍 Verificare i collegamenti nei file aggiornati" 