import os
import re

DOCS_DIR = 'docs'

def clean_filename(filename):
    # Skip special files
    if filename.upper() in ['README.MD', 'CHANGELOG.MD']:
        return filename.upper()

    # Remove date patterns (YYYY_MM_DD, YYYY-MM-DD, etc)
    # Also handles filenames like phpstan_results_20251118_215405.txt
    new_name = re.sub(r'[\d]{4}[-_]?[\d]{2}[-_]?[\d]{2}([-_][\d]{6})?', '', filename)
    
    # Lowercase
    new_name = new_name.lower()
    
    # Remove leading/trailing non-alphanumeric chars (except . for extension)
    new_name = re.sub(r'^[^a-z0-9]+', '', new_name)
    new_name = re.sub(r'[^a-z0-9.]+$', '', new_name)
    
    # Remove multiple underscores or hyphens
    new_name = re.sub(r'[-_]{2,}', '_', new_name)
    
    return new_name if new_name else filename.lower()

def main():
    if not os.path.exists(DOCS_DIR):
        print(f"Directory {DOCS_DIR} not found.")
        return

    print(f"Standardizing {DOCS_DIR}...")
    
    for fname in os.listdir(DOCS_DIR):
        fpath = os.path.join(DOCS_DIR, fname)
        if not os.path.isfile(fpath): continue

        # 1. Handle special cases
        if fname.lower() == 'readme.md' and fname != 'README.md':
            if os.path.exists(os.path.join(DOCS_DIR, 'README.md')):
                print(f"  Deleting {fname} (duplicate of README.md)")
                os.remove(fpath)
            else:
                print(f"  Renaming {fname} -> README.md")
                os.rename(fpath, os.path.join(DOCS_DIR, 'README.md'))
            continue

        if fname.lower() == 'changelog.md' and fname != 'CHANGELOG.md':
            if os.path.exists(os.path.join(DOCS_DIR, 'CHANGELOG.md')):
                print(f"  Deleting {fname} (duplicate of CHANGELOG.md)")
                os.remove(fpath)
            else:
                print(f"  Renaming {fname} -> CHANGELOG.md")
                os.rename(fpath, os.path.join(DOCS_DIR, 'CHANGELOG.md'))
            continue
            
        # 2. Handle LICENSE files
        if fname.upper().startswith('LICENSE'):
            if fname != 'LICENSE.md' and os.path.exists(os.path.join(DOCS_DIR, 'LICENSE.md')):
                print(f"  Deleting {fname} (redundant LICENSE)")
                os.remove(fpath)
            elif fname != 'LICENSE.md':
                print(f"  Renaming {fname} -> LICENSE.md")
                os.rename(fpath, os.path.join(DOCS_DIR, 'LICENSE.md'))
            continue

        # 3. Standardize other files
        clean_name = clean_filename(fname)
        if clean_name != fname:
            new_path = os.path.join(DOCS_DIR, clean_name)
            if os.path.exists(new_path) and new_path != fpath:
                print(f"  Deleting {fname} (Target {clean_name} exists)")
                os.remove(fpath)
            else:
                print(f"  Renaming {fname} -> {clean_name}")
                os.rename(fpath, new_path)

if __name__ == "__main__":
    main()
