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
    "HasTeams_CurrentTeam_Method_Choice.md:hasteams_currentteam_method_choice.md"
    "USER_MODERATION_STRATEGY.md:user_moderation_strategy.md"
    "ACTIONS_STRUCTURE.md:actions_structure.md"
    "DATABASE_ERRORS.md:database_errors.md"
    "MODERATION_DOCTOR.md:moderation_doctor.md"
    "INDEX.md:index.md"
    "BaseUser.md:baseuser.md"
    "TEAM_CONTRACT_USAGE_REASONING.md:team_contract_usage_reasoning.md"
    "Dentist_Moderation_Approach.md:dentist_moderation_approach.md"
    "Generic_User_Moderation_Strategy.md:generic_user_moderation_strategy.md"
    "DATABASE_ISSUES.md:database_issues.md"
    "ACTIVITYLOG_MODERATION_BEST_PRACTICES.mdc:activitylog_moderation_best_practices.mdc"
    "MODERATION_WIZARD_GENERIC.md:moderation_wizard_generic.md"
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