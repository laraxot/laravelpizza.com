#!/bin/bash

# Script per verificare nomi italiani nei modelli Laravel
# Regola: MAI usare nomi italiani per modelli, classi, metodi, proprietà

echo "🔍 Verifica nomi italiani nei modelli Laravel..."
echo "=================================================="

# Cerca modelli con nomi italiani
echo "📋 Cercando modelli con nomi italiani..."

ITALIAN_MODELS=(
    "Timbratura" "Dipendente" "Contratto" "Reparto" "Luogo"
    "Utente" "Profilo" "Notifica" "Configurazione" "Impostazione"
    "Autenticazione" "Autorizzazione" "Validazione" "Trasformazione"
    "Calcolo" "Elaborazione" "Gestione" "Controllo" "Verifica"
)

FOUND_ITALIAN=false

for model in "${ITALIAN_MODELS[@]}"; do
    if grep -r "class $model" laravel/Modules/ --include="*.php" > /dev/null 2>&1; then
        echo "❌ ERRORE CRITICO: Trovato modello italiano '$model'"
        grep -r "class $model" laravel/Modules/ --include="*.php"
        FOUND_ITALIAN=true
    fi
done

# Cerca proprietà italiane comuni
echo ""
echo "📋 Cercando proprietà con nomi italiani..."

ITALIAN_PROPERTIES=(
    "data_" "tipo" "metodo" "stato" "note" "indirizzo"
    "latitudine" "longitudine" "utente_id" "profilo_id"
    "configurazione" "impostazione" "autenticazione"
)

for prop in "${ITALIAN_PROPERTIES[@]}"; do
    if grep -r "\$fillable.*$prop" laravel/Modules/ --include="*.php" > /dev/null 2>&1; then
        echo "❌ ERRORE: Trovata proprietà italiana '$prop'"
        grep -r "\$fillable.*$prop" laravel/Modules/ --include="*.php"
        FOUND_ITALIAN=true
    fi
done

# Cerca metodi italiani
echo ""
echo "📋 Cercando metodi con nomi italiani..."

ITALIAN_METHODS=(
    "isEntrata" "isUscita" "getData" "getTipo" "getMetodo"
    "setStato" "hasNote" "getIndirizzo" "getLatitudine"
    "getLongitudine" "isManuale" "hasIndirizzo"
)

for method in "${ITALIAN_METHODS[@]}"; do
    if grep -r "function $method" laravel/Modules/ --include="*.php" > /dev/null 2>&1; then
        echo "❌ ERRORE: Trovato metodo italiano '$method'"
        grep -r "function $method" laravel/Modules/ --include="*.php"
        FOUND_ITALIAN=true
    fi
done

if [ "$FOUND_ITALIAN" = false ]; then
    echo ""
    echo "✅ Nessun nome italiano trovato nei modelli!"
    echo "✅ Tutti i modelli seguono le convenzioni inglesi Laravel"
else
    echo ""
    echo "🚨 ERRORE CRITICO: Trovati nomi italiani!"
    echo "🚨 Correggere immediatamente seguendo le convenzioni inglesi"
    echo ""
    echo "📚 Riferimenti:"
    echo "- .cursor/rules/model_naming_standards.md"
    echo "- Laravel Naming Conventions"
    exit 1
fi

echo ""
echo "✅ Verifica completata!" 