#!/bin/bash
# docs-health-check.sh
# Verifica la salute della documentazione dei moduli

set -e

MODULE_PATH="../../.."
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}📊 Docs Health Check${NC}"
echo "===================="
echo ""

# File vuoti
EMPTY=$(find "$MODULE_PATH"/*/docs -type f -size 0 -name "*.md" 2>/dev/null | wc -l)
if [ "$EMPTY" -eq 0 ]; then
    echo -e "${GREEN}✅ File vuoti: $EMPTY${NC}"
else
    echo -e "${RED}❌ File vuoti: $EMPTY${NC}"
fi

# Naming violations (underscore)
UNDERSCORES=$(find "$MODULE_PATH"/*/docs -name "*_*.md" \
    ! -path "*/_archive/*" \
    ! -path "*/_docs/*" \
    ! -path "*/_scripts/*" \
    2>/dev/null | wc -l)
if [ "$UNDERSCORES" -eq 0 ]; then
    echo -e "${GREEN}✅ Underscore violations: $UNDERSCORES${NC}"
else
    echo -e "${YELLOW}⚠️  Underscore violations: $UNDERSCORES${NC}"
fi

# Missing INDEX files
MODULES_WITH_DOCS=$(find "$MODULE_PATH"/*/docs -maxdepth 0 -type d 2>/dev/null | wc -l)
MODULES_WITH_INDEX=$(find "$MODULE_PATH"/*/docs -maxdepth 1 -name "00-INDEX.md" 2>/dev/null | wc -l)
MISSING_INDEX=$((MODULES_WITH_DOCS - MODULES_WITH_INDEX))

if [ "$MISSING_INDEX" -eq 0 ]; then
    echo -e "${GREEN}✅ Missing INDEX: $MISSING_INDEX${NC}"
else
    echo -e "${YELLOW}⚠️  Missing INDEX: $MISSING_INDEX/$MODULES_WITH_DOCS${NC}"
fi

# Missing README files
MODULES_WITH_README=$(find "$MODULE_PATH"/*/docs -maxdepth 1 -name "README.md" 2>/dev/null | wc -l)
MISSING_README=$((MODULES_WITH_DOCS - MODULES_WITH_README))

if [ "$MISSING_README" -eq 0 ]; then
    echo -e "${GREEN}✅ Missing README: $MISSING_README${NC}"
else
    echo -e "${YELLOW}⚠️  Missing README: $MISSING_README/$MODULES_WITH_DOCS${NC}"
fi

# Total docs
TOTAL=$(find "$MODULE_PATH"/*/docs -type f -name "*.md" 2>/dev/null | wc -l)
echo -e "${BLUE}📝 Total docs: $TOTAL${NC}"

# Docs per module
echo ""
echo "Docs per module:"
find "$MODULE_PATH"/*/docs -type f -name "*.md" 2>/dev/null | \
    cut -d'/' -f2 | \
    sort | \
    uniq -c | \
    sort -rn | \
    head -10 | \
    while read count module; do
        echo "  $module: $count files"
    done

echo ""
echo "===================="

# Calcola score
SCORE=100
[ "$EMPTY" -gt 0 ] && SCORE=$((SCORE - 30))
[ "$UNDERSCORES" -gt 5 ] && SCORE=$((SCORE - 20))
[ "$MISSING_INDEX" -gt 0 ] && SCORE=$((SCORE - 25))
[ "$MISSING_README" -gt 0 ] && SCORE=$((SCORE - 25))

if [ "$SCORE" -ge 90 ]; then
    echo -e "${GREEN}✅ Docs health: EXCELLENT ($SCORE/100)${NC}"
elif [ "$SCORE" -ge 70 ]; then
    echo -e "${YELLOW}⚠️  Docs health: GOOD ($SCORE/100)${NC}"
elif [ "$SCORE" -ge 50 ]; then
    echo -e "${YELLOW}⚠️  Docs health: NEEDS ATTENTION ($SCORE/100)${NC}"
else
    echo -e "${RED}❌ Docs health: POOR ($SCORE/100)${NC}"
fi

echo ""
