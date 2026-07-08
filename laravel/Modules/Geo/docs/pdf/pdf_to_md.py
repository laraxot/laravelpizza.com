#!/usr/bin/env python3

import os
import sys
import argparse
from pdf2image import convert_from_path
from PIL import Image
import pytesseract
import markdownify


def pdf_to_markdown(pdf_path, output_md=None, lang='ita+eng'):
    if not os.path.isfile(pdf_path):
        print(f"File non trovato: {pdf_path}")
        return

    if output_md is None:
        output_md = os.path.splitext(pdf_path)[0] + '.md'

    print(f"Converto {pdf_path} in {output_md} ...")
    pages = convert_from_path(pdf_path)
    md_lines = []
    for i, page in enumerate(pages):
        text = pytesseract.image_to_string(page, lang=lang)
        md_lines.append(f"\n---\n\n# Pagina {i+1}\n\n{text.strip()}\n")

    with open(output_md, 'w', encoding='utf-8') as f:
        f.writelines(md_lines)
    print(f"Conversione completata: {output_md}")


def main():
    if len(sys.argv) < 2:
        print("Uso: python pdf_to_md.py <file.pdf> [output.md] [lang]")
        sys.exit(1)
    pdf_path = sys.argv[1]
    output_md = sys.argv[2] if len(sys.argv) > 2 else None
    lang = sys.argv[3] if len(sys.argv) > 3 else 'ita+eng'
    pdf_to_markdown(pdf_path, output_md, lang)


if __name__ == "__main__":
    main()
