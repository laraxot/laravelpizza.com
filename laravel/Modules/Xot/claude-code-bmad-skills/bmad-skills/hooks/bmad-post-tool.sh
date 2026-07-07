#!/bin/bash
# BMAD Post-Tool Hook
# Tracks workflow progress and validates outputs after tool execution

TOOL_NAME="${CLAUDE_TOOL_NAME:-}"
TOOL_OUTPUT="${CLAUDE_TOOL_OUTPUT:-}"

case "$TOOL_NAME" in
    "Write")
        # Check if a BMAD document was created
        INPUT_PATH=$(echo "$CLAUDE_TOOL_INPUT" | jq -r '.file_path // empty' 2>/dev/null)

        # Track document creation in workflow
        if [[ "$INPUT_PATH" == *"product-brief"* ]]; then
            echo "BMAD: Product Brief created - Phase 1 (Analysis) progress"
        elif [[ "$INPUT_PATH" == *"prd"* ]]; then
            echo "BMAD: PRD created - Phase 2 (Planning) progress"
        elif [[ "$INPUT_PATH" == *"tech-spec"* ]]; then
            echo "BMAD: Tech Spec created - Phase 2 (Planning) progress"
        elif [[ "$INPUT_PATH" == *"architecture"* ]]; then
            echo "BMAD: Architecture created - Phase 3 (Solutioning) progress"
        elif [[ "$INPUT_PATH" == *"sprint"* ]]; then
            echo "BMAD: Sprint document created - Phase 4 (Implementation) progress"
        elif [[ "$INPUT_PATH" == *"STORY-"* ]]; then
            echo "BMAD: User Story created - Phase 4 (Implementation) progress"
        fi
        ;;
    "Task")
        # Track subagent completion
        if echo "$TOOL_OUTPUT" | grep -q "completed"; then
            echo "BMAD: Subagent task completed"
        fi
        ;;
esac

exit 0
