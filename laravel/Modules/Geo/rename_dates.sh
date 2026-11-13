#!/usr/bin/env bash
set -euo pipefail
echo "Starting rename of markdown files with dates..."

find . -type f -name "*-[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]*.md" -print0 | while IFS= read -r -d '' f; do
  # Remove the date pattern from the filename (keep extension)
  base="${f%.*}"
  ext="${f##*.}"
  newbase="${base//-[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]/}"
  new="${newbase}.${ext}"
  if [[ "$f" != "$new" ]]; then
    echo "Renaming $f -> $new"
    mv "$f" "$new"
  fi
done

echo "Rename operation completed."