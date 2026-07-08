#!/bin/bash

# Ensure that the script is provided with the new organization name
if [ $# -ne 1 ]; then
    echo "Usage: $0 <new-organization-name>"
    exit 1
fi

NEW_ORG="$1"
SCRIPT_PATH=$(readlink -f -- "$0")

# Check if .gitmodules file exists
if [ ! -f .gitmodules ]; then
    echo "Error: .gitmodules file not found!"
    exit 1
fi

# Process the main repository (root repository)
echo "Processing main repository (root)..."

# Get the repository name from the remote URL
MAIN_REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

# Create new remote URL using SSH by default
NEW_MAIN_REMOTE="git@github.com:$NEW_ORG/$MAIN_REPO_NAME.git"

echo "Changing main repository remote URL to: $NEW_MAIN_REMOTE"

# Set the new remote URL for the root repository
git remote set-url origin "$NEW_MAIN_REMOTE" || {
    echo "Error: Failed to set new remote URL for main repository"
    exit 1
}

echo "Main repository remote URL updated successfully!"
echo "----------------------------------------"

# Loop through each line in .gitmodules and process submodules
while IFS= read -r line; do
    # Clean up the line (remove carriage returns and surrounding whitespace)
    line=$(echo "$line" | tr -d '\r' | sed 's/^[[:space:]]*//;s/[[:space:]]*$//')
    
    # Look for the submodule path
    if [[ $line =~ path\ =\ (.+)$ ]]; then
        SUBMODULE_PATH="${BASH_REMATCH[1]}"
        # Clean up the submodule path
        SUBMODULE_PATH=$(echo "$SUBMODULE_PATH" | sed 's/^[[:space:]]*//;s/[[:space:]]*$//')

        echo "Processing submodule: $SUBMODULE_PATH"
        
        # Check if the submodule directory exists
        if [ ! -d "$SUBMODULE_PATH" ]; then
            echo "Warning: Directory $SUBMODULE_PATH does not exist, skipping..."
            continue
        fi
        
        # Enter the submodule directory
        (
            cd "$SUBMODULE_PATH" || { echo "Error: Could not enter directory $SUBMODULE_PATH"; exit 1; }
            
            # Get the repository name from the remote URL
            REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)
            
            # Create new remote URL using SSH by default
            NEW_REMOTE="git@github.com:$NEW_ORG/$REPO_NAME.git"

            echo "Changing submodule remote URL to: $NEW_REMOTE"
            
            # Set the new remote URL for the submodule
            git remote set-url origin "$NEW_REMOTE" || {
                echo "Error: Failed to set new remote URL for $SUBMODULE_PATH"
                return 1
            }
            
            # Optionally: Fetch and pull from the new remote (uncomment if needed)
            # git fetch "$NEW_REMOTE" || { echo "Error: Failed to fetch from $NEW_REMOTE"; return 1; }
            # git pull "$NEW_REMOTE" || { echo "Error: Failed to pull from $NEW_REMOTE"; return 1; }
            
            echo "----------------------------------------"
        )
    fi
done < .gitmodules
sed -i 's/\r$//' "$SCRIPT_PATH"
echo "All submodules and the main repository remote URL have been updated!"
