#!/bin/bash

# Prompt user for provider and organization/group
read -p "Enter provider (github, bitbucket, custom): " PROVIDER

if [[ "$PROVIDER" == "github" || "$PROVIDER" == "bitbucket" ]]; then
    read -p "Enter the organization/group name: " NEW_ORG
elif [[ "$PROVIDER" == "custom" ]]; then
    read -p "Enter the custom URL (e.g., git.gitlab.com:2280/groupname): " CUSTOM_URL
else
    echo "Error: Invalid provider. Please choose 'github', 'bitbucket', or 'custom'."
    exit 1
fi

# Check if .gitmodules file exists
if [ ! -f .gitmodules ]; then
    echo "Error: .gitmodules file not found!"
    exit 1
fi

# Determine base URL for the new remote
if [[ "$PROVIDER" == "github" ]]; then
    BASE_URL="git@github.com:$NEW_ORG"
elif [[ "$PROVIDER" == "bitbucket" ]]; then
    BASE_URL="git@bitbucket.org:$NEW_ORG"
else
    BASE_URL="$CUSTOM_URL"
fi

# Process the main repository (root repository)
echo "Processing main repository (root)..."

MAIN_REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)
NEW_MAIN_REMOTE="$BASE_URL/$MAIN_REPO_NAME.git"

echo "Changing main repository remote URL to: $NEW_MAIN_REMOTE"

git remote set-url origin "$NEW_MAIN_REMOTE" || {
    echo "Error: Failed to set new remote URL for main repository"
    exit 1
}

echo "Main repository remote URL updated successfully!"
echo "----------------------------------------"

# Process each submodule in .gitmodules
while IFS= read -r line; do
    line=$(echo "$line" | tr -d '\r' | sed 's/^[[:space:]]*//;s/[[:space:]]*$//')
    if [[ $line =~ path\ =\ (.+)$ ]]; then
        SUBMODULE_PATH="${BASH_REMATCH[1]}"
        SUBMODULE_PATH=$(echo "$SUBMODULE_PATH" | sed 's/^[[:space:]]*//;s/[[:space:]]*$//')

        echo "Processing submodule: $SUBMODULE_PATH"

        if [ ! -d "$SUBMODULE_PATH" ]; then
            echo "Warning: Directory $SUBMODULE_PATH does not exist, skipping..."
            continue
        fi

        (
            cd "$SUBMODULE_PATH" || { echo "Error: Could not enter directory $SUBMODULE_PATH"; exit 1; }

            REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)
            NEW_REMOTE="$BASE_URL/$REPO_NAME.git"

            echo "Changing submodule remote URL to: $NEW_REMOTE"

            git remote set-url origin "$NEW_REMOTE" || {
                echo "Error: Failed to set new remote URL for $SUBMODULE_PATH"
                return 1
            }

            echo "----------------------------------------"
        )
    fi
done < .gitmodules

echo "All submodules and the main repository remote URL have been updated!"
