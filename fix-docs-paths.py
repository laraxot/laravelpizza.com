#!/usr/bin/env python3
"""Fix over-nested docs paths in module/theme markdown files."""
import re
from pathlib import Path

ROOT = Path("/var/www/_bases/base_laravelpizza")
LARAVEL = ROOT / "laravel"

def correct_depth(filepath: Path) -> int:
    """From laravel/Modules/X/docs/... or laravel/Themes/X/docs/..., return levels to root."""
    rel = filepath.relative_to(LARAVEL)
    parts = rel.parts
    # laravel/Modules/X/docs or laravel/Modules/X/docs/subdir
    # parts: ('Modules','X','docs') or ('Modules','X','docs','subdir')
    if "Modules" in parts or "Themes" in parts:
        # Find docs index
        try:
            docs_idx = parts.index("docs")
            # From file to docs: len(parts) - docs_idx - 1 (for file) - 1 (for docs dir)
            # From docs to root: Modules, laravel = 2 + 1 = 3? No.
            # From laravel/Modules/X/docs/file.md: we need to go up to root
            # file.md is in docs/, so: .. = X, ../.. = Modules, ../../.. = laravel, ../../../.. = root
            # So 4 levels for files in docs/
            # For docs/subdir: 5 levels. For docs/sub/sub: 6 levels.
            depth_under_docs = len(parts) - docs_idx - 2  # -2 for 'docs' and filename
            return 4 + max(0, depth_under_docs)
        except ValueError:
            return 4
    return 4

def fix_file(filepath: Path) -> bool:
    depth = correct_depth(filepath)
    correct_prefix = "../" * depth
    content = filepath.read_text(encoding="utf-8", errors="replace")
    # Match any ../../../../.../docs (4 or more levels) that's wrong
    pattern = re.compile(r'(\.\./){5,}docs')
    matches = pattern.findall(content)
    if not matches:
        return False
    # Replace with correct depth
    def repl(m):
        return correct_prefix + "docs"
    new_content = pattern.sub(repl, content)
    if new_content != content:
        filepath.write_text(new_content, encoding="utf-8")
        return True
    return False

def main():
    count = 0
    for md in LARAVEL.glob("Modules/**/docs/**/*.md"):
        if fix_file(md):
            count += 1
            print(f"Fixed: {md.relative_to(ROOT)}")
    for md in LARAVEL.glob("Themes/**/docs/**/*.md"):
        if fix_file(md):
            count += 1
            print(f"Fixed: {md.relative_to(ROOT)}")
    print(f"Total fixed: {count}")

if __name__ == "__main__":
    main()
