#!/bin/bash
# Check current BMAD phase and recommend next workflow
# Usage: ./check-phase.sh

STATUS_FILE="${BMAD_STATUS_FILE:-docs/bmm-workflow-status.yaml}"

if [ ! -f "$STATUS_FILE" ]; then
    echo "BMAD_STATUS: not_initialized"
    echo "RECOMMENDATION: Run /workflow-init to set up BMAD"
    exit 0
fi

# Extract current phase
CURRENT_PHASE=$(grep "^current_phase:" "$STATUS_FILE" 2>/dev/null | awk '{print $2}')
PROJECT_LEVEL=$(grep "level:" "$STATUS_FILE" 2>/dev/null | head -1 | awk '{print $2}')

echo "CURRENT_PHASE: $CURRENT_PHASE"
echo "PROJECT_LEVEL: $PROJECT_LEVEL"

# Check Phase 1 workflows
check_workflow() {
    local workflow=$1
    local phase=$2
    grep -A5 "${workflow}:" "$STATUS_FILE" | grep "completed:" | head -1 | grep -q "true"
    return $?
}

get_workflow_status() {
    local workflow=$1
    grep -A5 "${workflow}:" "$STATUS_FILE" | grep "status:" | head -1 | awk '{print $2}' | tr -d '"'
}

echo ""
echo "=== Workflow Status ==="

# Phase 1
echo "Phase 1 - Analysis:"
for wf in product_brief research brainstorm; do
    status=$(get_workflow_status $wf)
    if check_workflow $wf phase_1; then
        echo "  ✓ $wf (completed)"
    elif [ "$status" = "required" ]; then
        echo "  ⚠ $wf (required - NOT DONE)"
    else
        echo "  - $wf ($status)"
    fi
done

# Phase 2
echo "Phase 2 - Planning:"
for wf in prd tech_spec ux_design; do
    status=$(get_workflow_status $wf)
    if check_workflow $wf phase_2; then
        echo "  ✓ $wf (completed)"
    elif [ "$status" = "required" ]; then
        echo "  ⚠ $wf (required - NOT DONE)"
    else
        echo "  - $wf ($status)"
    fi
done

# Phase 3
echo "Phase 3 - Solutioning:"
for wf in architecture gate_check; do
    status=$(get_workflow_status $wf)
    if check_workflow $wf phase_3; then
        echo "  ✓ $wf (completed)"
    elif [ "$status" = "required" ]; then
        echo "  ⚠ $wf (required - NOT DONE)"
    else
        echo "  - $wf ($status)"
    fi
done

# Phase 4
echo "Phase 4 - Implementation:"
if check_workflow sprint_planning phase_4; then
    echo "  ✓ sprint_planning (completed)"
else
    echo "  ⚠ sprint_planning (required - NOT DONE)"
fi

# Determine recommendation
echo ""
echo "=== Recommendation ==="

# Check each phase in order
if ! check_workflow product_brief phase_1; then
    pb_status=$(get_workflow_status product_brief)
    if [ "$pb_status" = "required" ] || [ "$pb_status" = "recommended" ]; then
        echo "NEXT: /product-brief"
        echo "REASON: Phase 1 - Create product brief before planning"
        exit 0
    fi
fi

if [ "$PROJECT_LEVEL" -ge 2 ]; then
    if ! check_workflow prd phase_2; then
        echo "NEXT: /prd"
        echo "REASON: Phase 2 - PRD required for Level 2+ projects"
        exit 0
    fi
else
    if ! check_workflow tech_spec phase_2; then
        echo "NEXT: /tech-spec"
        echo "REASON: Phase 2 - Tech spec required for Level 0-1 projects"
        exit 0
    fi
fi

if [ "$PROJECT_LEVEL" -ge 2 ]; then
    if ! check_workflow architecture phase_3; then
        echo "NEXT: /architecture"
        echo "REASON: Phase 3 - Architecture required for Level 2+ projects"
        exit 0
    fi
fi

if ! check_workflow sprint_planning phase_4; then
    echo "NEXT: /sprint-planning"
    echo "REASON: Phase 4 - Plan sprints before implementation"
    exit 0
fi

echo "NEXT: /dev-story"
echo "REASON: Phase 4 - Ready for story implementation"
