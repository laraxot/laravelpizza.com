# GitHub Actions Workflow Debugging

> **Guide: Debugging GitHub Actions Workflows**
> 
> **Status:** Active
> **Last Updated:** 2026-03-13

---

## Common Issues & Solutions

### Issue 1: Command Not Found

**Symptom:**
```bash
bashscripts/git/subtrees/sync_remote_repo.sh: line 46: is_ci_context: command not found
```

**Cause:**
- Library files not in PATH
- Environment variables not set correctly
- Relative paths not resolved in CI context

**Solution:**
```yaml
- name: Run remote sync
  run: |
    # 1. Verify libraries exist
    test -f bashscripts/lib/custom.sh && echo "✅ custom.sh found"
    
    # 2. Set environment variables
    export PROJECT_ROOT="$GITHUB_WORKSPACE"
    export PATH="$GITHUB_WORKSPACE/bashscripts:$PATH"
    
    # 3. Use bash -x for debug output
    bash -x bashscripts/git/subtrees/sync_remote_repo.sh
  env:
    PROJECT_ROOT: ${{ github.workspace }}
```

---

### Issue 2: File Not Found

**Symptom:**
```bash
❌ gitmodules.ini not found
```

**Solution:**
```yaml
- name: Verify prerequisites
  run: |
    echo "Current directory: $(pwd)"
    echo "Files in directory:"
    ls -la
    
    # Check absolute paths
    test -f "$GITHUB_WORKSPACE/gitmodules.ini" && echo "✅ Found"
```

---

### Issue 3: Permission Denied

**Symptom:**
```bash
bash: line 1: ./script.sh: Permission denied
```

**Solution:**
```yaml
- name: Make executable
  run: chmod +x bashscripts/git/subtrees/sync_remote_repo.sh

- name: Run script
  run: ./bashscripts/git/subtrees/sync_remote_repo.sh
```

---

## Debugging Techniques

### 1. Enable Debug Output

```yaml
- name: Debug run
  run: |
    set -x  # Enable debug mode
    echo "GITHUB_WORKSPACE: $GITHUB_WORKSPACE"
    echo "Current user: $(whoami)"
    echo "Current directory: $(pwd)"
    echo "PATH: $PATH"
    
    # Your command
    bash -x script.sh
    
    set +x  # Disable debug mode
```

### 2. Add Verification Steps

```yaml
- name: Verify environment
  run: |
    echo "=== Environment Variables ==="
    env | sort
    
    echo "=== Git Configuration ==="
    git config --list
    
    echo "=== File System ==="
    ls -la
    ls -la bashscripts/
    ls -la bashscripts/lib/
```

### 3. Use Conditional Debugging

```yaml
- name: Debug mode check
  run: |
    if [ "${{ runner.debug }}" == "1" ]; then
      echo "Debug mode enabled"
      set -x
    fi
```

---

## Best Practices

### Before Running Script

```yaml
- name: Setup and verify
  run: |
    # 1. Verify all required files exist
    echo "🔍 Checking prerequisites..."
    test -f script.sh || { echo "❌ script.sh not found"; exit 1; }
    test -f lib/custom.sh || { echo "❌ custom.sh not found"; exit 1; }
    test -f config.ini || { echo "❌ config.ini not found"; exit 1; }
    echo "✅ All prerequisites found"
    
    # 2. Set up environment
    echo "🔧 Setting up environment..."
    export PROJECT_ROOT="$GITHUB_WORKSPACE"
    export PATH="$GITHUB_WORKSPACE/bin:$PATH"
    
    # 3. Make executable
    chmod +x script.sh
```

### During Execution

```yaml
- name: Run with debug
  run: |
    echo "🚀 Starting execution..."
    echo "Time: $(date)"
    echo "Directory: $(pwd)"
    
    # Run with bash -x for line-by-line output
    bash -x script.sh arg1 arg2
    
    echo "✅ Execution completed"
```

### After Execution

```yaml
- name: Verify results
  run: |
    echo "📊 Checking results..."
    
    # Check git status
    git status --short
    
    # Check for generated files
    ls -la *.log 2>/dev/null || echo "No log files"
    
    # Check exit code
    echo "Exit code: $?"
```

---

## Common Error Patterns

### Pattern 1: Library Not Loaded

**Error:**
```
script.sh: line X: function_name: command not found
```

**Fix:**
```bash
# In script.sh
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(dirname "$(dirname "$SCRIPT_DIR")")"

# Source libraries with absolute paths
source "$PROJECT_ROOT/bashscripts/lib/custom.sh"
```

### Pattern 2: Path Resolution

**Error:**
```
No such file or directory: ./config/file.ini
```

**Fix:**
```bash
# Use absolute paths
CONFIG_FILE="$PROJECT_ROOT/config/file.ini"
test -f "$CONFIG_FILE" || { echo "Config not found"; exit 1; }
```

### Pattern 3: Environment Variables

**Error:**
```
Variable not set: $MY_VAR
```

**Fix:**
```yaml
- name: Set environment
  run: |
    echo "MY_VAR=value" >> $GITHUB_ENV

- name: Use environment
  run: |
    echo "MY_VAR is: $MY_VAR"
```

---

## Workflow Template with Debugging

```yaml
name: Debug Workflow

on:
  workflow_dispatch:

jobs:
  debug:
    runs-on: ubuntu-latest
    steps:
      - name: Checkout
        uses: actions/checkout@v5
      
      - name: Debug environment
        run: |
          echo "=== Runner Info ==="
          echo "OS: $RUNNER_OS"
          echo "Temp: $RUNNER_TEMP"
          echo "Workspace: $GITHUB_WORKSPACE"
          
          echo "=== Environment Variables ==="
          env | sort
          
          echo "=== File System ==="
          ls -la
          ls -la $GITHUB_WORKSPACE
      
      - name: Test script with debug
        run: |
          set -x
          
          # Verify paths
          echo "SCRIPT_DIR: $(dirname $0)"
          echo "PWD: $PWD"
          
          # Source libraries
          source lib/custom.sh
          
          # Run function
          is_ci_context && echo "Running in CI"
          
          set +x
```

---

## Tools

### GitHub CLI

```bash
# View workflow run
gh run view <run-id>

# View logs
gh run view <run-id> --log

# Watch run in real-time
gh run watch <run-id>

# Re-run failed job
gh run rerun <run-id>
```

### Local Testing with act

```bash
# Install act
brew install act

# Run workflow locally
act workflow_dispatch

# Run with verbose output
act -v workflow_dispatch
```

---

## Resources

- [GitHub Actions Debugging](https://docs.github.com/en/actions/monitoring-and-troubleshooting-workflows/enabling-debug-logging)
- [Workflow Commands](https://docs.github.com/en/actions/using-workflows/workflow-commands-for-github-actions)
- [act - Local GitHub Actions](https://github.com/nektos/act)

---

*Last Updated: 2026-03-13*
