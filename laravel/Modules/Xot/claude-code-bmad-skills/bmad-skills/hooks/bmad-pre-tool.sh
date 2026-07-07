#!/bin/bash
# BMAD Pre-Tool Hook
# Validates tool usage and provides context before tool execution

# This hook receives tool information via environment variables:
# CLAUDE_TOOL_NAME - Name of the tool about to be used
# CLAUDE_TOOL_INPUT - JSON input to the tool

TOOL_NAME="${CLAUDE_TOOL_NAME:-}"

case "$TOOL_NAME" in
    "Write")
        # Check if writing to BMAD output folder
        INPUT_PATH=$(echo "$CLAUDE_TOOL_INPUT" | jq -r '.file_path // empty' 2>/dev/null)
        if [[ "$INPUT_PATH" == *"/docs/"* ]] || [[ "$INPUT_PATH" == *"/bmad/"* ]]; then
            echo "BMAD: Writing to BMAD-managed path: $INPUT_PATH"
        fi
        ;;
    "Task")
        # Log subagent launches for BMAD workflows
        SUBAGENT_TYPE=$(echo "$CLAUDE_TOOL_INPUT" | jq -r '.subagent_type // empty' 2>/dev/null)
        if [ -n "$SUBAGENT_TYPE" ]; then
            echo "BMAD: Launching $SUBAGENT_TYPE subagent"
        fi
        ;;
esac

# Always allow the tool to proceed
exit 0
