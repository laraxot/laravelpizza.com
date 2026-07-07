#!/bin/bash

# validate-brief.sh
# Validates that a product brief has all required sections
# Usage: ./validate-brief.sh <product-brief-file>

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Required sections in a complete product brief
declare -a REQUIRED_SECTIONS=(
    "Problem Statement"
    "Target Users"
    "Proposed Solution"
    "Success Metrics"
    "Market & Competition"
    "Business Model"
    "Technical Considerations"
    "Risks & Mitigation"
    "Resource Estimates"
    "Dependencies"
    "Next Steps"
)

# Check if file argument provided
if [ $# -eq 0 ]; then
    echo -e "${RED}Error: No file specified${NC}"
    echo "Usage: $0 <product-brief-file>"
    echo ""
    echo "Example: $0 docs/product-brief-my-project.md"
    exit 1
fi

BRIEF_FILE="$1"

# Check if file exists
if [ ! -f "$BRIEF_FILE" ]; then
    echo -e "${RED}Error: File not found: $BRIEF_FILE${NC}"
    exit 1
fi

# Display header
clear
echo ""
echo -e "${BLUE}╔═══════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║                                                           ║${NC}"
echo -e "${BLUE}║         PRODUCT BRIEF VALIDATION                          ║${NC}"
echo -e "${BLUE}║         Checking Completeness                             ║${NC}"
echo -e "${BLUE}║                                                           ║${NC}"
echo -e "${BLUE}╚═══════════════════════════════════════════════════════════╝${NC}"
echo ""
echo "Validating: $BRIEF_FILE"
echo ""

# Initialize counters
TOTAL_SECTIONS=${#REQUIRED_SECTIONS[@]}
FOUND_SECTIONS=0
MISSING_SECTIONS=()

# Check for each required section
echo -e "${BLUE}Checking required sections...${NC}"
echo ""

for section in "${REQUIRED_SECTIONS[@]}"; do
    # Check if section header exists (with various markdown header formats)
    if grep -qi "^#.*${section}" "$BRIEF_FILE" || \
       grep -qi "^## ${section}" "$BRIEF_FILE" || \
       grep -qi "^### ${section}" "$BRIEF_FILE"; then
        echo -e "${GREEN}✓${NC} $section"
        ((FOUND_SECTIONS++))
    else
        echo -e "${RED}✗${NC} $section ${YELLOW}(MISSING)${NC}"
        MISSING_SECTIONS+=("$section")
    fi
done

echo ""
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# Calculate completeness percentage
COMPLETENESS=$((FOUND_SECTIONS * 100 / TOTAL_SECTIONS))

# Display summary
echo "Summary:"
echo "  Sections found: $FOUND_SECTIONS / $TOTAL_SECTIONS ($COMPLETENESS%)"
echo ""

# Check for placeholder variables
echo -e "${BLUE}Checking for unfilled placeholders...${NC}"
echo ""

PLACEHOLDER_COUNT=$(grep -o "{{[A-Z_]*}}" "$BRIEF_FILE" 2>/dev/null | wc -l || echo "0")

if [ "$PLACEHOLDER_COUNT" -gt 0 ]; then
    echo -e "${YELLOW}⚠${NC}  Found $PLACEHOLDER_COUNT placeholder(s) that need to be filled"
    echo ""
    echo "Placeholders found:"
    grep -n "{{[A-Z_]*}}" "$BRIEF_FILE" 2>/dev/null | head -10 || true
    if [ "$PLACEHOLDER_COUNT" -gt 10 ]; then
        echo "  ... and $((PLACEHOLDER_COUNT - 10)) more"
    fi
else
    echo -e "${GREEN}✓${NC} No unfilled placeholders found"
fi

echo ""
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# Additional content checks
echo -e "${BLUE}Checking content quality...${NC}"
echo ""

# Check document length
LINE_COUNT=$(wc -l < "$BRIEF_FILE")
if [ "$LINE_COUNT" -lt 100 ]; then
    echo -e "${YELLOW}⚠${NC}  Document is very short ($LINE_COUNT lines). Consider adding more detail."
else
    echo -e "${GREEN}✓${NC} Document has sufficient length ($LINE_COUNT lines)"
fi

# Check for metrics/numbers
if grep -q "[0-9]\+%" "$BRIEF_FILE" || \
   grep -q "[0-9]\+ users" "$BRIEF_FILE" || \
   grep -q "[0-9]\+ days\|weeks\|months" "$BRIEF_FILE"; then
    echo -e "${GREEN}✓${NC} Document includes quantifiable metrics"
else
    echo -e "${YELLOW}⚠${NC}  Consider adding more quantifiable metrics (%, users, timeframes)"
fi

# Check for dates/timeline
if grep -qi "Q[1-4] 20[0-9][0-9]" "$BRIEF_FILE" || \
   grep -qi "20[0-9][0-9]-[0-9][0-9]-[0-9][0-9]" "$BRIEF_FILE" || \
   grep -qi "timeline\|deadline\|launch" "$BRIEF_FILE"; then
    echo -e "${GREEN}✓${NC} Document includes timeline/dates"
else
    echo -e "${YELLOW}⚠${NC}  Consider adding specific timelines and dates"
fi

# Check for stakeholder information
if grep -qi "stakeholder\|interview\|consulted" "$BRIEF_FILE"; then
    echo -e "${GREEN}✓${NC} Document references stakeholders/interviews"
else
    echo -e "${YELLOW}⚠${NC}  Consider documenting stakeholders consulted"
fi

# Check for risks
if grep -qi "risk\|mitigation\|assumption" "$BRIEF_FILE"; then
    echo -e "${GREEN}✓${NC} Document addresses risks and assumptions"
else
    echo -e "${YELLOW}⚠${NC}  Document should include risk analysis"
fi

echo ""
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

# Final assessment
echo -e "${BLUE}FINAL ASSESSMENT${NC}"
echo ""

if [ $COMPLETENESS -eq 100 ] && [ "$PLACEHOLDER_COUNT" -eq 0 ]; then
    echo -e "${GREEN}✓ Product brief is COMPLETE!${NC}"
    echo ""
    echo "Next steps:"
    echo "  1. Review content for accuracy and clarity"
    echo "  2. Get stakeholder sign-off"
    echo "  3. Hand off to Product Manager for PRD creation"
    echo ""
    exit 0
elif [ $COMPLETENESS -ge 80 ]; then
    echo -e "${YELLOW}⚠ Product brief is MOSTLY COMPLETE ($COMPLETENESS%)${NC}"
    echo ""
    if [ ${#MISSING_SECTIONS[@]} -gt 0 ]; then
        echo "Missing sections:"
        for section in "${MISSING_SECTIONS[@]}"; do
            echo "  - $section"
        done
        echo ""
    fi
    if [ "$PLACEHOLDER_COUNT" -gt 0 ]; then
        echo "Fill remaining $PLACEHOLDER_COUNT placeholder(s)"
        echo ""
    fi
    echo "Complete these items before handoff to Product Manager."
    echo ""
    exit 1
else
    echo -e "${RED}✗ Product brief is INCOMPLETE ($COMPLETENESS%)${NC}"
    echo ""
    echo "Missing critical sections:"
    for section in "${MISSING_SECTIONS[@]}"; do
        echo "  - $section"
    done
    echo ""
    if [ "$PLACEHOLDER_COUNT" -gt 0 ]; then
        echo "Fill $PLACEHOLDER_COUNT placeholder(s)"
        echo ""
    fi
    echo "Complete these sections before proceeding."
    echo ""
    echo "Use the product brief template:"
    echo "  templates/product-brief.template.md"
    echo ""
    echo "Use the discovery checklist for guidance:"
    echo "  scripts/discovery-checklist.sh"
    echo ""
    exit 1
fi
