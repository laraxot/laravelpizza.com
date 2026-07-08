#!/usr/bin/env python3
"""
PDF to Markdown Converter with OCR

This script converts PDF files to Markdown format using OCR (Optical Character Recognition).
It's particularly useful for scanned PDFs or PDFs with non-selectable text.
"""

import os
import sys
import argparse
import tempfile
import pytesseract
from pdf2image import convert_from_path
from pathlib import Path

# Check if Tesseract OCR is installed
if not os.path.exists('/usr/bin/tesseract'):
    print("Error: Tesseract OCR is not installed. Please install it first.")
    print("On Ubuntu/Debian: sudo apt install tesseract-ocr tesseract-ocr-ita")
    print("On macOS: brew install tesseract tesseract-lang")
    sys.exit(1)

def convert_pdf_to_markdown(pdf_path, output_path=None, lang='ita', dpi=300):
    """
    Convert a PDF file to Markdown using OCR.
    
    Args:
        pdf_path (str): Path to the input PDF file
        output_path (str, optional): Path to save the output Markdown file.
                                   If not provided, uses the same name as input with .md extension
        lang (str): Language code for OCR (default: 'ita' for Italian)
        dpi (int): DPI for image conversion (higher = better quality but slower)
    
    Returns:
        str: Path to the generated Markdown file
    """
    # Set output path if not provided
    if not output_path:
        output_path = os.path.splitext(pdf_path)[0] + '.md'
    
    # Create a temporary directory to store images
    with tempfile.TemporaryDirectory() as temp_dir:
        print(f"Converting PDF to images (this may take a while)...")
        
        try:
            # Convert PDF to images
            images = convert_from_path(pdf_path, dpi=dpi, output_folder=temp_dir)
            print(f"Processed {len(images)} pages")
            
            # Process each page with OCR
            with open(output_path, 'w', encoding='utf-8') as md_file:
                for i, image in enumerate(images, 1):
                    print(f"Processing page {i}/{len(images)}...")
                    
                    # Perform OCR on the image
                    text = pytesseract.image_to_string(image, lang=lang)
                    
                    # Add page separator and text to markdown
                    md_file.write(f"## Page {i}\n\n")
                    md_file.write(text)
                    md_file.write("\n\n---\n\n")
            
            print(f"\nSuccessfully converted to Markdown: {output_path}")
            return output_path
            
        except Exception as e:
            print(f"Error during conversion: {str(e)}", file=sys.stderr)
            if os.path.exists(output_path):
                os.remove(output_path)
            sys.exit(1)

def main():
    parser = argparse.ArgumentParser(description='Convert PDF to Markdown using OCR')
    parser.add_argument('input_pdf', help='Path to the input PDF file')
    parser.add_argument('-o', '--output', help='Output Markdown file path (optional)')
    parser.add_argument('-l', '--lang', default='ita', 
                       help='Language code for OCR (default: ita for Italian)')
    parser.add_argument('--dpi', type=int, default=300, 
                       help='DPI for image conversion (default: 300)')
    
    args = parser.parse_args()
    
    # Check if input file exists
    if not os.path.isfile(args.input_pdf):
        print(f"Error: Input file '{args.input_pdf}' not found.", file=sys.stderr)
        sys.exit(1)
    
    # Convert PDF to Markdown
    convert_pdf_to_markdown(
        pdf_path=args.input_pdf,
        output_path=args.output,
        lang=args.lang,
        dpi=args.dpi
    )

if __name__ == '__main__':
    main()
