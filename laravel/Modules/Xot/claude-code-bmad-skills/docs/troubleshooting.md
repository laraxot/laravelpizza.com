---
layout: default
title: "BMAD Troubleshooting Guide - Common Issues and Solutions"
description: "Solutions for common BMAD Method issues. Installation problems, command errors, configuration issues, and workflow troubleshooting."
keywords: "BMAD troubleshooting, Claude Code errors, BMAD installation problems, workflow issues"
---

# Troubleshooting Guide

Solutions for common issues when using BMAD Method for Claude Code.

---

## Quick Fixes

Before diving into specific issues, try these common fixes:

1. **Restart Claude Code** - Skills load on startup
2. **Check file locations** - Ensure files are in correct directories
3. **Validate YAML** - Use a YAML linter
4. **Run /workflow-status** - See current state and recommendations

---

## Installation Issues

### Skills Not Loading

**Symptom:** BMAD skills don't activate when expected

**Causes & Fixes:**

1. **Didn't restart Claude Code**

   Skills load on startup. Close and reopen your terminal:
   ```bash
   # Close terminal, then:
   claude
   ```

2. **Skill directory structure incorrect**

   Verify installation:
   ```bash
   # Check skills directory
   ls ~/.claude/skills/bmad-skills/

   # Should see: bmad-orchestrator/, business-analyst/, product-manager/,
   #             system-architect/, scrum-master/, developer/, ux-designer/,
   #             creative-intelligence/, builder/, shared/, hooks/

   # Check each skill has SKILL.md
   find ~/.claude/skills/bmad-skills -name "SKILL.md"
   ```

3. **settings.json not found**

   Verify settings file exists:
   ```bash
   ls ~/.claude/skills/bmad-skills/settings.json
   ```

   If missing, reinstall from repository.

4. **Invalid settings.json**

   Validate JSON:
   ```bash
   cat ~/.claude/skills/bmad-skills/settings.json | python -m json.tool
   ```

   Should parse without errors.

---

## Skill Issues

### Skill Not Activating

**Symptom:** Skill doesn't trigger when you expect it to

**Causes & Fixes:**

1. **Trigger phrases not in description**

   Check SKILL.md frontmatter:
   ```yaml
   ---
   description: |
     Include trigger words like "brainstorm", "analyze", "PRD"
   ---
   ```

   Skills activate based on keywords in the description field.

2. **Skill not listed in settings.json**

   Verify skill is registered:
   ```bash
   grep "skill-name" ~/.claude/skills/bmad-skills/settings.json
   ```

   Add if missing:
   ```json
   "skills": {
     "skill-name": {
       "path": "./skill-name",
       "description": "..."
     }
   }
   ```

3. **SKILL.md file missing**

   Check file exists:
   ```bash
   ls ~/.claude/skills/bmad-skills/skill-name/SKILL.md
   ```

---

### SKILL.md Format Errors

**Symptom:** "Invalid YAML frontmatter" or skill fails to load

**Causes & Fixes:**

1. **Missing YAML frontmatter delimiters**

   Must have opening and closing `---`:
   ```yaml
   ---
   name: skill-name
   description: |
     Description here
   allowed-tools: Read, Write, Edit
   ---
   ```

2. **Invalid YAML syntax**

   Common errors:
   ```yaml
   # Wrong - missing pipe for multiline
   description: This is a
     multiline description

   # Correct
   description: |
     This is a
     multiline description
   ```

3. **Required fields missing**

   Every SKILL.md must have:
   - `name` (lowercase, hyphens, max 64 chars)
   - `description` (max 1024 chars)
   - `allowed-tools` (optional but recommended)

   Validate with:
   ```bash
   ./bmad-skills/builder/scripts/validate-skill.sh bmad-skills/skill-name/SKILL.md
   ```

---

### Token Limit Exceeded

**Symptom:** "SKILL.md exceeds 5K token limit"

**Fix:** Move detailed content to REFERENCE.md:

```markdown
<!-- SKILL.md - Keep concise -->
---
name: my-skill
description: |
  Brief description
---

# My Skill

## Quick Reference

Brief instructions...

For detailed information, see REFERENCE.md.
```

```markdown
<!-- REFERENCE.md - Detailed docs -->
# My Skill Reference

## Detailed Workflows
...
```

Check token count:
```bash
# Estimate: ~4 chars = 1 token
wc -c bmad-skills/skill-name/SKILL.md
# Should be under ~20,000 chars
```

---

## Hook Issues

### SessionStart Hook Not Running

**Symptom:** Environment variables not set (BMAD_PROJECT, BMAD_OUTPUT_FOLDER)

**Causes & Fixes:**

1. **Hook file not executable**

   Fix permissions:
   ```bash
   chmod +x ~/.claude/skills/bmad-skills/hooks/bmad-session-start.sh
   ```

2. **Hook not registered in settings.json**

   Verify:
   ```bash
   grep -A5 "SessionStart" ~/.claude/skills/bmad-skills/settings.json
   ```

   Should show:
   ```json
   "SessionStart": [
     {
       "type": "command",
       "command": "bash $SKILL_DIR/hooks/bmad-session-start.sh"
     }
   ],
   "PreToolUse": [
     {
       "matcher": "",
       "hooks": [
         {
           "type": "command",
           "command": "bash $SKILL_DIR/hooks/bmad-pre-tool.sh"
         }
       ]
     }
   ]
   ```

3. **Hook script has errors**

   Test manually:
   ```bash
   cd your-project
   bash ~/.claude/skills/bmad-skills/hooks/bmad-session-start.sh
   ```

   Check for error messages.

---

### PreToolUse/PostToolUse Hook Errors

**Symptom:** Errors when using tools, or tracking messages not appearing

**Causes & Fixes:**

1. **Missing jq dependency**

   Hooks use `jq` to parse JSON:
   ```bash
   # Install jq
   # macOS
   brew install jq

   # Ubuntu/Debian
   sudo apt-get install jq

   # Windows (WSL)
   sudo apt-get install jq
   ```

2. **Hook permissions**

   Make executable:
   ```bash
   chmod +x ~/.claude/skills/bmad-skills/hooks/bmad-pre-tool.sh
   chmod +x ~/.claude/skills/bmad-skills/hooks/bmad-post-tool.sh
   ```

3. **Hook fails silently**

   Hooks always exit 0 to not block tool execution. Check logs:
   ```bash
   # Enable verbose logging in Claude Code settings
   # Look for hook output in session logs
   ```

---

### Hook File Permissions

**Symptom:** "Permission denied" when hooks try to execute

**Fix:** Set correct permissions on all hook files:
```bash
chmod +x ~/.claude/skills/bmad-skills/hooks/*.sh
```

Verify:
```bash
ls -la ~/.claude/skills/bmad-skills/hooks/
# All .sh files should have 'x' permission
```

---

## Subagent Issues

### Parallel Agents Not Launching

**Symptom:** Workflows run sequentially instead of in parallel

**Causes & Fixes:**

1. **Task tool not using run_in_background**

   Verify subagent launch pattern:
   ```
   # Wrong - sequential
   Task: Analyze feature A
   Task: Analyze feature B

   # Correct - parallel
   Task: Analyze feature A, run_in_background: true
   Task: Analyze feature B, run_in_background: true
   ```

2. **Context directory missing**

   Create bmad/context/ for subagent coordination:
   ```bash
   mkdir -p bmad/context
   ```

3. **Skill instructions don't specify parallel execution**

   Check SKILL.md has subagent strategy section:
   ```markdown
   ## Subagent Strategy

   This workflow uses 3 parallel agents:
   - Agent 1: Task A
   - Agent 2: Task B
   - Agent 3: Task C
   ```

---

### Context File Not Found

**Symptom:** "Cannot read bmad/context/task-brief.md"

**Causes & Fixes:**

1. **bmad/context/ directory missing**

   Create directory:
   ```bash
   mkdir -p bmad/context
   ```

2. **Context not written before subagents launched**

   Verify orchestrator writes context first:
   ```bash
   ls -lt bmad/context/
   # Should see recent files
   ```

3. **Permission issues**

   Fix permissions:
   ```bash
   chmod 755 bmad/context
   chmod 644 bmad/context/*
   ```

---

### Agent Output Collection Failures

**Symptom:** Main agent can't find subagent outputs

**Causes & Fixes:**

1. **bmad/outputs/ directory missing**

   Create directory:
   ```bash
   mkdir -p bmad/outputs
   ```

2. **Subagents didn't write output files**

   Check subagent instructions include output step:
   ```markdown
   ## Subagent Task

   1. Analyze...
   2. Write results to bmad/outputs/agent-{N}-results.md
   ```

3. **Timing issue - synthesis ran too early**

   Verify main agent waits for all subagents:
   ```bash
   # Check file timestamps
   ls -lt bmad/outputs/
   # All files should exist before synthesis
   ```

---

### Agent Timeout Issues

**Symptom:** Subagents don't complete in time

**Fixes:**

1. **Reduce workload per agent**

   Split into more smaller tasks instead of fewer large tasks.

2. **Increase timeout in Task tool**

   ```
   Task: ..., timeout: 300000  # 5 minutes
   ```

3. **Check agent is still running**

   Look for background processes:
   ```bash
   # If Claude provides process info
   # Check status of background tasks
   ```

---

## Context/Output Issues

### bmad/context/ Directory Permissions

**Symptom:** "Permission denied" when writing to context directory

**Fix:** Set correct permissions:
```bash
chmod 755 bmad
chmod 755 bmad/context
chmod 644 bmad/context/*
```

Verify:
```bash
ls -la bmad/
# drwxr-xr-x  context/
```

---

### bmad/outputs/ Files Not Being Created

**Symptom:** Subagent outputs missing

**Causes & Fixes:**

1. **Directory doesn't exist**

   Create it:
   ```bash
   mkdir -p bmad/outputs
   ```

2. **Subagent instructions unclear**

   Verify skill's subagent template specifies output location:
   ```markdown
   Write your analysis to: bmad/outputs/agent-{N}-results.md
   ```

3. **File path typo in subagent prompt**

   Check exact path in subagent instructions matches:
   ```bash
   # Subagent should write to:
   bmad/outputs/agent-1-analysis.md
   # Not:
   bmad/output/agent-1-analysis.md  # Wrong
   outputs/agent-1-analysis.md       # Wrong
   ```

---

### Result Synthesis Failures

**Symptom:** Main agent fails to combine subagent outputs

**Causes & Fixes:**

1. **Output files have inconsistent format**

   Standardize output structure in subagent prompts:
   ```markdown
   ## Subagent Output Format

   ```yaml
   task: "Feature Analysis"
   findings:
     - ...
   ```

2. **Some outputs missing**

   Check all expected files exist:
   ```bash
   ls bmad/outputs/
   # Should see: agent-1-*.md, agent-2-*.md, agent-3-*.md
   ```

3. **Outputs too large to process**

   Limit output size in subagent instructions:
   ```markdown
   Keep your output under 2000 tokens (summary only).
   ```

---

## Command Errors

### "Project not initialized"

**Symptom:** Commands fail with "run /workflow-init first"

**Fix:** Initialize BMAD in your project:
```
/workflow-init
```

This creates `bmad/config.yaml` in your project root.

---

### "Cannot find product-brief.md"

**Symptom:** `/prd` fails because it can't find the product brief

**Causes & Fixes:**

1. **Product brief not created**

   Create it first:
   ```
   /product-brief
   ```

2. **Product brief in wrong location**

   Check your output folder:
   ```yaml
   # bmad/config.yaml
   output_folder: "docs"  # Product brief should be here
   ```

   Move file if needed:
   ```bash
   mv product-brief.md docs/product-brief.md
   ```

3. **Different output folder than expected**

   Check where BMAD is looking:
   ```
   /workflow-status
   ```

   This shows the expected file paths.

---

### "Cannot find architecture.md"

**Symptom:** `/sprint-planning` fails because architecture is missing

**Fix:** Create architecture first:
```
/architecture
```

Or if you're Level 0-1, you don't need architecture. Check your project level:
```yaml
# bmad/config.yaml
project_level: 1  # No architecture needed
```

---

### YAML Parse Errors

**Symptom:** "YAML parse error" or "invalid syntax"

**Common causes:**

1. **Bad indentation**
   ```yaml
   # Wrong
   bmm:
   workflow_status_file: "docs/status.yaml"

   # Correct
   bmm:
     workflow_status_file: "docs/status.yaml"
   ```

2. **Unquoted special characters**
   ```yaml
   # Wrong
   project_name: My Project: v2

   # Correct
   project_name: "My Project: v2"
   ```

3. **Tabs instead of spaces**
   ```yaml
   # Wrong (tabs)
   bmm:
   	workflow_status_file: "..."

   # Correct (2 spaces)
   bmm:
     workflow_status_file: "..."
   ```

**Fix:** Validate your YAML:
```bash
# Online validator
# https://yamlvalidator.com

# Or use yamllint
pip install yamllint
yamllint bmad/config.yaml
```

---

## Workflow Issues

### Wrong Workflow Recommended

**Symptom:** `/workflow-status` recommends the wrong next step

**Causes & Fixes:**

1. **Project level incorrect**

   Level affects what's required:
   ```yaml
   # bmad/config.yaml
   project_level: 2  # Requires PRD, architecture
   project_level: 1  # Only tech spec needed
   ```

2. **Status file out of sync**

   Manually check status:
   ```bash
   cat docs/bmm-workflow-status.yaml
   ```

   Update if needed:
   ```yaml
   workflows:
     - name: "Product Brief"
       status: "complete"
       file: "docs/product-brief.md"
   ```

---

### Documents Not Saving

**Symptom:** Command completes but file not created

**Causes & Fixes:**

1. **Output directory doesn't exist**
   ```bash
   mkdir -p docs/stories
   ```

2. **Permission issues**
   ```bash
   chmod 755 docs
   ```

3. **Incorrect output_folder**
   ```yaml
   # bmad/config.yaml
   output_folder: "docs"  # Must exist
   ```

---

### Sprint Planning Shows Wrong Stories

**Symptom:** Sprint plan doesn't match PRD stories

**Fix:** Regenerate sprint plan:
```
/sprint-planning
```

Or manually sync `docs/sprint-status.yaml` with your PRD.

---

### /dev-story Can't Find Story

**Symptom:** `/dev-story STORY-001` says story doesn't exist

**Causes & Fixes:**

1. **Story file not created**

   Run sprint planning first:
   ```
   /sprint-planning
   ```

2. **Wrong story ID format**
   ```
   # Wrong
   /dev-story Story-001
   /dev-story story-001

   # Correct
   /dev-story STORY-001
   ```

3. **Story in wrong directory**

   Check paths:
   ```yaml
   # bmad/config.yaml
   paths:
     stories: "docs/stories"  # Stories should be here
   ```

---

## Configuration Issues

### Skills Not Applying Expected Behavior

**Symptom:** BMAD settings or behavior not matching config

**Causes & Fixes:**

1. **Project config not found**

   BMAD reads `bmad/config.yaml` in the project root. Verify it exists:
   ```bash
   cat bmad/config.yaml
   ```

2. **Didn't restart Claude Code**

   Skills and hooks load on startup. Close and reopen your terminal.

3. **Wrong project directory**

   Run Claude Code from the directory that contains `bmad/config.yaml`.

---

### Skill Not Activating

**Symptom:** `/brainstorm`, `/research`, or other commands aren't recognized

**Causes & Fixes:**

1. **Skills not installed**

   Verify all skills are present:
   ```bash
   ls ~/.claude/skills/bmad-skills/
   # Should see: bmad-orchestrator/ business-analyst/ creative-intelligence/ ...
   ```

2. **Trigger phrase not matching description**

   Skills activate when your phrase matches keywords in the `description` field of `SKILL.md`. Try more explicit phrases like "create a product brief" or "brainstorm using SCAMPER".

3. **Didn't restart after install**

   Skills load on startup — always restart Claude Code after installing or updating skills.

---

### Custom Skills Not Loading

**Symptom:** Created skill with `/create-agent` but can't use it

**Causes & Fixes:**

1. **Didn't restart Claude Code**

   Skills load on startup.

2. **Skill in wrong directory**
   ```bash
   # Should be in:
   ls ~/.claude/skills/bmad-skills/custom-skill-name/SKILL.md
   ```

3. **Invalid SKILL.md frontmatter**

   Check that SKILL.md has required YAML frontmatter:
   ```yaml
   ---
   name: skill-name
   description: |
     What it does and when to use it.
   allowed-tools: Read, Write, Edit, Bash, Glob, Grep, TodoWrite
   ---
   ```

---

## Performance Issues

### Commands Running Slowly

**Symptom:** Commands take longer than expected

**Causes & Fixes:**

1. **Large context**

   BMAD loads previous documents. Reduce by:
   - Using lower project level
   - Splitting large documents

2. **Skill loading too much context**

   If skills are loading large reference files, reduce by breaking documents up or using `Explore` subagents (Haiku-based) for codebase queries instead of full context loads.

---

### Claude Code Hanging

**Symptom:** Claude Code stops responding during command

**Fixes:**

1. Press Ctrl+C to cancel
2. Check for infinite loops in custom agents
3. Reduce document size
4. Restart Claude Code

---

## Platform-Specific Issues

### Windows Path Issues

**Symptom:** Files not found on Windows

**Fix:** Use forward slashes in config:
```yaml
# Works on all platforms
output_folder: "docs"
workflow_status_file: "docs/status.yaml"

# Not this
output_folder: "docs\\"
workflow_status_file: "docs\\status.yaml"
```

---

### WSL Issues

**Symptom:** Commands work in Linux but not WSL

**Causes & Fixes:**

1. **Using Windows Claude Code for WSL project**

   Install Claude Code inside WSL:
   ```bash
   # Inside WSL
   curl -fsSL https://claude.ai/code/install | bash
   ```

2. **File permission issues**
   ```bash
   chmod -R 755 ~/.claude/
   ```

3. **Line ending issues**
   ```bash
   # Convert if needed
   find ~/.claude/skills/bmad-skills -name "*.sh" -exec sed -i 's/\r$//' {} \;
   ```

---

### macOS Issues

**Symptom:** "Operation not permitted" errors

**Fix:** Allow terminal full disk access:
1. System Preferences → Security & Privacy → Privacy
2. Full Disk Access
3. Add your terminal app

---

## Common Error Messages

### "No active project found"

**Meaning:** BMAD can't find `bmad/config.yaml`

**Fix:**
```
/workflow-init
```

Or ensure you're in the project root directory.

---

### "Workflow status file not found"

**Meaning:** `docs/bmm-workflow-status.yaml` doesn't exist

**Fix:** Create by running any workflow command, or manually:
```bash
touch docs/bmm-workflow-status.yaml
```

---

### "Invalid project level"

**Meaning:** Level must be 0-4

**Fix:**
```yaml
# bmad/config.yaml
project_level: 2  # Must be 0, 1, 2, 3, or 4
```

---

### "Template not found"

**Meaning:** Missing template file in skill directory

**Fix:** Reinstall BMAD skills from the repository:
```bash
cd /path/to/claude-code-bmad-skills
git pull origin main
rm -rf ~/.claude/skills/bmad-skills
cp -r bmad-skills ~/.claude/skills/bmad-skills
find ~/.claude/skills/bmad-skills -name "*.sh" -exec chmod +x {} \;
```

---

### "Helper reference not found"

**Meaning:** Skill references `shared/helpers.md` but it's missing

**Fix:** Reinstall to get latest shared helpers:
```bash
cd /path/to/claude-code-bmad-skills
cp -r bmad-skills ~/.claude/skills/bmad-skills
```

---

## Debugging Tips

### Check if Skill Loaded

**Verify skill is available:**

```bash
# Check skill directory structure
ls -la ~/.claude/skills/bmad-skills/skill-name/

# Should see:
# SKILL.md (required)
# REFERENCE.md (optional)
# scripts/ (optional)
# templates/ (optional)

# Validate SKILL.md format
head -20 ~/.claude/skills/bmad-skills/skill-name/SKILL.md

# Should start with:
# ---
# name: skill-name
# description: |
#   ...
# ---
```

**Check settings.json registration:**

```bash
cat ~/.claude/skills/bmad-skills/settings.json | grep -A3 "skill-name"

# Should show:
# "skill-name": {
#   "path": "./skill-name",
#   "description": "..."
# }
```

---

### Verify Hook Execution

**Test SessionStart hook:**

```bash
# Manual test
cd your-project
CLAUDE_ENV_FILE=/tmp/test-env.txt bash ~/.claude/skills/bmad-skills/hooks/bmad-session-start.sh

# Check output
cat /tmp/test-env.txt

# Should contain:
# export BMAD_PROJECT=true
# export BMAD_PROJECT_NAME="..."
# export BMAD_OUTPUT_FOLDER="docs"
```

**Test PreToolUse hook:**

```bash
# Manual test
export CLAUDE_TOOL_NAME="Write"
export CLAUDE_TOOL_INPUT='{"file_path": "/path/to/docs/file.md"}'
bash ~/.claude/skills/bmad-skills/hooks/bmad-pre-tool.sh

# Should output:
# BMAD: Writing to BMAD-managed path: /path/to/docs/file.md
```

**Test PostToolUse hook:**

```bash
# Manual test
export CLAUDE_TOOL_NAME="Write"
export CLAUDE_TOOL_INPUT='{"file_path": "/path/to/product-brief.md"}'
bash ~/.claude/skills/bmad-skills/hooks/bmad-post-tool.sh

# Should output:
# BMAD: Product Brief created - Phase 1 (Analysis) progress
```

**Check hook dependencies:**

```bash
# Verify jq is installed
which jq
jq --version

# If missing, install:
# macOS: brew install jq
# Linux: sudo apt-get install jq
```

---

### Monitor Subagent Progress

**Track subagent launches:**

When skills launch parallel agents, monitor the process:

```bash
# Watch context directory for new files
watch -n 1 'ls -lt bmad/context/ | head -10'

# Watch outputs directory
watch -n 1 'ls -lt bmad/outputs/ | head -10'

# Check file sizes (growing = agent working)
watch -n 2 'du -sh bmad/outputs/*'
```

**Verify subagent task completion:**

```bash
# All expected outputs should exist
ls bmad/outputs/

# Example for 3-agent workflow:
# agent-1-analysis.md
# agent-2-analysis.md
# agent-3-analysis.md

# Check if files have content
wc -l bmad/outputs/*.md

# Each should have > 0 lines
```

**Debug subagent coordination:**

```bash
# View context shared with subagents
cat bmad/context/task-brief.md

# Check timestamps - context should be written BEFORE outputs
stat bmad/context/task-brief.md
stat bmad/outputs/agent-1-*.md

# Context file should be older (written first)
```

---

### Enable Hook Debugging

To trace hook execution, test hooks manually from your project directory:

```bash
# Test SessionStart hook
cd your-project
bash ~/.claude/skills/bmad-skills/hooks/bmad-session-start.sh

# Test PreToolUse hook
export CLAUDE_TOOL_NAME="Write"
export CLAUDE_TOOL_INPUT='{"file_path": "/path/to/docs/file.md"}'
bash ~/.claude/skills/bmad-skills/hooks/bmad-pre-tool.sh

# Test PostToolUse hook
export CLAUDE_TOOL_INPUT='{"file_path": "/path/to/product-brief.md"}'
bash ~/.claude/skills/bmad-skills/hooks/bmad-post-tool.sh
```

To trace subagent coordination, watch the output directories:

```bash
watch -n 1 'ls -lt bmad/outputs/'
```

---

### Check File Contents

```bash
# View configs
cat ~/.claude/skills/bmad-skills/settings.json
cat bmad/config.yaml

# View status
cat docs/bmm-workflow-status.yaml

# Check hooks are executable
ls -la ~/.claude/skills/bmad-skills/hooks/
```

---

### Validate All YAML Files

```bash
# Install yamllint
pip install yamllint

# Check all YAML in project
find . -name "*.yaml" -exec yamllint {} \;

# Check SKILL.md frontmatter
for skill in ~/.claude/skills/bmad-skills/*/SKILL.md; do
  echo "Checking $skill"
  head -20 "$skill" | yamllint -
done
```

---

### Test Skill Activation

Test if skills activate with trigger phrases:

```bash
# Start Claude Code
claude

# Try triggering specific skills:
# bmad-orchestrator triggers:
"Initialize BMAD for this project"
"What's the project status?"
"What should I do next?"

# business-analyst triggers:
"Create a product brief"
"Let's brainstorm features"
"Analyze user needs"

# product-manager triggers:
"Create a PRD"
"Write technical spec"
"Prioritize features"

# Check Claude's response mentions the skill activated
```

---

### Verify Script Permissions

All scripts in skills must be executable:

```bash
# Check all scripts
find ~/.claude/skills/bmad-skills -name "*.sh" -o -name "*.py" | xargs ls -la

# Make all scripts executable
find ~/.claude/skills/bmad-skills -name "*.sh" -exec chmod +x {} \;
find ~/.claude/skills/bmad-skills -name "*.py" -exec chmod +x {} \;

# Verify hooks specifically
ls -la ~/.claude/skills/bmad-skills/hooks/
# All .sh files should have -rwxr-xr-x permissions
```

---

### Reset Project State

If things are broken, start fresh:
```bash
# Backup your docs
cp -r docs docs.bak
cp -r bmad bmad.bak

# Remove BMAD state
rm -rf bmad/context/*
rm -rf bmad/outputs/*
rm bmad/config.yaml

# Keep docs but reset status
rm docs/bmm-workflow-status.yaml
rm docs/sprint-status.yaml

# Re-initialize
# In Claude Code:
/workflow-init
```

---

### Reinstall Skills

If skills are corrupted or missing:

```bash
# Navigate to repository
cd /path/to/claude-code-bmad-skills

# Pull latest changes
git pull origin main

# Remove old installation
rm -rf ~/.claude/skills/bmad-skills

# Copy skills package (preserves bmad-skills/ subfolder)
cp -r bmad-skills ~/.claude/skills/bmad-skills

# Set permissions
find ~/.claude/skills/bmad-skills -name "*.sh" -exec chmod +x {} \;
find ~/.claude/skills/bmad-skills -name "*.py" -exec chmod +x {} \;

# Restart Claude Code
```

---

## Getting Help

### Check Documentation

- [Getting Started](./getting-started) - Installation and first steps
- [Skills Reference](./skills/) - All BMAD skills documentation
- [Configuration](./configuration) - All config options
- [Subagent Patterns](./subagent-patterns) - Parallel execution architecture

### Report Issues

If you've tried the fixes above and still have problems:

1. **GitHub Issues:** [github.com/aj-geddes/claude-code-bmad-skills/issues](https://github.com/aj-geddes/claude-code-bmad-skills/issues)

2. **Include in your report:**
   - BMAD Skills version (check git commit in repository)
   - Operating system and version
   - Claude Code version
   - Error message (full text)
   - Steps to reproduce
   - Relevant config files (bmad/config.yaml, settings.json)
   - Skill that was active when error occurred

### Example Issue Report

```markdown
**Environment:**
- BMAD Skills: main branch (commit: abc1234)
- OS: macOS 14.0 (Sonoma)
- Claude Code: 1.2.0

**Issue:**
business-analyst skill not activating with "Create product brief"

**Steps:**
1. Initialized BMAD project
2. Said "Create a product brief for my app"
3. Skill didn't activate, generic response given

**Skill Status:**
- SKILL.md exists: Yes
- Registered in settings.json: Yes
- Restarted Claude Code: Yes

**Config Files:**
bmad/config.yaml:
```yaml
project_name: "My App"
project_level: 2
output_folder: "docs"
```

**Debug Output:**
```bash
$ ls ~/.claude/skills/bmad-skills/business-analyst/SKILL.md
SKILL.md exists
$ grep "business-analyst" ~/.claude/skills/bmad-skills/settings.json
Found in settings.json
```
```

### Common Misunderstandings

**"Why isn't my skill activating?"**

Skills activate based on keywords in the `description` field of SKILL.md frontmatter. Make sure your description includes the trigger words users would naturally say.

**"Do I need to reinstall after git pull?"**

Yes. After pulling updates:
```bash
cd claude-code-bmad-skills
rm -rf ~/.claude/skills/bmad-skills
cp -r bmad-skills ~/.claude/skills/
find ~/.claude/skills/bmad-skills -name "*.sh" -exec chmod +x {} \;
# Restart Claude Code
```

**"Can I modify skills?"**

Yes! Edit files in `~/.claude/skills/bmad-skills/` or better yet, edit in the repository and reinstall. See the [builder skill](https://github.com/aj-geddes/claude-code-bmad-skills/tree/main/bmad-skills/builder) for creating custom skills.

**"How do I know which skill is active?"**

Claude will typically mention which skill or phase it's using. You can also check the PostToolUse hook output which logs phase progress.

---

## Quick Reference Card

Print this for quick troubleshooting:

| Issue | Quick Fix |
|-------|-----------|
| Skill not loading | `ls ~/.claude/skills/bmad-skills/skill-name/SKILL.md` |
| Hook not running | `chmod +x ~/.claude/skills/bmad-skills/hooks/*.sh` |
| Missing jq | `brew install jq` or `sudo apt-get install jq` |
| Subagents not parallel | Add `run_in_background: true` to Task calls |
| Context files missing | `mkdir -p bmad/context bmad/outputs` |
| YAML errors | `yamllint bmad/config.yaml` |
| Skills corrupted | Delete `~/.claude/skills/bmad-skills`, reinstall |
| Restart needed | Close terminal, reopen Claude Code |

---

## Advanced Troubleshooting

### Inspect Skill Load Order

Claude Code loads skills alphabetically. Check order:
```bash
ls -1 ~/.claude/skills/bmad-skills/
```

All skills load simultaneously, so order usually doesn't matter.

### Check Environment Variables

In a BMAD project session:
```bash
# If hooks are working, these should be set:
echo $BMAD_PROJECT          # true or false
echo $BMAD_PROJECT_NAME     # Your project name
echo $BMAD_PROJECT_LEVEL    # 0-4
echo $BMAD_OUTPUT_FOLDER    # Usually "docs"
echo $BMAD_SESSION_START    # ISO timestamp
```

### Trace Subagent Execution

Add debug output to subagent prompts:
```markdown
## Agent Task

1. Write "Starting task" to bmad/outputs/agent-1-start.txt
2. [Do actual work]
3. Write results to bmad/outputs/agent-1-results.md
4. Write "Completed" to bmad/outputs/agent-1-done.txt
```

Then monitor:
```bash
watch -n 1 'ls -lt bmad/outputs/'
```

### Performance Profiling

Track execution time:
```bash
# Before running workflow
date +%s > /tmp/start-time

# After completion
echo "Duration: $(($(date +%s) - $(cat /tmp/start-time))) seconds"
```

For subagent workflows, compare parallel vs sequential:
- Parallel: All agents finish at roughly the same time
- Sequential: Total time = sum of all agent times
