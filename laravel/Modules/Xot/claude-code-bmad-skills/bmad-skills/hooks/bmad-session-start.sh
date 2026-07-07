#!/bin/bash
# BMAD Session Start Hook
# Loads BMAD context and sets up environment for all skills

# Set BMAD environment variables
if [ -n "$CLAUDE_ENV_FILE" ]; then
    # Check if we're in a BMAD project
    if [ -f "bmad/config.yaml" ]; then
        echo 'export BMAD_PROJECT=true' >> "$CLAUDE_ENV_FILE"

        # Extract project name from config
        PROJECT_NAME=$(grep "project_name:" bmad/config.yaml 2>/dev/null | cut -d: -f2 | tr -d ' "')
        if [ -n "$PROJECT_NAME" ]; then
            echo "export BMAD_PROJECT_NAME=\"$PROJECT_NAME\"" >> "$CLAUDE_ENV_FILE"
        fi

        # Extract project level
        PROJECT_LEVEL=$(grep "project_level:" bmad/config.yaml 2>/dev/null | cut -d: -f2 | tr -d ' ')
        if [ -n "$PROJECT_LEVEL" ]; then
            echo "export BMAD_PROJECT_LEVEL=$PROJECT_LEVEL" >> "$CLAUDE_ENV_FILE"
        fi

        # Set output folder
        OUTPUT_FOLDER=$(grep "output_folder:" bmad/config.yaml 2>/dev/null | cut -d: -f2 | tr -d ' "')
        OUTPUT_FOLDER=${OUTPUT_FOLDER:-docs}
        echo "export BMAD_OUTPUT_FOLDER=\"$OUTPUT_FOLDER\"" >> "$CLAUDE_ENV_FILE"
    else
        echo 'export BMAD_PROJECT=false' >> "$CLAUDE_ENV_FILE"
    fi

    # Set timestamp for this session
    echo "export BMAD_SESSION_START=\"$(date -Iseconds)\"" >> "$CLAUDE_ENV_FILE"
fi
