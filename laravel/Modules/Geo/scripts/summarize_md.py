#!/usr/bin/env python3
"""Produce a lightweight summary for large markdown files.
Usage: summarize_md.py <input.md> <output_dir>
Writes <output_dir>/summary-<basename>.md with title, first 20 lines, and headings list.
"""
import sys
from pathlib import Path

if len(sys.argv) < 3:
    print("Usage: summarize_md.py <input.md> <output_dir>")
    sys.exit(2)

p = Path(sys.argv[1])
outdir = Path(sys.argv[2])
outdir.mkdir(parents=True, exist_ok=True)

text = p.read_text(errors='ignore')
lines = text.splitlines()
summary_lines = lines[:60]
headings = [l.strip() for l in lines if l.startswith('#')][:50]

out = []
out.append('---')
out.append(f'title: "Summary: {p.name}"')
out.append('source: summarizer')
out.append('---\n')
out.append('## Summary (first lines)\n')
out.extend(summary_lines)
out.append('\n## Headings\n')
for h in headings:
    out.append('- ' + h)

outpath = outdir / f'summary-{p.name}'
outpath.write_text('\n'.join(out), encoding='utf-8')
print(f'[summarize_md] wrote {outpath}')
