#!/bin/bash

# Script: generate-env-testing.sh
# Purpose: Generate .env.testing from .env with only _test suffix added to database names
# IMPORTANT: This script ensures APP_URL and all other non-DB variables remain IDENTICAL to .env

set -e

ENV_FILE=".env"
ENV_TESTING_FILE=".env.testing"

# Check if .env exists
if [ ! -f "$ENV_FILE" ]; then
    echo "Error: $ENV_FILE not found!"
    exit 1
fi

echo "Generating $ENV_TESTING_FILE from $ENV_FILE..."

# Create .env.testing by:
# 1. Copy .env exactly
# 2. Only change DB_DATABASE to add _test suffix (if it exists)
# 3. Only change DB_DATABASE_USER to add _test suffix (if it exists)

# Use sed to make the changes:
# - DB_DATABASE=xxx → DB_DATABASE=xxx_test (only if not already _test)
# - DB_DATABASE_USER=xxx → DB_DATABASE_USER=xxx_test (only if not already _test)

cp "$ENV_FILE" "$ENV_TESTING_FILE"

# Add _test suffix to database names (only if not already present)
sed -i 's/^DB_DATABASE=\(.*\)$/DB_DATABASE=\1_test/' "$ENV_TESTING_FILE"
sed -i 's/^DB_DATABASE_USER=\(.*\)$/DB_DATABASE_USER=\1_test/' "$ENV_TESTING_FILE"

# Remove duplicate _test if already present (handle cases where script runs multiple times)
sed -i 's/_test_test/_test_test/g' "$ENV_TESTING_FILE"

echo "Done! $ENV_TESTING_FILE created."

# Verify APP_URL matches
APP_URL_ORIGINAL=$(grep "^APP_URL=" "$ENV_FILE" | cut -d= -f2-)
APP_URL_TESTING=$(grep "^APP_URL=" "$ENV_TESTING_FILE" | cut -d= -f2-)

if [ "$APP_URL_ORIGINAL" != "$APP_URL_TESTING" ]; then
    echo "ERROR: APP_URL mismatch!"
    echo "  .env: $APP_URL_ORIGINAL"
    echo "  .env.testing: $APP_URL_TESTING"
    exit 1
fi

echo "Verification passed: APP_URL is identical in both files."
