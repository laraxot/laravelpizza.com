#!/bin/bash

# Script per correggere le traduzioni inglesi che contengono testo italiano
# Regola: tutti i file in lang/en/ devono essere effettivamente in inglese

set -e

echo "🔍 Iniziando correzione traduzioni inglesi..."
echo "📋 Regola: tutti i file in lang/en/ devono essere in inglese"
echo ""

# Contatore per le correzioni
files_fixed=0

# Funzione per correggere un file specifico
fix_file() {
    local file="$1"
    local temp_file="${file}.tmp"
    
    echo "📄 Correggendo: $file"
    
    # Backup del file originale
    cp "$file" "${file}.backup"
    
    # Applica le correzioni comuni
    sed -i 's/Gennaio/January/g' "$file"
    sed -i 's/Febbraio/February/g' "$file"
    sed -i 's/Marzo/March/g' "$file"
    sed -i 's/Aprile/April/g' "$file"
    sed -i 's/Maggio/May/g' "$file"
    sed -i 's/Giugno/June/g' "$file"
    sed -i 's/Luglio/July/g' "$file"
    sed -i 's/Agosto/August/g' "$file"
    sed -i 's/Settembre/September/g' "$file"
    sed -i 's/Ottobre/October/g' "$file"
    sed -i 's/Novembre/November/g' "$file"
    sed -i 's/Dicembre/December/g' "$file"
    
    # Giorni della settimana
    sed -i 's/Lunedì/Monday/g' "$file"
    sed -i 's/Martedì/Tuesday/g' "$file"
    sed -i 's/Mercoledì/Wednesday/g' "$file"
    sed -i 's/Giovedì/Thursday/g' "$file"
    sed -i 's/Venerdì/Friday/g' "$file"
    sed -i 's/Sabato/Saturday/g' "$file"
    sed -i 's/Domenica/Sunday/g' "$file"
    
    # Abbreviazioni mesi
    sed -i 's/Gen/Jan/g' "$file"
    sed -i 's/Feb/Feb/g' "$file"
    sed -i 's/Mar/Mar/g' "$file"
    sed -i 's/Apr/Apr/g' "$file"
    sed -i 's/Mag/May/g' "$file"
    sed -i 's/Giu/Jun/g' "$file"
    sed -i 's/Lug/Jul/g' "$file"
    sed -i 's/Ago/Aug/g' "$file"
    sed -i 's/Set/Sep/g' "$file"
    sed -i 's/Ott/Oct/g' "$file"
    sed -i 's/Nov/Nov/g' "$file"
    sed -i 's/Dic/Dec/g' "$file"
    
    # Abbreviazioni giorni
    sed -i 's/Lun/Mon/g' "$file"
    sed -i 's/Mar/Tue/g' "$file"
    sed -i 's/Mer/Wed/g' "$file"
    sed -i 's/Gio/Thu/g' "$file"
    sed -i 's/Ven/Fri/g' "$file"
    sed -i 's/Sab/Sat/g' "$file"
    sed -i 's/Dom/Sun/g' "$file"
    
    # Abbreviazioni minime
    sed -i 's/Lu/Mo/g' "$file"
    sed -i 's/Ma/Tu/g' "$file"
    sed -i 's/Me/We/g' "$file"
    sed -i 's/Gi/Th/g' "$file"
    sed -i 's/Ve/Fr/g' "$file"
    sed -i 's/Sa/Sa/g' "$file"
    sed -i 's/Do/Su/g' "$file"
    
    # Termini comuni
    sed -i 's/Configurazione/Configuration/g' "$file"
    sed -i 's/Orari/Hours/g' "$file"
    sed -i 's/Mattina/Morning/g' "$file"
    sed -i 's/Pomeriggio/Afternoon/g' "$file"
    sed -i 's/Aperto/Open/g' "$file"
    sed -i 's/Chiuso/Closed/g' "$file"
    sed -i 's/Formato/Format/g' "$file"
    sed -i 's/Giorno/Day/g' "$file"
    sed -i 's/Sera/Evening/g' "$file"
    sed -i 's/Dalle/From/g' "$file"
    sed -i 's/Alle/To/g' "$file"
    sed -i 's/Oggi/Today/g' "$file"
    sed -i 's/Annulla/Cancel/g' "$file"
    sed -i 's/Salva/Save/g' "$file"
    sed -i 's/Chiudi/Close/g' "$file"
    sed -i 's/Titolo/Title/g' "$file"
    sed -i 's/Inizio/Start/g' "$file"
    sed -i 's/Fine/End/g' "$file"
    sed -i 's/Elimina/Delete/g' "$file"
    sed -i 's/Modifica/Edit/g' "$file"
    sed -i 's/Nuovo/New/g' "$file"
    sed -i 's/Evento/Event/g' "$file"
    sed -i 's/Eventi/Events/g' "$file"
    sed -i 's/Programmato/Scheduled/g' "$file"
    sed -i 's/Caricamento/Loading/g' "$file"
    sed -i 's/Inserisci/Enter/g' "$file"
    sed -i 's/Seleziona/Select/g' "$file"
    sed -i 's/Data/Date/g' "$file"
    sed -i 's/Ora/Time/g' "$file"
    sed -i 's/Obbligatorio/Required/g' "$file"
    sed -i 's/Valida/Valid/g' "$file"
    sed -i 's/Successiva/After/g' "$file"
    sed -i 's/Precedente/Before/g' "$file"
    sed -i 's/Mese/Month/g' "$file"
    sed -i 's/Successivo/Next/g' "$file"
    sed -i 's/Tutto il giorno/All day/g' "$file"
    sed -i 's/Nessun/No/g' "$file"
    sed -i 's/In corso/In progress/g' "$file"
    sed -i 's/Descrittivo/Descriptive/g' "$file"
    sed -i 's/Sicuro/Sure/g' "$file"
    sed -i 's/Voler/Want/g' "$file"
    sed -i 's/Eliminare/Delete/g' "$file"
    sed -i 's/Questo/This/g' "$file"
    sed -i 's/Con successo/Successfully/g' "$file"
    sed -i 's/Errore/Error/g' "$file"
    sed -i 's/Durante/During/g' "$file"
    sed -i 's/Creazione/Creation/g' "$file"
    sed -i 's/Salvataggio/Saving/g' "$file"
    sed -i 's/Modifiche/Changes/g' "$file"
    sed -i 's/Campo/Field/g' "$file"
    sed -i 's/È/Is/g' "$file"
    sed -i 's/Obbligatorio/Required/g' "$file"
    sed -i 's/Una/A/g' "$file"
    sed -i 's/Valida/Valid/g' "$file"
    sed -i 's/Di fine/Of end/g' "$file"
    sed -i 's/Di inizio/Of start/g' "$file"
    sed -i 's/Deve essere/Must be/g' "$file"
    sed -i 's/Successiva/After/g' "$file"
    sed -i 's/Precedente/Before/g' "$file"
    
    # Aggiungi declare(strict_types=1) se mancante
    if ! grep -q "declare(strict_types=1);" "$file"; then
        sed -i '2i\declare(strict_types=1);' "$file"
    fi
    
    ((files_fixed++))
    echo "✅ Corretto: $file"
}

# Trova tutti i file di traduzione inglesi
echo "🔍 Cercando file di traduzione inglesi..."
english_files=$(find laravel/Modules/*/lang/en -name "*.php" 2>/dev/null || true)

if [ -z "$english_files" ]; then
    echo "❌ Nessun file di traduzione inglese trovato"
    exit 1
fi

# Conta i file che contengono testo italiano
italian_count=0
for file in $english_files; do
    if grep -q "Gennaio\|Febbraio\|Marzo\|Aprile\|Maggio\|Giugno\|Luglio\|Agosto\|Settembre\|Ottobre\|Novembre\|Dicembre\|Lunedì\|Martedì\|Mercoledì\|Giovedì\|Venerdì\|Sabato\|Domenica\|Configurazione\|Orari\|Mattina\|Pomeriggio\|Aperto\|Chiuso" "$file"; then
        ((italian_count++))
        echo "🇮🇹 File con testo italiano trovato: $file"
    fi
done

if [ $italian_count -eq 0 ]; then
    echo "✅ Tutti i file di traduzione inglese sono già corretti"
    exit 0
fi

echo ""
echo "📊 Trovati $italian_count file con testo italiano da correggere"
echo ""

# Correggi i file
for file in $english_files; do
    if grep -q "Gennaio\|Febbraio\|Marzo\|Aprile\|Maggio\|Giugno\|Luglio\|Agosto\|Settembre\|Ottobre\|Novembre\|Dicembre\|Lunedì\|Martedì\|Mercoledì\|Giovedì\|Venerdì\|Sabato\|Domenica\|Configurazione\|Orari\|Mattina\|Pomeriggio\|Aperto\|Chiuso" "$file"; then
        fix_file "$file"
    fi
done

echo ""
echo "🎉 Correzione completata!"
echo "📊 File corretti: $files_fixed"
echo ""
echo "💡 Note:"
echo "   - I file originali sono stati salvati con estensione .backup"
echo "   - Verifica manualmente le traduzioni per termini specifici del dominio"
echo "   - Aggiorna la documentazione se necessario"
echo "" 