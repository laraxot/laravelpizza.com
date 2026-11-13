#!/bin/bash
set -euo pipefail

# Modello da utilizzare
#MODEL="deepseek-coder:6.7b"
#MODEL="llama3.1:8b"
#MODEL="qwen2.5-coder:1.5b"
MODEL="codellama:7b"

# Controlla che i comandi necessari siano installati: curl, jq, mktemp
for cmd in curl jq mktemp; do
    if ! command -v "$cmd" >/dev/null 2>&1; then
        echo "Errore: il comando '$cmd' non è installato."
        exit 1
    fi
done

# Verifica che Ollama sia in esecuzione
check_ollama() {
    if ! curl -s http://localhost:11434/api/tags >/dev/null 2>&1; then
        echo "Errore: Ollama non è in esecuzione. Avvia Ollama prima di procedere."
        exit 1
    fi
}

# Verifica che il modello sia disponibile
check_model() {
    if ! curl -s http://localhost:11434/api/tags | jq -e '.models[] | select(.name=="'$MODEL'")' >/dev/null 2>&1; then
        echo "Errore: modello $MODEL non trovato. Esegui: ollama pull $MODEL"
        exit 1
    fi
}

# Funzione per correggere il codice PHP
fix_php_code() {
    local file="$1"
    local temp_file
    temp_file=$(mktemp)
    local prompt_file
    prompt_file=$(mktemp)
    
    # Assicura la rimozione dei file temporanei anche in caso di errore
    trap 'rm -f "${temp_file:-}" "${prompt_file:-}"' EXIT
    
    # Crea una copia di backup del file originale
    cp "$file" "${file}.backup"
    
    # Costruisci un prompt chiaro per il modello
    cat > "$prompt_file" <<EOF
You are an expert PHP developer tasked with fixing and optimizing the following code. Your objective is to:

1. Fix any syntax errors, unresolved merge conflicts, or logical issues
2. Remove git conflict markers (<<<<<<<, =======, >>>>>>>) if present
3. Optimize the code structure and readability without changing functionality
4. Ensure consistency in formatting and naming conventions
5. Apply PHP best practices and modern syntax where appropriate

Return ONLY the corrected and optimized PHP code, without any explanations, comments, or markdown formatting. The code should be complete and ready to use.

Here is the code:

EOF
    
    # Aggiungi il contenuto del file
    cat "$file" >> "$prompt_file"
    
    echo "Elaborazione del file $file in corso con il modello $MODEL..."
    
    # Prepara il payload JSON per la richiesta all'API di Ollama
    local json_payload
    json_payload=$(jq -n --arg model "$MODEL" --arg prompt "$(cat "$prompt_file")" '{model: $model, prompt: $prompt, stream: false}')
    
    # Richiama l'API di Ollama per ottenere la versione corretta
    local response
    response=$(curl -s http://localhost:11434/api/generate -d "$json_payload" | jq -r '.response')
    
    if [ -z "$response" ]; then
        echo "Errore: Nessuna risposta da Ollama. Verifica il servizio."
        exit 1
    fi
    
    # Salva la risposta in un file temporaneo
    echo "$response" > "$temp_file"
    
    # Pulisci la risposta da eventuali markdown o testo aggiuntivo
    if grep -q "^<?php" "$temp_file"; then
        # Se la risposta inizia con <?php, estrai da lì fino alla fine
        sed -n '/^<?php/,$p' "$temp_file" > "${temp_file}.clean"
    elif grep -q "^return \[" "$temp_file"; then
        # Se la risposta inizia con return [, aggiungi <?php e estrai
        (echo "<?php"; echo ""; grep -A 1000000 "^return \[" "$temp_file") > "${temp_file}.clean"
    elif grep -q '```php' "$temp_file"; then
        # Se c'è un blocco di codice PHP in markdown, estrai solo quel blocco
        sed -n '/```php/,/```/p' "$temp_file" | sed '1d;$d' > "${temp_file}.clean"
    elif grep -q '```' "$temp_file"; then
        # Potrebbe essere un blocco di codice senza specificare php
        sed -n '/```/,/```/p' "$temp_file" | sed '1d;$d' > "${temp_file}.clean"
    else
        # Altrimenti, conserva l'output così com'è ma aggiungi <?php se non presente
        if ! grep -q "<?php" "$temp_file"; then
            (echo "<?php"; echo ""; cat "$temp_file") > "${temp_file}.clean"
        else
            cat "$temp_file" > "${temp_file}.clean"
        fi
    fi
    
    # Verifica che il file risultante sia valido
    if [ ! -s "${temp_file}.clean" ]; then
        echo "Errore: il file corretto risulta vuoto. Controlla la risposta dell'API."
        cat "$temp_file" # Mostra la risposta originale per debug
        exit 1
    fi
    
    # Sovrascrive il file originale con la versione corretta
    mv "${temp_file}.clean" "$file"
    
    echo "Codice corretto con successo. Il file originale è stato salvato come ${file}.backup"
}

# Funzione principale
main() {
    if [ $# -ne 1 ]; then
        echo "Uso: $0 <file_php>"
        exit 1
    fi
    
    local file="$1"
    if [ ! -f "$file" ]; then
        echo "Errore: il file $file non esiste."
        exit 1
    fi
    
    check_ollama
    check_model
    fix_php_code "$file"
    echo "Operazione completata. Verifica il file aggiornato."
}

main "$@"