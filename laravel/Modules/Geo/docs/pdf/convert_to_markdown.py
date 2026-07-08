#!/usr/bin/env python3
import os
import re
import pytesseract
import fitz  # PyMuPDF
from pdf2image import convert_from_path
from pathlib import Path
from datetime import datetime
from PIL import Image
import io

# Configurazione
PDF_PATH = '/var/www/html/<nome progetto>/bashscripts/pdf/test.pdf'
OUTPUT_MD = '/var/www/html/<nome progetto>/bashscripts/pdf/test_v2.md'
TEMP_DIR = '/tmp/pdf_conversion'
IMAGE_DIR = os.path.join(TEMP_DIR, 'images')

# Crea le directory necessarie
os.makedirs(TEMP_DIR, exist_ok=True)
os.makedirs(IMAGE_DIR, exist_ok=True)

# Configurazione per il riconoscimento del testo
pytesseract.pytesseract.tesseract_cmd = '/usr/bin/tesseract'

def extract_pdf_metadata(pdf_path):
    """Estrai i metadati dal PDF"""
    with fitz.open(pdf_path) as doc:
        metadata = doc.metadata
        return {
            'title': metadata.get('title', 'Senza titolo'),
            'author': metadata.get('author', 'Autore sconosciuto'),
            'creation_date': metadata.get('creationDate', ''),
            'modification_date': metadata.get('modDate', ''),
            'pages': doc.page_count
        }

def clean_text(text):
    """Pulisci e formatta il testo estratto"""
    # Rimuovi spazi multipli
    text = re.sub(r'\s+', ' ', text)
    # Correggi le interruzioni di riga nel mezzo delle parole
    text = re.sub(r'(?<=\w)-\s+\n\s*(?=\w)', '', text)
    # Rimuovi spazi multipli all'inizio/fine riga
    text = re.sub(r'^\s+|\s+$', '', text, flags=re.MULTILINE)
    return text

def detect_heading(text):
    """Riconosci i titoli e formattali in Markdown"""
    # Riconosci titoli in maiuscolo
    if text.isupper() and len(text) < 100 and not text.isdigit():
        return f"## {text}\n\n"
    return f"{text}\n\n"

def process_code_blocks(text):
    """Riconosci e formatta i blocchi di codice"""
    # Semplice rilevamento di blocchi di codice
    lines = text.split('\n')
    in_code_block = False
    result = []

    for line in lines:
        if line.strip().startswith('<?php') or line.strip().startswith('namespace'):
            if not in_code_block:
                result.append('```php')
                in_code_block = True

        if in_code_block:
            result.append(line)
            if line.strip() == '}' or line.strip() == '});':
                result.append('```\n')
                in_code_block = False
        else:
            result.append(line)

    return '\n'.join(result)

def process_page(page, page_num, total_pages):
    """Elabora una singola pagina con OCR e analisi del layout"""
    print(f"  📄 Elaborazione pagina {page_num}/{total_pages}", end='\r')

    # Estrai il testo con OCR
    text = page.get_text()

    # Se il testo è vuoto o troppo corto, prova con OCR
    if len(text.strip()) < 50:
        # Converti la pagina in immagine
        pix = page.get_pixmap()
        img = Image.frombytes("RGB", [pix.width, pix.height], pix.samples)

        # Salva l'immagine temporaneamente
        img_path = os.path.join(IMAGE_DIR, f'page_{page_num:04d}.png')
        img.save(img_path, 'PNG')

        # Esegui OCR sull'immagine
        text = pytesseract.image_to_string(img, lang='eng')

    # Pulisci e formatta il testo
    text = clean_text(text)

    # Elabora il testo per il markdown
    lines = text.split('\n')
    processed_lines = []

    for i, line in enumerate(lines):
        line = line.strip()
        if not line:
            continue

        # Riconosci i titoli
        if i == 0 and page_num == 1:
            processed_lines.append(f"# {line}")
        elif line.isupper() and len(line) < 100 and not line.isdigit():
            processed_lines.append(f"## {line}")
        else:
            processed_lines.append(line)

    return '\n'.join(processed_lines) + '\n\n'

def create_table_of_contents(content):
    """Crea un indice automatico dal contenuto"""
    toc = []
    lines = content.split('\n')

    for line in lines:
        if line.startswith('## '):
            title = line[3:].strip()
            anchor = re.sub(r'[^\w\- ]+', '', title).lower().replace(' ', '-')
            toc.append(f"- [{title}](#{anchor})")

    if toc:
        return "## Indice\n\n" + "\n".join(toc) + "\n\n"
    return ""

def convert_pdf_to_markdown():
    """Converte il PDF in Markdown con formattazione avanzata"""
    print("🔍 Avvio conversione PDF in Markdown avanzata...")

    try:
        # Estrai i metadati
        print("📋 Estrazione metadati...")
        metadata = extract_pdf_metadata(PDF_PATH)

        # Apri il documento PDF
        print(f"📄 Analisi di {metadata['pages']} pagine...")
        doc = fitz.open(PDF_PATH)

        # Elabora ogni pagina
        print("📝 Elaborazione contenuto...")
        all_text = []

        for page_num in range(len(doc)):
            page = doc.load_page(page_num)
            page_text = process_page(page, page_num + 1, len(doc))
            all_text.append(page_text)

        # Unisci tutto il testo
        full_text = '\n'.join(all_text)

        # Crea l'indice
        print("📑 Creazione indice...")
        toc = create_table_of_contents(full_text)

        # Formatta il documento finale
        print("📊 Generazione documento Markdown...")
        now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        total_pages = len(doc)

        markdown = f"""# {metadata['title']}

*Autore: {metadata.get('author', 'Autore sconosciuto')}*
*Generato automaticamente il {now}*
*Pagine: {total_pages}*

---

{toc}

{full_text}

---

*Documento convertito da PDF a Markdown con formattazione avanzata*
*Data di conversione: {now}*
"""

        # Salva il file Markdown
        with open(OUTPUT_MD, 'w', encoding='utf-8') as f:
            f.write(markdown)

        # Salva il numero di pagine prima di chiudere il documento
        page_count = len(doc)
        doc.close()

        print(f"\n✅ Conversione completata con successo!")
        print(f"   File salvato in: {OUTPUT_MD}")
        print(f"   Pagine elaborate: {page_count}")

        # Mostra un'anteprima del file generato
        print("\n📝 Anteprima del file generato:")
        with open(OUTPUT_MD, 'r', encoding='utf-8') as f:
            print(''.join(f.readlines()[:30]))

        return True

    except fitz.FileDataError as e:
        print(f"\n❌ Errore nel file PDF: {str(e)}")
    except ImportError as e:
        if "No module named 'fitz'" in str(e):
            print("\n⚠️  Modulo PyMuPDF non trovato. Installa con:")
            print("   pip install PyMuPDF")
        else:
            print(f"\n❌ Errore di importazione: {str(e)}")
    except Exception as e:
        print(f"\n❌ Errore durante la conversione: {str(e)}")
        import traceback
        traceback.print_exc()

    # Assicurati che il documento sia chiuso in caso di errore
    if 'doc' in locals() and doc is not None:
        try:
            doc.close()
        except:
            pass

    return False

if __name__ == "__main__":
    convert_pdf_to_markdown()
