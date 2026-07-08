




#!/bin/bash

# Ensure that the script is provided with the new organization name
if [ $# -ne 1 ]; then
    echo "Usage: $0 <new-organization-name>"
    exit 1
fi

NEW_ORG="$1"
SCRIPT_PATH=$(readlink -f -- "$0")

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

# Get list of submodules using git submodule foreach
echo "Processing submodules..."

# Use git submodule foreach to process each submodule
git submodule foreach --quiet '
    SUBMODULE_PATH=$sm_path
    echo "Processing submodule: $SUBMODULE_PATH"

    # Get the repository name from the remote URL
    REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

    # Create new remote URL using SSH by default
    NEW_REMOTE="git@github.com:'$NEW_ORG'/$REPO_NAME.git"

    echo "Changing submodule remote URL to: $NEW_REMOTE"

    # Set the new remote URL for the submodule
    git remote set-url origin "$NEW_REMOTE" || {
        echo "Error: Failed to set new remote URL for $SUBMODULE_PATH"
        exit 1
    }

    echo "----------------------------------------"
'

# Alternative method using git config if foreach doesn't work as expected
# This gets all submodule URLs from git config
# for SUBMODULE_URL in $(git config --file .gitmodules --get-regexp url | awk "{print \$2}"); do
#     SUBMODULE_PATH=$(git config --file .gitmodules --get-regexp path | awk "{print \$2}")
#     # ... rest of the processing
# done

sed -i 's/\r$//' "$SCRIPT_PATH"

#!/bin/bash

# Ensure that the script is provided with the new organization name
if [ $# -ne 1 ]; then
    echo "Usage: $0 <new-organization-name>"
    exit 1
fi

NEW_ORG="$1"
SCRIPT_PATH=$(readlink -f -- "$0")

# Process the main repository (root repository)
echo "Processing main repository (root)..."

# Get the repository name from the remote URL
MAIN_REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

# Create new remote URL using SSH by default
NEW_MAIN_REMOTE="git@github.com:$NEW_ORG/$MAIN_REPO_NAME.git"

echo "Changing main repository remote URL to: $NEW_MAIN_REMOTE"

git push -u $NEW_MAIN_REMOTE

# Set the new remote URL for the root repository
git remote set-url origin "$NEW_MAIN_REMOTE" || {
    echo "Error: Failed to set new remote URL for main repository"
    exit 1
}

echo "Main repository remote URL updated successfully!"
echo "----------------------------------------"

# Get list of submodules using git submodule foreach
echo "Processing submodules..."

# Use git submodule foreach to process each submodule
git submodule foreach --quiet '
    SUBMODULE_PATH=$sm_path
    echo "Processing submodule: $SUBMODULE_PATH"

    # Get the repository name from the remote URL
    REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

    # Create new remote URL using SSH by default
    NEW_REMOTE="git@github.com:'$NEW_ORG'/$REPO_NAME.git"

    echo "Changing submodule remote URL to: $NEW_REMOTE"

    # Set the new remote URL for the submodule
    git remote set-url origin "$NEW_REMOTE" || {
        echo "Error: Failed to set new remote URL for $SUBMODULE_PATH"
        exit 1
    }

    echo "----------------------------------------"
'

# Alternative method using git config if foreach doesn't work as expected
# This gets all submodule URLs from git config
# for SUBMODULE_URL in $(git config --file .gitmodules --get-regexp url | awk "{print \$2}"); do
#     SUBMODULE_PATH=$(git config --file .gitmodules --get-regexp path | awk "{print \$2}")
#     # ... rest of the processing
# done

sed -i 's/\r$//' "$SCRIPT_PATH"



#!/bin/bash

# Ensure that the script is provided with the new organization name
if [ $# -ne 1 ]; then
    echo "Usage: $0 <new-organization-name>"
    exit 1
fi

NEW_ORG="$1"
SCRIPT_PATH=$(readlink -f -- "$0")

# Process the main repository (root repository)
echo "Processing main repository (root)..."

# Get the repository name from the remote URL
MAIN_REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

# Create new remote URL using SSH by default
NEW_MAIN_REMOTE="git@github.com:$NEW_ORG/$MAIN_REPO_NAME.git"

echo "Changing main repository remote URL to: $NEW_MAIN_REMOTE"

git push -u $NEW_MAIN_REMOTE

# Set the new remote URL for the root repository
git remote set-url origin "$NEW_MAIN_REMOTE" || {
    echo "Error: Failed to set new remote URL for main repository"
    exit 1
}

echo "Main repository remote URL updated successfully!"
echo "----------------------------------------"

# Get list of submodules using git submodule foreach
echo "Processing submodules..."

# Use git submodule foreach to process each submodule
git submodule foreach --quiet '
    SUBMODULE_PATH=$sm_path
    echo "Processing submodule: $SUBMODULE_PATH"

    # Get the repository name from the remote URL
    REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

    # Create new remote URL using SSH by default
    NEW_REMOTE="git@github.com:'$NEW_ORG'/$REPO_NAME.git"

    echo "Changing submodule remote URL to: $NEW_REMOTE"

    # Set the new remote URL for the submodule
    git remote set-url origin "$NEW_REMOTE" || {
        echo "Error: Failed to set new remote URL for $SUBMODULE_PATH"
        exit 1
    }

    echo "----------------------------------------"
'

# Alternative method using git config if foreach doesn't work as expected
# This gets all submodule URLs from git config
# for SUBMODULE_URL in $(git config --file .gitmodules --get-regexp url | awk "{print \$2}"); do
#     SUBMODULE_PATH=$(git config --file .gitmodules --get-regexp path | awk "{print \$2}")
#     # ... rest of the processing
# done

sed -i 's/\r$//' "$SCRIPT_PATH"



#!/bin/bash

# Ensure that the script is provided with the new organization name
if [ $# -ne 1 ]; then
    echo "Usage: $0 <new-organization-name>"
    exit 1
fi

NEW_ORG="$1"
SCRIPT_PATH=$(readlink -f -- "$0")

# Process the main repository (root repository)
echo "Processing main repository (root)..."

# Get the repository name from the remote URL
MAIN_REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

# Create new remote URL using SSH by default
NEW_MAIN_REMOTE="git@github.com:$NEW_ORG/$MAIN_REPO_NAME.git"

echo "Changing main repository remote URL to: $NEW_MAIN_REMOTE"

git push -u $NEW_MAIN_REMOTE

# Set the new remote URL for the root repository
git remote set-url origin "$NEW_MAIN_REMOTE" || {
    echo "Error: Failed to set new remote URL for main repository"
    exit 1
}

echo "Main repository remote URL updated successfully!"
echo "----------------------------------------"

# Get list of submodules using git submodule foreach
echo "Processing submodules..."

# Use git submodule foreach to process each submodule
git submodule foreach --quiet '
    SUBMODULE_PATH=$sm_path
    echo "Processing submodule: $SUBMODULE_PATH"

    # Get the repository name from the remote URL
    REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

    # Create new remote URL using SSH by default
    NEW_REMOTE="git@github.com:'$NEW_ORG'/$REPO_NAME.git"

    echo "Changing submodule remote URL to: $NEW_REMOTE"

    # Set the new remote URL for the submodule
    git remote set-url origin "$NEW_REMOTE" || {
        echo "Error: Failed to set new remote URL for $SUBMODULE_PATH"
        exit 1
    }

    echo "----------------------------------------"
'

# Alternative method using git config if foreach doesn't work as expected
# This gets all submodule URLs from git config
# for SUBMODULE_URL in $(git config --file .gitmodules --get-regexp url | awk "{print \$2}"); do
#     SUBMODULE_PATH=$(git config --file .gitmodules --get-regexp path | awk "{print \$2}")
#     # ... rest of the processing
# done

sed -i 's/\r$//' "$SCRIPT_PATH"
#!/bin/bash

# Ensure that the script is provided with the new organization name
if [ $# -ne 1 ]; then
    echo "Usage: $0 <new-organization-name>"
    exit 1
fi

NEW_ORG="$1"
SCRIPT_PATH=$(readlink -f -- "$0")

# Process the main repository (root repository)
echo "Processing main repository (root)..."

# Get the repository name from the remote URL
MAIN_REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

# Create new remote URL using SSH by default
NEW_MAIN_REMOTE="git@github.com:$NEW_ORG/$MAIN_REPO_NAME.git"

echo "Changing main repository remote URL to: $NEW_MAIN_REMOTE"

git push -u $NEW_MAIN_REMOTE

# Set the new remote URL for the root repository
git remote set-url origin "$NEW_MAIN_REMOTE" || {
    echo "Error: Failed to set new remote URL for main repository"
    exit 1
}

echo "Main repository remote URL updated successfully!"
echo "----------------------------------------"

# Get list of submodules using git submodule foreach
echo "Processing submodules..."

# Use git submodule foreach to process each submodule
git submodule foreach --quiet '
    SUBMODULE_PATH=$sm_path
    echo "Processing submodule: $SUBMODULE_PATH"

    # Get the repository name from the remote URL
    REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

    # Create new remote URL using SSH by default
    NEW_REMOTE="git@github.com:'$NEW_ORG'/$REPO_NAME.git"

    echo "Changing submodule remote URL to: $NEW_REMOTE"

    # Set the new remote URL for the submodule
    git remote set-url origin "$NEW_REMOTE" || {
        echo "Error: Failed to set new remote URL for $SUBMODULE_PATH"
        exit 1
    }

    echo "----------------------------------------"
'

# Alternative method using git config if foreach doesn't work as expected
# This gets all submodule URLs from git config
# for SUBMODULE_URL in $(git config --file .gitmodules --get-regexp url | awk "{print \$2}"); do
#     SUBMODULE_PATH=$(git config --file .gitmodules --get-regexp path | awk "{print \$2}")
#     # ... rest of the processing
# done

sed -i 's/\r$//' "$SCRIPT_PATH"
#!/bin/bash

# Ensure that the script is provided with the new organization name
if [ $# -ne 1 ]; then
    echo "Usage: $0 <new-organization-name>"
    exit 1
fi

NEW_ORG="$1"
SCRIPT_PATH=$(readlink -f -- "$0")

# Process the main repository (root repository)
echo "Processing main repository (root)..."

# Get the repository name from the remote URL
MAIN_REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

# Create new remote URL using SSH by default
NEW_MAIN_REMOTE="git@github.com:$NEW_ORG/$MAIN_REPO_NAME.git"

echo "Changing main repository remote URL to: $NEW_MAIN_REMOTE"

git push -u $NEW_MAIN_REMOTE

# Set the new remote URL for the root repository
git remote set-url origin "$NEW_MAIN_REMOTE" || {
    echo "Error: Failed to set new remote URL for main repository"
    exit 1
}

echo "Main repository remote URL updated successfully!"
echo "----------------------------------------"

# Get list of submodules using git submodule foreach
echo "Processing submodules..."

# Use git submodule foreach to process each submodule
git submodule foreach --quiet '
    SUBMODULE_PATH=$sm_path
    echo "Processing submodule: $SUBMODULE_PATH"

    # Get the repository name from the remote URL
    REPO_NAME=$(basename "$(git config --get remote.origin.url)" .git)

    # Create new remote URL using SSH by default
    NEW_REMOTE="git@github.com:'$NEW_ORG'/$REPO_NAME.git"

    echo "Changing submodule remote URL to: $NEW_REMOTE"

    # Set the new remote URL for the submodule
    git remote set-url origin "$NEW_REMOTE" || {
        echo "Error: Failed to set new remote URL for $SUBMODULE_PATH"
        exit 1
    }

    echo "----------------------------------------"
'

# Alternative method using git config if foreach doesn't work as expected
# This gets all submodule URLs from git config
# for SUBMODULE_URL in $(git config --file .gitmodules --get-regexp url | awk "{print \$2}"); do
#     SUBMODULE_PATH=$(git config --file .gitmodules --get-regexp path | awk "{print \$2}")
#     # ... rest of the processing
# done

sed -i 's/\r$//' "$SCRIPT_PATH"
echo "All submodules and the main repository remote URL have been updated!"
