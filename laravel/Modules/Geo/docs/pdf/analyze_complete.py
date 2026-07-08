#!/usr/bin/env python3
import os
import re
import json
import pytesseract
from pdf2image import convert_from_path
from pathlib import Path
from datetime import datetime
from collections import defaultdict

# Configurazione
PDF_PATH = '/var/www/html/<nome progetto>/bashscripts/pdf/test.pdf'
OUTPUT_MD = '/var/www/html/<nome progetto>/bashscripts/pdf/test_info2.md'
TEMP_DIR = '/tmp/pdf_analysis'

# Crea la directory temporanea
os.makedirs(TEMP_DIR, exist_ok=True)

def get_pdf_metadata(pdf_path):
    """Estrae i metadati del PDF"""
    from PyPDF2 import PdfReader
    
    with open(pdf_path, 'rb') as f:
        pdf = PdfReader(f)
        return {
            'pages': len(pdf.pages),
            'encrypted': pdf.is_encrypted,
            'metadata': dict(pdf.metadata) if pdf.metadata else {}
        }

def extract_text_with_ocr(pdf_path, start_page=1, end_page=None):
    """Estrae il testo usando OCR"""
    print(f"\n🔍 Estrazione testo con OCR (pagine {start_page}-{end_page or 'fine'})...")
    
    # Converti il PDF in immagini
    images = convert_from_path(
        pdf_path,
        first_page=start_page,
        last_page=end_page,
        dpi=300,  # Alta risoluzione per una migliore accuratezza
        thread_count=4
    )
    
    # Elabora ogni immagine con OCR
    all_text = []
    for i, image in enumerate(images, start=start_page):
        print(f"  📄 Pagina {i}/{end_page or '?'}", end='\r')
        text = pytesseract.image_to_string(image, lang='eng')
        all_text.append(f"\n--- Pagina {i} ---\n{text}")
    
    return '\n'.join(all_text)

def analyze_content_structure(text):
    """Analizza la struttura del contenuto"""
    # Estrai titoli (righe con testo in maiuscolo o con formattazione titolo)
    titles = re.findall(r'^([A-Z][A-Z0-9 \-–\(\):]+)$', text, re.MULTILINE)
    
    # Conta le occorrenze di parole chiave
    keywords = {
        'chapter': len(re.findall(r'\bchapter\b', text, re.IGNORECASE)),
        'section': len(re.findall(r'\bsection\b', text, re.IGNORECASE)),
        'figure': len(re.findall(r'\bfigure\b', text, re.IGNORECASE)),
        'table': len(re.findall(r'\btable\b', text, re.IGNORECASE)),
        'code': len(re.findall(r'```|\bcode\b', text, re.IGNORECASE)),
        'example': len(re.findall(r'\bexample\b', text, re.IGNORECASE)),
    }
    
    # Estrai eventuali blocchi di codice
    code_blocks = re.findall(r'```(?:[a-z]*\n)?(.*?)```', text, re.DOTALL)
    
    # Analizza il testo per stime di complessità
    words = text.split()
    unique_words = len(set(words))
    
    return {
        'titles': [t.strip() for t in titles if len(t.strip()) > 5],
        'keywords': keywords,
        'word_count': len(words),
        'unique_words': unique_words,
        'code_blocks': code_blocks,
        'code_blocks_count': len(code_blocks),
        'avg_word_length': sum(len(word) for word in words) / len(words) if words else 0
    }

def generate_markdown_report(metadata, content_analysis, sample_text):
    """Genera un report completo in formato Markdown"""
    now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    
    # Formatta i metadati
    formatted_metadata = '\n'.join(f"- **{k}**: `{v}`" for k, v in metadata.items() if v)
    
    # Analisi delle parole chiave
    keyword_analysis = '\n'.join(
        f"- **{k.capitalize()}**: {v} occorrenze"
        for k, v in content_analysis['keywords'].items()
        if v > 0
    )
    
    # Statistiche sul testo
    stats = f"""
- **Parole totali**: {content_analysis['word_count']:,}
- **Parole uniche**: {content_analysis['unique_words']:,}
- **Lunghezza media parola**: {content_analysis['avg_word_length']:.1f} caratteri
- **Blocchi di codice**: {content_analysis['code_blocks_count']}
"""
    
    # Prepara la struttura del documento
    structure_text = '\n'.join(f'- {t}' for t in content_analysis['titles'][:50]) or 'Nessuna struttura rilevata'
    sample_text_limited = '\n'.join(sample_text.split('\n')[:50])  # Limita a 50 righe
    
    # Genera il report
    report = f"""# 📚 Analisi Completa del Documento

## 📋 Informazioni Generali
- **File analizzato**: `{PDF_PATH}`
- **Data analisi**: {now}
- **Pagine totali**: {metadata['pages']}
- **Protetto da password**: {'Sì' if metadata['encrypted'] else 'No'}

## 📄 Metadati del Documento
{formatted_metadata}

## 📊 Analisi del Contenuto

### Statistiche Testuali
{stats}

### Parole Chiave Rilevate
{keyword_analysis or 'Nessuna parola chiave rilevata'}

## 📑 Struttura del Documento
{structure_text}

## 📝 Anteprima del Testo Estratto
```
{sample_text_limited}
```

## 🔍 Note sull'Analisi
- 📅 Data dell'analisi: {now}
- 🔄 Solo per uso informativo
- 📊 Dettagli tecnici: OCR con Tesseract e analisi testuale

---
*Generato automaticamente con analyze_complete.py*
"""
    
    return report

def main():
    print("🔍 Avvio analisi completa del documento...")
    
    try:
        # Fase 1: Estrai metadati
        print("📄 Estrazione metadati...")
        metadata = get_pdf_metadata(PDF_PATH)
        
        # Fase 2: Estrai testo con OCR (prima e ultima pagina)
        print("📝 Analisi del contenuto...")
        first_pages = extract_text_with_ocr(PDF_PATH, 1, min(10, metadata['pages']))
        last_pages = extract_text_with_ocr(PDF_PATH, max(1, metadata['pages']-5), metadata['pages']) if metadata['pages'] > 10 else ""
        
        # Combina il testo estratto
        full_text = f"{first_pages}\n\n[... document content ...]\n\n{last_pages}"
        
        # Fase 3: Analizza il contenuto
        analysis = analyze_content_structure(full_text)
        
        # Fase 4: Genera il report
        print("\n📊 Generazione del report...")
        report = generate_markdown_report(metadata, analysis, full_text)
        
        # Salva il report
        with open(OUTPUT_MD, 'w', encoding='utf-8') as f:
            f.write(report)
        
        print(f"\n✅ Analisi completata con successo!")
        print(f"   Report salvato in: {OUTPUT_MD}")
        print(f"   Pagine analizzate: {metadata['pages']} (estratte le prime e ultime 5 pagine)")
        
    except Exception as e:
        print(f"\n❌ Errore durante l'analisi: {str(e)}")
        if "tesseract is not installed" in str(e).lower():
            print("\n⚠️  Installa Tesseract OCR:")
            print("   Ubuntu/Debian: sudo apt install tesseract-ocr tesseract-ocr-eng tesseract-ocr-ita")
            print("   macOS: brew install tesseract tesseract-lang")
        raise

if __name__ == "__main__":
    main()
