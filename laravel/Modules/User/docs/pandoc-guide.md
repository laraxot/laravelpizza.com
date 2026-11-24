---
title: Pandoc Documentation Generation Guide
description: How to convert module documentation to multiple formats using Pandoc
---

# Pandoc Documentation Generation

This guide explains how to generate distributable documentation for this module using Pandoc.

## Installation

Pandoc is installed at `~/.local/bin/pandoc`. Verify:

```bash
pandoc --version
# pandoc 3.10.1
# Features: +server +lua
```

## Generate HTML

Convert markdown files to standalone HTML:

```bash
# Single file
pandoc -s -t html docs/README.md -o docs/README.html

# With table of contents
pandoc -s --toc -N -t html docs/README.md -o docs/README.html
```

## Generate PDF

Convert to PDF (requires LaTeX):

```bash
# Basic PDF
pandoc docs/README.md -o docs/README.pdf

# PDF with TOC and numbered sections
pandoc -N --toc docs/README.md -o docs/README.pdf
```

## Batch Generate

Convert all markdown files in this directory:

```bash
#!/bin/bash
for file in *.md; do
  base=$(basename "$file" .md)
  pandoc -s --toc -N "$file" -o "${base}.html"
  pandoc -N --toc "$file" -o "${base}.pdf"
  echo "Generated: ${base}.html ${base}.pdf"
done
```

## Options

| Option | Effect |
|--------|--------|
| `-s` | Standalone output |
| `--toc` | Table of contents |
| `-N` | Number sections |
| `--pdf-engine=pdflatex` | LaTeX engine |

## References

- Installation: docs/wiki/tools/pandoc-installation.md
- Usage guide: docs/wiki/tools/pandoc-usage.md
- Official: https://pandoc.org
