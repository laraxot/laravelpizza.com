#!/bin/bash

# Verifica se è stato fornito un parametro
if [ $# -eq 0 ]; then
    echo "Errore: Specificare il percorso del file con conflitti git"
    echo "Uso: $0 <percorso_file>"
    exit 1
fi

FILE_PATH="$1"

# Verifica se il file esiste
if [ ! -f "$FILE_PATH" ]; then
    echo "Errore: Il file $FILE_PATH non esiste"
    exit 1
fi

# Verifica se ollama è installato
if ! command -v ollama &> /dev/null; then
    echo "Errore: ollama non è installato"
    echo "Installa ollama da: https://ollama.ai"
    exit 1
fi

# Verifica se il modello codellama:7b è disponibile
if ! ollama list | grep -q "codellama:7b"; then
    echo "Il modello codellama:7b non è presente, lo scarico..."
    ollama pull codellama:7b
fi

# Legge il contenuto del file
CONTENT=$(cat "$FILE_PATH")

# Prepara il prompt per ollama
PROMPT="Risolvi i seguenti conflitti git mantenendo la logica corretta e la funzionalità del codice. Restituisci SOLO il codice risolto, senza spiegazioni o commenti aggiuntivi:

$CONTENT"

# Esegue ollama e salva l'output
RESOLVED=$(ollama run codellama:7b "$PROMPT")

# Verifica se l'output è vuoto
if [ -z "$RESOLVED" ]; then
    echo "Errore: Nessuna risposta da ollama"
    exit 1
fi

# Crea un backup del file originale
cp "$FILE_PATH" "${FILE_PATH}.backup"

# Salva la risoluzione nel file originale
echo "$RESOLVED" > "$FILE_PATH"

echo "Conflitti risolti con successo!"
echo "Backup del file originale salvato in: ${FILE_PATH}.backup"
echo "Verifica la risoluzione prima di committare" 