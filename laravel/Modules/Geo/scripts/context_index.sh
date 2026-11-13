#!/usr/bin/env bash
set -euo pipefail

# Simple indexer stub for context-mode: finds .md files under docs/wiki and calls ctx if available.
ROOT="$(pwd)"
FILES=$(git ls-files "docs/**/*.md" || true)

mkdir -p .cache/context-index || true

for f in $FILES; do
  [ -z "$f" ] && continue
  size=$(wc -c < "$f" || echo 0)
  if [ "$size" -gt $((50*1024)) ]; then
    echo "[context_index] Large file: $f (${size} bytes) -> summarizing to .cache"
    python3 scripts/summarize_md.py "$f" .cache/context-index/ || true
  fi
  if command -v ctx >/dev/null 2>&1; then
    echo "[context_index] Indexing $f"
    ctx index --path "$f" --source project-docs || echo "ctx index failed for $f"
  else
    echo "[context_index] context-mode CLI (ctx) not found; skipping indexing for $f"
  fi
done

echo "[context_index] done"
