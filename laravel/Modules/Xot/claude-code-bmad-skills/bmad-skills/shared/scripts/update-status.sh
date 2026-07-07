#!/bin/bash
# Update BMAD workflow status
# Usage: ./update-status.sh <workflow> <output_file>
# Example: ./update-status.sh product_brief docs/product-brief-myapp-2025-01-15.md

WORKFLOW=$1
OUTPUT_FILE=$2
STATUS_FILE="${BMAD_STATUS_FILE:-docs/bmm-workflow-status.yaml}"
TIMESTAMP=$(date -Iseconds)

if [ -z "$WORKFLOW" ]; then
    echo "Usage: $0 <workflow> [output_file]"
    echo "Workflows: product_brief, research, brainstorm, prd, tech_spec, ux_design, architecture, gate_check, sprint_planning"
    exit 1
fi

if [ ! -f "$STATUS_FILE" ]; then
    echo "ERROR: Status file not found: $STATUS_FILE"
    exit 1
fi

# Determine phase from workflow
case "$WORKFLOW" in
    product_brief|research|brainstorm)
        PHASE="phase_1_analysis"
        ;;
    prd|tech_spec|ux_design)
        PHASE="phase_2_planning"
        ;;
    architecture|gate_check)
        PHASE="phase_3_solutioning"
        ;;
    sprint_planning|stories)
        PHASE="phase_4_implementation"
        ;;
    *)
        echo "ERROR: Unknown workflow: $WORKFLOW"
        exit 1
        ;;
esac

# Create a temporary file with updates
# Note: This is a simple implementation. For production, use yq or a proper YAML parser.

echo "Updating $WORKFLOW in $PHASE..."
echo "Output file: ${OUTPUT_FILE:-'(none)'}"
echo "Timestamp: $TIMESTAMP"

# For now, output the update instructions (Claude will handle the actual edit)
cat <<EOF

To update status file, make these changes to $STATUS_FILE:

In $PHASE.workflows.$WORKFLOW:
  completed: true
  output_file: "$OUTPUT_FILE"
  completed_at: "$TIMESTAMP"

Update last_updated: "$TIMESTAMP"

Recalculate metrics:
  completed_workflows: +1
  progress_percentage: (completed_workflows / total_workflows) * 100

EOF
