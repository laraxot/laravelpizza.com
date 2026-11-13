---
title: Pandoc Documentation Generation Guide
module: Activity
description: How to convert Activity module documentation to multiple formats using Pandoc
---

# Pandoc Documentation Generation — Activity Module

This guide explains how to generate distributable documentation for the Activity module using Pandoc.

## Installation

Pandoc is installed at `~/.local/bin/pandoc`. Verify:

```bash
pandoc --version
# pandoc 3.10.1
# Features: +server +lua
# Scripting engine: Lua 5.4
```

## Documentation Files

Current module documentation:

```
Modules/Activity/docs/
├── pandoc-guide.md (this file)
├── README.md
├── architecture.md
└── ... other markdown files
```

## Generate HTML

Convert markdown files to standalone HTML:

```bash
# Single file
pandoc -s -t html docs/README.md -o docs/README.html

# With table of contents
pandoc -s --toc -N -t html docs/README.md -o docs/README.html

# With CSS styling
pandoc -s -c ../../../docs/assets/style.css -t html docs/README.md -o docs/README.html
```

## Generate PDF

Convert to PDF (requires LaTeX):

```bash
# Basic PDF
pandoc docs/README.md -o docs/README.pdf

# PDF with numbered sections and TOC
pandoc -N --toc docs/README.md -o docs/README.pdf

# With custom fonts/margins
pandoc -V geometry:margin=1in -V fontsize=11pt docs/README.md -o docs/README.pdf
```

## Batch Generate All Formats

Create all formats (HTML + PDF) for all module documentation:

```bash
#!/bin/bash
# From: Modules/Activity/docs/

for file in *.md; do
  base=$(basename "$file" .md)
  
  # HTML version
  pandoc -s --toc -N "$file" -o "${base}.html"
  
  # PDF version  
  pandoc -N --toc "$file" -o "${base}.pdf"
  
  echo "Generated: ${base}.html ${base}.pdf"
done
```

## With Metadata

Add YAML front matter to markdown files:

```markdown
---
title: Activity Module Documentation
author: Marco Sottana
date: 2026-08-05
---

# Introduction

Content...
```

Then conversion includes metadata automatically:

```bash
pandoc -s docs/README.md -o docs/README.html
```

## Standalone HTML (Self-Contained)

Embed all CSS/images in single HTML file:

```bash
pandoc -s --self-contained docs/README.md -o docs/README_standalone.html
```

## Pandoc Defaults File

Create `docs/pandoc-config.yaml`:

```yaml
reader: markdown
writer: html
standalone: true
toc: true
number-sections: true
metadata:
  author: "Marco Sottana"
  module: "Activity"
```

Then convert with defaults:

```bash
pandoc -d docs/pandoc-config.yaml docs/README.md -o docs/README.html
```

## Common Options

| Option | Effect |
|--------|--------|
| `-s` | Standalone output (complete document) |
| `--toc` | Generate table of contents |
| `-N` | Number headings/sections |
| `-c style.css` | Link to external CSS |
| `-V geometry:margin=1in` | Set PDF margins |
| `-V fontsize=11pt` | Set font size |
| `--pdf-engine=pdflatex` | Specify LaTeX engine |
| `--self-contained` | Embed all resources in single HTML |

## Integration with CI/CD

Document generation can be added to CI pipelines:

```bash
# Generate documentation for all modules
for module in Modules/*/; do
  if [ -d "$module/docs" ]; then
    cd "$module/docs"
    for file in *.md; do
      base=$(basename "$file" .md)
      pandoc -s "$file" -o "${base}.html"
    done
    cd - > /dev/null
  fi
done
```

## References

- Pandoc official: https://pandoc.org
- Installation guide: docs/wiki/tools/pandoc-installation.md
- Usage guide: docs/wiki/tools/pandoc-usage.md
- Module docs home: Modules/Activity/docs/
