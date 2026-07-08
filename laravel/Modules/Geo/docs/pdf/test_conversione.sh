#!/bin/bash
# Script di test per verificare la conversione PDF -> Markdown

echo "=== Test di conversione PDF -> Markdown ==="
echo "Verifica delle dipendenze..."

# Verifica Python 3
if ! command -v python3 &> /dev/null; then
    echo "Errore: Python 3 non è installato."
    exit 1
fi

# Verifica Tesseract
if ! command -v tesseract &> /dev/null; then
    echo "Attenzione: Tesseract OCR non è installato. È necessario per il riconoscimento del testo."
    echo "Suggerimento: sudo apt install tesseract-ocr tesseract-ocr-ita"
    exit 1
fi

# Verifica Poppler (per pdftoppm)
if ! command -v pdftoppm &> /dev/null; then
    echo "Attenzione: Poppler non è installato. È necessario per la conversione PDF -> immagine."
    echo "Suggerimento: sudo apt install poppler-utils"
    exit 1
fi

# Crea un PDF di test semplice se non esiste
TEST_PDF="test_document.pdf"
TEST_MD="test_document.md"

if [ ! -f "$TEST_PDF" ]; then
    echo "Creazione di un PDF di test..."
    cat > test.tex << 'EOL'
\documentclass{article}
\begin{document}
\title{Documento di Test}
\author{<nome progetto>}
\date{\today}
\maketitle

\section{Introduzione}
Questo è un documento di test per verificare la conversione da PDF a Markdown.

\section{Contenuto}
Il documento contiene del testo formattato, inclusi:\newline
\textbf{Grassetto}, \textit{corsivo}, \underline{sottolineato}.

\section{Elenco}
\begin{itemize}
    \item Primo elemento
    \item Secondo elemento
    \item Terzo elemento
\end{itemize}

\section{Tabella}
\begin{tabular}{|l|c|r|}
\hline
Nome & Età & Città \\
\hline
Mario & 30 & Roma \\
Luigi & 25 & Milano \\
\hline
\end{tabular}

\end{document}
EOL

    # Converti in PDF (se pdflatex è disponibile)
    if command -v pdflatex &> /dev/null; then
        pdflatex -interaction=nonstopmode test.tex > /dev/null
        rm -f test.aux test.log test.tex
        echo "PDF di test creato: $TEST_PDF"
    else
        echo "Attenzione: pdflatex non è installato. Utilizzerò un PDF di esempio se disponibile."
        # Cerca un PDF esistente nella cartella
        if [ -z "$(find . -name '*.pdf' -type f -print -quit)" ]; then
            echo "Errore: nessun PDF trovato per il test."
            exit 1
        fi
        TEST_PDF="$(find . -name '*.pdf' -type f -print -quit | head -1)"
        echo "Utilizzo del file esistente per il test: $TEST_PDF"
    fi
fi

# Installa le dipendenze Python
if [ ! -f "requirements_installed" ]; then
    echo "Installazione delle dipendenze Python..."
    pip3 install -r requirements.txt
    if [ $? -eq 0 ]; then
        touch requirements_installed
    else
        echo "Errore durante l'installazione delle dipendenze."
        exit 1
    fi
fi

# Esegui la conversione
echo "Avvio della conversione di $TEST_PDF..."
./converti_pdf.sh "$TEST_PDF" -o "$TEST_MD" -l ita

# Verifica il risultato
if [ -f "$TEST_MD" ]; then
    echo "\n=== Conversione completata con successo! ==="
    echo "File generato: $TEST_MD"
    echo "\nAnteprima del contenuto (prime 20 righe):"
    echo "----------------------------------------"
    head -n 20 "$TEST_MD" || true
    echo "..."
    echo "----------------------------------------"
    echo "\nPer visualizzare l'intero file: less $TEST_MD"
else
    echo "Errore: la conversione non ha prodotto alcun output."
    exit 1
fi

echo "\n=== Test completato ==="
echo "Per convertire altri file, utilizza: ./converti_pdf.sh file_da_convertire.pdf"
