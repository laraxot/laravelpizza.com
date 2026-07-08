# PDF to Markdown OCR Script

Questo script converte un file PDF in un file Markdown (.md) utilizzando OCR.

## Requisiti
- Python 3.8+
- [PyMuPDF (fitz)](https://pymupdf.readthedocs.io/)
- [pytesseract](https://pypi.org/project/pytesseract/)
- [Pillow](https://pillow.readthedocs.io/)
- [Tesseract OCR](https://github.com/tesseract-ocr/tesseract) installato sul sistema
- Ambiente virtuale Python (consigliato)

### Installazione dipendenze Python
```bash
pip install pymupdf pytesseract pillow
```

### Installazione Tesseract (Linux Ubuntu)
```bash
sudo apt update && sudo apt install tesseract-ocr tesseract-ocr-ita tesseract-ocr-eng
```

### Installazione Ambiente Virtuale (Linux Ubuntu)
```bash
sudo apt update
sudo apt install -y python3-full python3-venv tesseract-ocr poppler-utils
```

Crea e attiva un ambiente virtuale, poi installa i pacchetti richiesti:
```bash
python3 -m venv /path/to/venv
/path/to/venv/bin/pip install pdf2image Pillow pytesseract markdownify
```

### Installazione su Altri Sistemi
- Per macOS: Usa `brew install tesseract poppler` e pip per i pacchetti Python all'interno di un ambiente virtuale.
- Per Windows: Installa Tesseract OCR da [GitHub](https://github.com/UB-Mannheim/tesseract/wiki), Poppler via conda o installazione manuale, e i pacchetti Python via pip in un ambiente virtuale.

## Utilizzo

Lo script `pdf_to_md_ocr.py` può essere eseguito dalla riga di comando con la seguente sintassi, assicurandoti di utilizzare l'interprete Python dal tuo ambiente virtuale:

```bash
/path/to/venv/bin/python pdf_to_md_ocr.py input.pdf [output.md]
```
- `input.pdf`: il file PDF da convertire
- `output.md`: (opzionale) nome del file Markdown di output. Se omesso, verrà usato lo stesso nome del PDF con estensione `.md`.

## Note
- Lo script esegue OCR su ogni pagina del PDF (anche se il PDF contiene solo testo, verrà trattato come immagine).
- La qualità del Markdown dipende dalla qualità del PDF e dalla lingua impostata in Tesseract (`ita+eng` di default).
- Ogni pagina viene separata da un header Markdown `# Pagina N` e un separatore `---`.

## Esempio
```bash
python3 pdf_to_md_ocr.py documento.pdf

# Output: documento.md
```

## Troubleshooting
- Se ottieni solo testo vuoto, verifica che Tesseract sia installato e funzionante (`tesseract --version`).
- Per PDF molto grandi, la conversione può richiedere tempo e molta RAM.
- Puoi cambiare la lingua OCR modificando la riga `lang="ita+eng"` nello script.

## Link utili
- [PyMuPDF](https://pymupdf.readthedocs.io/)
- [pytesseract](https://pypi.org/project/pytesseract/)
- [Tesseract OCR](https://github.com/tesseract-ocr/tesseract)

## Descrizione
Script Python avanzato per convertire file PDF in formato Markdown (.md) utilizzando OCR (pytesseract + pdf2image). Ideale per PDF scannerizzati, documenti con testo non selezionabile o per estrarre testo mantenendo la formattazione di base.

## Caratteristiche
- Supporto per PDF multi-pagina
- Riconoscimento ottico dei caratteri (OCR) multilingua
- Conversione ad alta risoluzione (DPI personalizzabile)
- Preservazione della struttura del documento
- Facile integrazione in workflow automatizzati

## Requisiti di Sistema
- Python 3.8+
- Tesseract OCR installato sul sistema
- Poppler (per la conversione PDF -> immagine)

### Dipendenze Python
- [pytesseract](https://pypi.org/project/pytesseract/)
- [pdf2image](https://pypi.org/project/pdf2image/)
- [Pillow](https://pypi.org/project/Pillow/)

### Installazione dipendenze

**Su Ubuntu/Debian:**
```bash

# Installazione Tesseract e Poppler
sudo apt update
sudo apt install tesseract-ocr tesseract-ocr-ita poppler-utils

# Installazione pacchetti Python
pip install pytesseract pdf2image Pillow
```

**Su macOS (con Homebrew):**
```bash

# Installazione Tesseract e Poppler
brew install tesseract tesseract-lang
brew install poppler

# Installazione pacchetti Python
pip install pytesseract pdf2image Pillow
```

**Su Windows:**
1. Scarica e installa Tesseract OCR da [qui](https://github.com/UB-Mannheim/tesseract/wiki)
2. Installa Poppler da [qui](https://github.com/oschwartz10612/poppler-windows/releases/)
3. Aggiungi le cartelle di installazione al PATH di sistema
4. Installa i pacchetti Python:
   ```
   pip install pytesseract pdf2image Pillow
   ```

## Utilizzo

### Sintassi di base:
```bash
python3 pdf_to_markdown.py <file.pdf> [opzioni]
```

### Opzioni:
- `-o, --output`: Specifica il percorso del file Markdown di output (predefinito: stesso nome del file di input con estensione .md)
- `-l, --lang`: Lingua per l'OCR (predefinito: 'ita' per italiano)
- `--dpi`: Risoluzione per la conversione in immagine (predefinito: 300, valori più alti migliorano la qualità ma rallentano la conversione)

### Esempi:

1. **Conversione base** (usa impostazioni predefinite):
   ```bash
   python3 pdf_to_markdown.py documento.pdf
   ```

2. **Specificare il file di output**:
   ```bash
   python3 pdf_to_markdown.py input.pdf -o output.md
   ```

3. **Impostare la lingua** (es. inglese):
   ```bash
   python3 pdf_to_markdown.py documento.pdf -l eng
   ```

4. **Migliorare la qualità** (aumentando il DPI):
   ```bash
   python3 pdf_to_markdown.py documento_scansionato.pdf --dpi 400
   ```

5. **Elaborazione batch** (tutti i PDF nella cartella):
   ```bash
   for pdf in *.pdf; do
       python3 pdf_to_markdown.py "$pdf" -o "${pdf%.*}.md"
   done
   ```

## Note e Consigli

### Qualità dell'OCR
- Per risultati migliori, utilizza PDF con risoluzione almeno 300 DPI
- Documenti con font chiari su sfondo bianco forniscono i migliori risultati
- Per documenti con layout complessi, potresti dover rielaborare manualmente il Markdown generato

### Prestazioni
- La conversione può richiedere diversi secondi per pagina, a seconda della dimensione e della complessità
- Per documenti molto grandi, considera l'utilizzo di un DPI inferiore (es. 200)
- L'utilizzo di più lingue contemporaneamente (es. `ita+eng`) può ridurre la velocità di elaborazione

### Supporto Lingue
Per verificare le lingue disponibili sul tuo sistema:
```bash
tesseract --list-langs
```

Per installare lingue aggiuntive:
- **Ubuntu/Debian**: `sudo apt install tesseract-ocr-[codice_lingua]`
- **macOS**: `brew install tesseract-lang/[codice_lingua]`
- **Windows**: Riavvia il programma di installazione di Tesseract e seleziona le lingue aggiuntive

## Risoluzione dei Problemi

### Tesseract non trovato
Se ricevi un errore come `pytesseract.pytesseract.TesseractNotFoundError`, specifica manualmente il percorso di Tesseract:

1. Trova il percorso di Tesseract:
   ```bash
   which tesseract
   # O su Windows:
   # where tesseract
   ```

2. Modifica lo script per includere il percorso:
   ```python
   # Aggiungi all'inizio dello script, dopo gli import
   pytesseract.pytesseract.tesseract_cmd = '/percorso/completo/a/tesseract'  # Sostituisci con il percorso corretto
   ```

### Problemi con Poppler
Se ricevi errori relativi a `pdftocairo` o `pdfinfo`, assicurati che Poppler sia installato correttamente e nel PATH.

### Qualità di riconoscimento scadente
Prova a:
1. Aumentare il DPI (es. `--dpi 400`)
2. Specificare la lingua corretta
3. Pre-elaborare il PDF con uno strumento di pulizia delle immagini
4. Per documenti con colonne, considera l'utilizzo di `--psm` (page segmentation mode) di Tesseract

## Limitazioni
- La formattazione complessa potrebbe non essere preservata perfettamente
- Le tabelle vengono convertite in testo semplice
- L'ordine del testo potrebbe essere alterato in documenti con layout complessi
- Le immagini e i grafici non vengono estratti

## Risorse Utili
- [Documentazione Tesseract](https://tesseract-ocr.github.io/tessdoc/)
- [Guida ai parametri Tesseract](https://github.com/tesseract-ocr/tesseract/blob/master/doc/tesseract.1.asc)
- [pdf2image documentazione](https://pdf2image.readthedocs.io/)

## Licenza
Questo script è rilasciato sotto licenza MIT. Sentiti libero di modificarlo e distribuirlo secondo i tuoi bisogni.

## Contributi
I contributi sono ben accetti! Apri una issue o una pull request per suggerire miglioramenti o segnalare bug.
