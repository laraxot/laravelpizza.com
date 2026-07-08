#!/bin/bash
# Script wrapper per la conversione di PDF in Markdown

# Verifica che sia stato fornito almeno un argomento
if [ $# -eq 0 ]; then
    echo "Utilizzo: $0 <file.pdf> [opzioni]"
    echo "Opzioni:"
    echo "  -o, --output FILE    Specifica il file di output"
    echo "  -l, --lang LINGUA    Imposta la lingua per l'OCR (default: ita)"
    echo "  --dpi RISOLUZIONE   Imposta la risoluzione DPI (default: 300)"
    echo "  --help               Mostra questo messaggio di aiuto"
    exit 1
fi

# Imposta i valori predefiniti
INPUT_FILE=""
OUTPUT_FILE=""
LANG="ita"
DPI=300

# Analizza gli argomenti
while [ $# -gt 0 ]; do
    case "$1" in
        -o|--output)
            OUTPUT_FILE="$2"
            shift 2
            ;;
        -l|--lang)
            LANG="$2"
            shift 2
            ;;
        --dpi)
            DPI="$2"
            shift 2
            ;;
        --help)
            echo "Utilizzo: $0 <file.pdf> [opzioni]"
            echo "Opzioni:"
            echo "  -o, --output FILE    Specifica il file di output"
            echo "  -l, --lang LINGUA    Imposta la lingua per l'OCR (default: ita)"
            echo "  --dpi RISOLUZIONE   Imposta la risoluzione DPI (default: 300)"
            echo "  --help               Mostra questo messaggio di aiuto"
            exit 0
            ;;
        *)
            if [ -z "$INPUT_FILE" ] && [[ "$1" == *.pdf ]]; then
                INPUT_FILE="$1"
            else
                echo "Argomento non riconosciuto: $1"
                exit 1
            fi
            shift
            ;;
    esac
done

# Verifica che il file di input esista
if [ ! -f "$INPUT_FILE" ]; then
    echo "Errore: il file '$INPUT_FILE' non esiste."
    exit 1
fi

# Imposta il file di output se non specificato
if [ -z "$OUTPUT_FILE" ]; then
    OUTPUT_FILE="${INPUT_FILE%.*}.md"
fi

# Esegui lo script Python con i parametri specificati
python3 "$(dirname "$0")/pdf_to_markdown.py" "$INPUT_FILE" -o "$OUTPUT_FILE" -l "$LANG" --dpi "$DPI"

# Verifica se la conversione è andata a buon fine
if [ $? -eq 0 ]; then
    echo "Conversione completata con successo!"
    echo "File generato: $OUTPUT_FILE"
else
    echo "Si è verificato un errore durante la conversione."
    exit 1
fi
