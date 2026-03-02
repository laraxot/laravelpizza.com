#!/bin/bash
# fix-naming-conventions.sh
# Corregge naming conventions nei file docs (underscore → dash)

set -e

MODULE_PATH="../../.."
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo -e "${YELLOW}🔍 Correggendo naming conventions...${NC}"

FIXES=0

# Converti underscore in dash (escluso _archive, _docs, _scripts)
find "$MODULE_PATH"/*/docs -type f -name "*_*.md" \
    ! -path "*/_archive/*" \
    ! -path "*/_docs/*" \
    ! -path "*/_scripts/*" \
    2>/dev/null | while read file; do
    
    dir=$(dirname "$file")
    base=$(basename "$file")
    new_name=$(echo "$base" | tr '_' '-')
    
    if [ "$base" != "$new_name" ]; then
        echo "  $base → $new_name"
        mv "$dir/$base" "$dir/$new_name"
        FIXES=$((FIXES + 1))
    fi
done

if [ $FIXES -eq 0 ]; then
    echo -e "${GREEN}✅ Nessuna correzione necessaria${NC}"
else
    echo -e "${GREEN}✅ $FIXES file rinominati${NC}"
fi
