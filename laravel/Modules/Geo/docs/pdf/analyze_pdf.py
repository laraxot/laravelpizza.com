#!/usr/bin/env python3
import os
import re
import pytesseract
from pdf2image import convert_from_path
from pathlib import Path
from datetime import datetime
import json

# Configurazione
PDF_PATH = '/var/www/html/<nome progetto>/bashscripts/pdf/test.pdf'
OUTPUT_MD = '/var/www/html/<nome progetto>/bashscripts/pdf/test_info2.md'
TEMP_DIR = '/tmp/pdf_analysis'

# Crea la directory temporanea se non esiste
os.makedirs(TEMP_DIR, exist_ok=True)

def get_pdf_info(pdf_path):
    """Estrae informazioni di base sul PDF"""
    from PyPDF2 import PdfReader
    
    with open(pdf_path, 'rb') as f:
        pdf = PdfReader(f)
        
        info = {
            'pages': len(pdf.pages),
            'encrypted': pdf.is_encrypted,
            'metadata': pdf.metadata or {}
        }
    
    return info

def extract_text_with_ocr(pdf_path, first_n_pages=5):
    """Estrae il testo usando OCR"""
    print(f"Convertendo le prime {first_n_pages} pagine in immagini...")
    images = convert_from_path(pdf_path, first_page=1, last_page=first_n_pages)
    
    print("Eseguendo OCR sulle immagini...")
    all_text = ""
    
    for i, image in enumerate(images, 1):
        print(f"  - Elaborazione pagina {i}...")
        text = pytesseract.image_to_string(image, lang='eng')
        all_text += f"\n\n--- Page {i} ---\n\n{text}"
    
    return all_text

def analyze_content(text):
    """Analizza il contenuto estratto per identificare la struttura"""
    # Conta le occorrenze di parole chiave
    keywords = {
        'chapter': len(re.findall(r'\bchapter\b', text, re.IGNORECASE)),
        'figure': len(re.findall(r'\bfigure\b', text, re.IGNORECASE)),
        'table': len(re.findall(r'\btable\b', text, re.IGNORECASE)),
        'reference': len(re.findall(r'\breference\b', text, re.IGNORECASE)),
    }
    
    # Estrai titoli (linee che sembrano titoli)
    titles = re.findall(r'^([A-Z][A-Za-z0-9 \-\–\(\):]+)$', text, re.MULTILINE)
    
    # Estrai codice (se presente)
    code_blocks = re.findall(r'```(.*?)```', text, re.DOTALL)
    
    return {
        'keywords': keywords,
        'titles': [t.strip() for t in titles if len(t.strip()) > 10],  # Solo titoli lunghi
        'has_code': len(code_blocks) > 0,
        'code_blocks_count': len(code_blocks),
        'estimated_word_count': len(text.split())
    }

def generate_markdown_report(pdf_info, content_analysis, sample_text):
    """Genera un report in formato Markdown"""
    now = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    
    # Prepara i dati per il report
    doc_info = {
        'file_path': PDF_PATH,
        'analysis_date': now,
        'total_pages': pdf_info['pages'],
        'is_encrypted': 'Sì' if pdf_info['encrypted'] else 'No',
        'metadata': json.dumps(dict(pdf_info['metadata']), indent=2) if pdf_info['metadata'] else 'Nessun metadato disponibile',
        'word_count': f"{content_analysis['estimated_word_count']:,}",
        'chapters': content_analysis['keywords']['chapter'],
        'figures': content_analysis['keywords']['figure'],
        'tables': content_analysis['keywords']['table'],
        'code_blocks': content_analysis['code_blocks_count'],
        'structure': '\n'.join(f'- {t}' for t in content_analysis['titles'][:20]),
        'sample_text': '\n'.join(sample_text.split('\n')[:30]),
        'pages_analyzed': 5
    }
    
    # Genera il report
    report = f"""# 📄 Analisi del PDF

## 📋 Informazioni sul Documento
- **Percorso file**: `{doc_info['file_path']}`
- **Data analisi**: {doc_info['analysis_date']}
- **Pagine totali**: {doc_info['total_pages']}
- **Protetto da password**: {doc_info['is_encrypted']}

## 📊 Metadati del Documento
```json
{doc_info['metadata']}
```

## 🔍 Analisi del Contenuto
- **Parole stimate**: ~{doc_info['word_count']}
- **Capitoli rilevati**: {doc_info['chapters']}
- **Figure rilevate**: {doc_info['figures']}
- **Tabelle rilevate**: {doc_info['tables']}
- **Blocchi di codice**: {doc_info['code_blocks']}

## 📑 Struttura Rilevata
{doc_info['structure']}

## 📝 Testo Estratto (anteprima)
```
{doc_info['sample_text']}
```

## 📝 Note sull'Analisi
- Questa analisi si basa su OCR e potrebbe contenere imprecisioni
- Sono state analizzate solo le prime {doc_info['pages_analyzed']} pagine su {doc_info['total_pages']}
- Per un'analisi completa, elabora tutte le pagine con l'opzione appropriata
"""
    
    return report

def main():
    print(f"Analisi del PDF: {PDF_PATH}")
    
    # Estrai informazioni di base
    print("\n1. Estrazione informazioni di base...")
    pdf_info = get_pdf_info(PDF_PATH)
    
    # Estrai testo con OCR
    print("\n2. Estrazione testo con OCR...")
    extracted_text = extract_text_with_ocr(PDF_PATH)
    
    # Analizza il contenuto
    print("\n3. Analisi del contenuto...")
    analysis = analyze_content(extracted_text)
    
    # Genera il report
    print("\n4. Generazione del report...")
    report = generate_markdown_report(pdf_info, analysis, extracted_text)
    
    # Salva il report
    with open(OUTPUT_MD, 'w', encoding='utf-8') as f:
        f.write(report)
    
    print(f"\n✅ Analisi completata con successo!")
    print(f"   Report salvato in: {OUTPUT_MD}")
    print(f"   Pagine analizzate: 5/{pdf_info['pages']}")
    print("\nPer un'analisi completa, esegui nuovamente lo script specificando più pagine.")

if __name__ == "__main__":
    try:
        main()
    except Exception as e:
        print(f"\n❌ Errore durante l'analisi: {str(e)}")
        if "tesseract is not installed" in str(e).lower():
            print("\n⚠️  Installa Tesseract OCR:")
            print("   Ubuntu/Debian: sudo apt install tesseract-ocr tesseract-ocr-ita")
            print("   macOS: brew install tesseract tesseract-lang")
        raise
