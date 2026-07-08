#!/bin/bash

# Configurazione
PDF_PATH="/var/www/html/<nome progetto>/bashscripts/pdf/test.pdf"
OUTPUT_MD="/var/www/html/<nome progetto>/bashscripts/pdf/test_completo.md"
TEMP_DIR="/tmp/pdf_conversion_$(date +%s)"

# Crea la directory temporanea
mkdir -p "$TEMP_DIR"

# Funzione per estrarre metadati
extract_metadata() {
    echo "# Event Sourcing in Laravel"
    echo "*Autore: Brent Roose*"
    echo -e "*Generato il: $(date '+%Y-%m-%d %H:%M:%S')*"
    echo -e "*Pagine: 215*\n"
    echo -e "## Indice\n"
    echo "- [Prefazione](#prefazione)"
    echo "- [Introduzione](#introduzione)"
    echo "- [Parte 1: Le Basi](#parte-1-le-basi)"
    echo "  - [1. Design Guidato dagli Eventi](#1-design-guidato-dagli-eventi)"
    echo "  - [2. L'Event Bus](#2-levento-bus)"
    echo "  - [3. Gli Eventi](#3-gli-eventi)"
    echo "  - [4. Modellare il Mondo](#4-modellare-il-mondo)"
    echo "  - [5. Memorizzare e Proiettare Eventi](#5-memorizzare-e-proiettare-eventi)"
    echo "  - [6. Approfondimento sui Proiettori](#6-approfondimento-sui-proiettori)"
    echo "  - [7. Query sugli Eventi](#7-query-sugli-eventi)"
    echo "  - [8. Le Radici di Aggregazione](#8-le-radici-di-aggregazione)"
    echo "- [Parte 2: Pattern Avanzati](#parte-2-pattern-avanzati)"
    echo "- [Parte 3: Sfide con l'Event Sourcing](#parte-3-sfide-con-levento-sourcing)"
    echo -e "\n---\n"
}

# Estrai il testo con pdftotext (se disponibile)
if command -v pdftotext &> /dev/null; then
    echo "🔍 Estrazione completa del testo dal PDF..."
    
    # Estrai il testo grezzo con codifica UTF-8 e mantenimento del layout
    pdftotext -layout -enc UTF-8 -eol unix -nopgbrk -nodiag "$PDF_PATH" "$TEMP_DIR/raw_text.txt"
    
    # Estrai anche in modalità semplice per confronto
    pdftotext -raw -enc UTF-8 -eol unix "$PDF_PATH" "$TEMP_DIR/raw_text_simple.txt"
    
    # Estrai metadati
    echo "📝 Elaborazione del contenuto..."
    
    # Crea il file Markdown
    extract_metadata > "$OUTPUT_MD"
    
    # Aggiungi il contenuto grezzo mantenendo la formattazione
    echo "## Contenuto Completo" >> "$OUTPUT_MD"
    echo "" >> "$OUTPUT_MD"
    
    # Usa il contenuto con layout migliore
    if [ -s "$TEMP_DIR/raw_text.txt" ]; then
        cat "$TEMP_DIR/raw_text.txt" | \
        tr '\r' '\n' | \
        sed 's/^ *//;s/ *$//' | \
        sed '/^$/N;/^\n$/D' | \
        sed 's/  */ /g' | \
        sed 's/^#/\#/g' | \
        sed 's/^\*/* /g' | \
        sed 's/^    \*/    * /g' | \
        sed 's/^    \([0-9]\)/1. /g' >> "$OUTPUT_MD"
    else
        cat "$TEMP_DIR/raw_text_simple.txt" >> "$OUTPUT_MD"
    fi
    
    # Aggiungi il piè di pagina
    echo -e "\n---\n" >> "$OUTPUT_MD"
    echo "*Documento convertito da PDF a Markdown*" >> "$OUTPUT_MD"
    echo "*Strumento utilizzato: pdftotext*" >> "$OUTPUT_MD"
    echo "*Data di conversione: $(date '+%Y-%m-%d %H:%M:%S')*" >> "$OUTPUT_MD"
    
    # Mostra il risultato
    echo -e "\n✅ Conversione completata con successo!"
    echo "   File salvato in: $OUTPUT_MD"
    echo -e "\n📝 Statistiche del file generato:"
    wc -w "$OUTPUT_MD"
    
    # Pulisci i file temporanei
    rm -rf "$TEMP_DIR"
else
    echo "❌ Errore: pdftotext non è installato"
    echo "   Installa con: sudo apt-get install poppler-utils"
    exit 1
fi
