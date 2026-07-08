#!/bin/bash

# Attiva l'ambiente virtuale
source venv/bin/activate

# Esegui lo script di miglioramento
python enhance_markdown_safely.py test.md test_enhanced.md

# Mostra un'anteprima del file migliorato
echo -e "\n=== Anteprima del file migliorato ===\n"
head -n 30 test_enhanced.md

echo -e "\nFile migliorato salvato come: test_enhanced.md"
echo "Il file originale (test.md) non è stato modificato."
