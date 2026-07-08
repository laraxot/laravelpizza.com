#!/bin/bash

# Attiva l'ambiente virtuale
source venv/bin/activate

# Installa le dipendenze richieste
pip install pdf2image pytesseract PyPDF2

# Verifica che tesseract sia installato
if ! command -v tesseract &> /dev/null; then
    echo "Errore: Tesseract OCR non è installato."
    echo "Per installarlo:"
    echo "  Ubuntu/Debian: sudo apt install tesseract-ocr tesseract-ocr-eng"
    echo "  macOS: brew install tesseract tesseract-lang"
    exit 1
fi

# Esegui l'analisi
python analyze_pdf.py

# Mostra un'anteprima del report
echo -e "\n=== ANTEPRIMA DEL REPORT ===\n"
head -n 30 test_info2.md

echo -e "\n\nAnalisi completata. Il report completo è disponibile in: test_info2.md"
