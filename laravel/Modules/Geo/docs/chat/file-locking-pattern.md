# File Locking Pattern for Concurrent File Modifications

## Philosophy: Atomic File Operations

The file locking pattern prevents race conditions when multiple agents or processes might modify the same file simultaneously. This is critical in a monorepo where multiple modules, themes, and AI agents may work concurrently.

## Pattern Definition

### Before Modification
```bash
# Check if lock exists
if [ -f "${file}.lock" ]; then
  echo "File is locked by another process"
  exit 1
fi

# Create lock file
touch "${file}.lock"
```

### After Modification
```bash
# Delete lock to signal completion
rm "${file}.lock"
```

### Why Lock Files?
1. **Visibility:** `.lock` file is explicit, human-readable, easy to debug
2. **Filesystem atomicity:** `touch` and `rm` are atomic on Unix systems
3. **Fallback safety:** Lock persists if process crashes (manual cleanup needed)
4. **Cross-language compatibility:** Works with PHP, shell, Node, Python, etc.
5. **Monorepo scalability:** Multiple AI agents can check same lock before writing

## Implementation in File-Lock-Manager

Creating `bashscripts/tools/file-lock-manager.sh` with:
- `check_lock(filename)` — Return 0 if no lock, 1 if locked
- `acquire_lock(filename, timeout)` — Wait up to timeout seconds, then create lock
- `release_lock(filename)` — Remove lock file
- `modify_with_lock(filename, command)` — Atomic modify with locking

## Use Cases in Monorepo

1. **Module documentation updates:** When agents update `laravel/Modules/User/docs/INDEX.md`
2. **Theme configuration:** Writing to `laravel/Themes/Zero/config.json`
3. **Shared config files:** `.gitignore` blocks, composer.json, package.json
4. **Wiki consolidation:** docs/wiki/ updates from multiple agent queries
5. **Database migrations:** Prevent concurrent migration file creation

## Integration Points

### In GitHub Actions / CI Pipeline
```yaml
- name: Check lock before deploy
  run: |
    if [ -f "deploy.lock" ]; then
      echo "Deployment already in progress"
      exit 1
    fi
    touch deploy.lock
    ./deploy.sh
    rm deploy.lock
```

### In PHP (Laravel)
```php
// Wrapper in a trait or service
public function modifyFileWithLock($filePath, callable $modifier) {
    $lockFile = $filePath . '.lock';
    if (file_exists($lockFile)) {
        throw new RuntimeException("File is locked");
    }
    touch($lockFile);
    try {
        $modifier($filePath);
    } finally {
        unlink($lockFile);
    }
}
```

### In AI Agent Workflow
```bash
# Before modifying docs/wiki/concepts/second-brain.md
source bashscripts/tools/file-lock-manager.sh
acquire_lock "docs/wiki/concepts/second-brain.md" 30

# ... perform modification ...

release_lock "docs/wiki/concepts/second-brain.md"
```

## Why NOT Use Directory Locks or Database Locks?

1. **Directory locks:** Harder to clean up, confuse developers
2. **Database locks:** Overkill for file-based documentation, adds external dependency
3. **Git hooks:** Don't work reliably across agents, no race condition handling
4. **Symlinks:** Fragile, platform-dependent, harder to debug

File locks are **simple, portable, visible, and sufficient** for monorepo workflows.

## Validation After Modification

After lock is released, run validation:
- **phpstan:** Type checking on PHP files
- **phpmd:** Code metrics and quality gates
- **llm-wiki pattern:** `qmd search` to verify cross-links updated correctly
- **markdown linting:** No syntax errors in docs

If validation fails, keep the `.lock` file present until issue is resolved (manual intervention needed).

## References
- bashscripts/tools/file-lock-manager.sh - Implementation
- GitHub issue #2 - File locking implementation details
- [[feedback_canonical_sources]] - Always verify via git + wiki
