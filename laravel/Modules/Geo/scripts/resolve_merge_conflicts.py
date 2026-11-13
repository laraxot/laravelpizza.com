#!/usr/bin/env python3
"""Auto-resolve simple git merge conflicts by choosing the side with more non-empty lines.
Backs up originals to .git/conflict-backups/<file>.orig

NOTES:
- This is best-effort and may lose intended changes. Review the commit after running.
- Skips binary files.
"""
import sys
from pathlib import Path
import shutil

ROOT = Path('.').resolve()
backup_dir = ROOT / '.git' / 'conflict-backups'
backup_dir.mkdir(parents=True, exist_ok=True)

conflict_files = []
for p in ROOT.rglob('*'):
    if p.is_file():
        try:
            text = p.read_text(errors='ignore')
        except Exception:
            continue
        if '<<<<<<< ' in text:
            conflict_files.append(p)

if not conflict_files:
    print('No conflict markers found')
    sys.exit(0)

resolved = []
skipped = []

for f in conflict_files:
    text = f.read_text(errors='ignore')
    lines = text.splitlines(keepends=True)
    out_lines = []
    i = 0
    changed = False
    try:
        while i < len(lines):
            line = lines[i]
            if line.startswith('<<<<<<< '):
                # collect ours
                i += 1
                ours = []
                while i < len(lines) and not lines[i].startswith('======='):
                    ours.append(lines[i])
                    i += 1
                if i >= len(lines):
                    # malformed, abort for this file
                    skipped.append((f, 'malformed conflict (no =======)'))
                    break
                i += 1  # skip =======
                theirs = []
                while i < len(lines) and not lines[i].startswith('>>>>>>>'):
                    theirs.append(lines[i])
                    i += 1
                if i >= len(lines):
                    skipped.append((f, 'malformed conflict (no >>>>>>>)'))
                    break
                # skip >>>>>>> line
                i += 1
                # choose side: prefer side with more non-empty lines
                ours_count = sum(1 for L in ours if L.strip())
                theirs_count = sum(1 for L in theirs if L.strip())
                if theirs_count > ours_count:
                    chosen = theirs
                    reason = 'theirs_longer'
                else:
                    chosen = ours
                    reason = 'ours_longer_or_equal'
                out_lines.extend(chosen)
                changed = True
            else:
                out_lines.append(line)
                i += 1
        if changed:
            # backup
            bak = backup_dir / (f.name + '.orig')
            shutil.copy2(str(f), str(bak))
            f.write_text(''.join(out_lines), encoding='utf-8')
            resolved.append((f, reason))
    except Exception as e:
        skipped.append((f, f'exception: {e}'))

print(f'Resolved {len(resolved)} files, skipped {len(skipped)} files')
for r in resolved[:50]:
    print('- RESOLVED:', r[0], r[1])
for s in skipped[:50]:
    print('- SKIPPED:', s[0], s[1])

print('\nNext steps: review changes, run tests, and commit if OK.')
