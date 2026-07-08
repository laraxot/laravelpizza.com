#!/usr/bin/env python3
"""Scan repository for risky AI calls that may send large context to models.
Checks for: web_fetch without max_length, web_fetch with raw:true, reading large markdown/html files without chunking.
Exit 1 with findings to fail CI or pre-commit.
"""
import re
import sys
from pathlib import Path

ROOT = Path('.').resolve()
IGNORES = {'.git', '.venv', 'node_modules', '.claude'}

issues = []

for p in ROOT.rglob('*'):
    if any(part in IGNORES for part in p.parts):
        continue
    if p.is_file() and p.suffix in ('.py', '.js', '.ts', '.md', '.json', '.yml', '.yaml'):
        try:
            text = p.read_text(errors='ignore')
        except Exception:
            continue
        # detect web_fetch usages
        if 'web_fetch' in text:
            for match in re.finditer(r"web_fetch\s*\(", text):
                idx = match.start()
                window = text[idx: idx+2000]
                has_max = 'max_length' in window
                has_raw_true = re.search(r"raw\s*:\s*true", window)
                if has_raw_true:
                    issues.append((str(p), 'web_fetch raw:true found (avoid raw:true)'))
                if not has_max:
                    issues.append((str(p), 'web_fetch call without max_length; add max_length to limit tokens'))
        # check for large md/html files
        if p.suffix in ('.md', '.html'):
            try:
                size = p.stat().st_size
                if size > 50*1024:
                    issues.append((str(p), f'Large file ({size} bytes). Consider chunking or summarizing before sending to AI'))
            except Exception:
                pass

if issues:
    print('\nAI Token Guard found potential issues:')
    for f, msg in sorted(issues):
        print(f'- {f}: {msg}')
    print('\nFixes:')
    print('- For web_fetch calls: always pass max_length and avoid raw:true. Example: web_fetch({url: "..", max_length: 2000})')
    print('- Chunk or summarize large files before including in prompts. Use view_range or ctx_execute_file for partial reads.')
    print('- Add special helpers in scripts/ to preprocess and summarize content before sending to the model.')
    sys.exit(1)
else:
    print('AI Token Guard: no issues found')
    sys.exit(0)
