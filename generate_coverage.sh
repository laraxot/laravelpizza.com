#!/usr/bin/env bash
# Generate coverage report for LaravelPizza
# Run from project root: ./generate_coverage.sh [html]
# MIN_COVERAGE=0 ./generate_coverage.sh  # no fail on low coverage

set -e
ROOT="$(cd "$(dirname "$0")" && pwd)"
cd "$ROOT/laravel"

MIN_COVERAGE="${MIN_COVERAGE:-0}"
OUTPUT="${1:-terminal}"

echo "Running Pest with coverage (min=${MIN_COVERAGE}%)..."
./vendor/bin/pest --coverage --min="$MIN_COVERAGE"

if [[ "$OUTPUT" == "html" ]]; then
    mkdir -p "$ROOT/build/coverage"
    ./vendor/bin/pest --coverage --coverage-html="$ROOT/build/coverage" --min="$MIN_COVERAGE"
    echo "HTML report: $ROOT/build/coverage/index.html"
fi
