# NotebookLM Skill Integration Guide

**Status**: ✅ Installed  
**Location**: `~/.claude/skills/notebooklm/`  
**Version**: Latest (master branch)  
**Integrated**: 2026-03-30

## Overview

NotebookLM Skill enables **source-grounded research** directly from Google NotebookLM notebooks. Perfect for:

- **Technical documentation** queries
- **Project-specific knowledge** bases
- **Reduced hallucinations** (answers only from uploaded docs)
- **Citation-backed responses** from Gemini

## Integration with BMAD + GSD + Ralph Loop

### Workflow Enhancement

```
BMAD (Requirements & Architecture)
    ↓
├─ Research with NotebookLM
│  └─ Query technical docs
│  └─ Verify architecture patterns
│  └─ Get citation-backed answers
    ↓
GSD (Planning & Execution)
    ↓
├─ Plan with NotebookLM context
│  └─ Reference uploaded specs
│  └─ Check implementation details
    ↓
Ralph Loop (Implementation)
    ↓
├─ Implement with NotebookLM verification
│  └─ Verify code against docs
│  └─ Check API references
    ↓
OpenViking (Context Preservation)
    ↓
└─ Store NotebookLM insights
```

## Installation Status

### ✅ Already Installed

```bash
Location: ~/.claude/skills/notebooklm/
Status: Up to date (master branch)
Dependencies: Auto-managed (.venv)
```

### Verification

```bash
# Check installation
ls -la ~/.claude/skills/notebooklm/

# Should show:
# - SKILL.md (main documentation)
# - scripts/ (automation scripts)
# - data/ (auth + library)
# - requirements.txt
```

## Quick Start

### 1. Check Authentication

```bash
cd ~/.claude/skills/notebooklm
python scripts/run.py auth_manager.py status
```

### 2. Authenticate (One-Time)

```bash
# Browser will open for Google login
python scripts/run.py auth_manager.py setup
```

**Important**: Browser is VISIBLE for manual Google login.

### 3. Add Notebook to Library

**Smart Add** (Recommended):
```bash
# Query notebook to discover content
python scripts/run.py ask_question.py \
  --question "What is the content of this notebook? Provide overview" \
  --notebook-url "https://notebooklm.google.com/notebook/YOUR-ID"

# Then add with discovered info
python scripts/run.py notebook_manager.py add \
  --url "https://notebooklm.google.com/notebook/YOUR-ID" \
  --name "Discovered Name" \
  --description "From discovered content" \
  --topics "topic1,topic2"
```

### 4. Query Notebook

```bash
# List notebooks
python scripts/run.py notebook_manager.py list

# Ask question
python scripts/run.py ask_question.py \
  --question "What does the docs say about [topic]?"
```

## Usage Patterns for FixCity Project

### Pattern 1: Technical Research (BMAD Phase)

```bash
# Research Laravel patterns
python scripts/run.py ask_question.py \
  --question "What are Laravel 12 best practices for service architecture?"

# Research Filament v5
python scripts/run.py ask_question.py \
  --question "How to create Filament v5 resources with XotBase extension?"

# Research PHPStan Level 10
python scripts/run.py ask_question.py \
  --question "What are PHPStan Level 10 requirements for traits?"
```

### Pattern 2: Implementation Verification (GSD Phase)

```bash
# Verify implementation approach
python scripts/run.py ask_question.py \
  --question "Check the Laraxot documentation: should I use Actions or Services?"

# Verify code patterns
python scripts/run.py ask_question.py \
  --question "What is the correct pattern for Filament table actions?"
```

### Pattern 3: Documentation Lookup (Ralph Loop)

```bash
# Quick reference during implementation
python scripts/run.py ask_question.py \
  --question "What is the container0/slug0 pattern in Laraxot?"

# API reference
python scripts/run.py ask_question.py \
  --question "How to use Spatie QueueableAction with Laravel?"
```

## Integration with OpenViking

### Store NotebookLM Insights

```bash
# After getting NotebookLM answer
openviking add-memory \
  --title="Technical Research: [Topic]" \
  --content="[NotebookLM answer with citations]"

# Link to project context
openviking add-memory \
  --title="Architecture Decision: [Decision]" \
  --content="Based on NotebookLM research: [answer]"
```

### Workflow Example

```bash
# 1. Research with NotebookLM
python scripts/run.py ask_question.py \
  --question "What are best practices for Laravel module architecture?"

# 2. Store in OpenViking
openviking add-memory \
  --title="Module Architecture Best Practices" \
  --content="[NotebookLM answer]"

# 3. Use in BMAD PRD
# Reference in PRD:
# "Based on research: viking://memory/module-architecture-best-practices"
```

## Advanced Usage

### Multi-Source Correlation

```bash
# Query multiple notebooks
python scripts/run.py ask_question.py \
  --question "Compare Laravel 11 vs Laravel 12 architecture changes" \
  --notebook-id "laravel-11-docs" \
  --notebook-id "laravel-12-docs"
```

### Follow-Up Mechanism

**CRITICAL**: Every NotebookLM answer ends with "Is that ALL you need to know?"

**Required Workflow**:
1. **STOP** - Don't respond immediately
2. **ANALYZE** - Check if answer is complete
3. **ASK FOLLOW-UP** - If gaps exist:
   ```bash
   python scripts/run.py ask_question.py \
     --question "Follow-up: [specific gap] with context from previous answer"
   ```
4. **REPEAT** - Until complete
5. **SYNTHESIZE** - Combine all answers

### Smart Library Management

```bash
# Search notebooks by topic
python scripts/run.py notebook_manager.py search \
  --query "Laravel architecture"

# Activate specific notebook
python scripts/run.py notebook_manager.py activate \
  --id "laraxot-docs"

# View library stats
python scripts/run.py notebook_manager.py stats
```

## Configuration for FixCity

### Recommended Notebooks

Create these NotebookLM notebooks for FixCity:

1. **Laraxot Framework Docs**
   - Upload: Laraxot documentation
   - Topics: laravel, architecture, modules, filament
   - Use: Technical research, implementation verification

2. **PHP Best Practices**
   - Upload: PHP 8.3+, PSR standards, SOLID principles
   - Topics: php, patterns, quality, testing
   - Use: Code quality, architecture decisions

3. **Filament v5 Documentation**
   - Upload: Filament docs, examples
   - Topics: filament, admin, resources, forms
   - Use: Admin panel development

4. **Project Documentation**
   - Upload: FixCity docs, AGENTS.md, .windsurfrules
   - Topics: fixcity, project, conventions
   - Use: Project-specific queries

### Environment Configuration

Create `~/.claude/skills/notebooklm/.env`:

```bash
# Browser configuration
HEADLESS=false           # Show browser for debugging
SHOW_BROWSER=false       # Default: hidden for queries
STEALTH_ENABLED=true     # Human-like behavior

# Typing speed (human-like)
TYPING_WPM_MIN=160
TYPING_WPM_MAX=240

# Default notebook (FixCity docs)
DEFAULT_NOTEBOOK_ID=fixcity-project-docs
```

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Not authenticated | `python scripts/run.py auth_manager.py setup` |
| Module not found | Always use `run.py` wrapper |
| Rate limit (50/day) | Wait or use different Google account |
| Browser crashes | `python scripts/run.py cleanup_manager.py --preserve-library` |
| Notebook not found | Check with `notebook_manager.py list` |

## Best Practices

### 1. Always Use run.py Wrapper

```bash
# ✅ CORRECT
python scripts/run.py ask_question.py --question "..."

# ❌ WRONG
python scripts/ask_question.py --question "..."  # Fails without venv!
```

### 2. Follow-Up Questions

```bash
# Don't stop at first answer
# If answer incomplete:
python scripts/run.py ask_question.py \
  --question "Follow-up: [specific aspect] considering [previous context]"
```

### 3. Include Context

```bash
# Each question is independent
# Always include full context:
python scripts/run.py ask_question.py \
  --question "In Laraxot framework, how to create Filament resources with XotBase extension?"
```

### 4. Synthesize Answers

```bash
# After multiple follow-ups:
# 1. Combine all answers
# 2. Remove duplicates
# 3. Present unified response
```

## Integration Examples

### Example 1: BMAD PRD Creation

```bash
# Step 1: Research requirements pattern
python scripts/run.py ask_question.py \
  --question "What are best practices for PRD creation in BMAD methodology?"

# Step 2: Research architecture patterns
python scripts/run.py ask_question.py \
  --question "How to create architecture documentation for Laravel modules?"

# Step 3: Store in OpenViking
openviking add-memory \
  --title="BMAD PRD Best Practices" \
  --content="[Synthesized NotebookLM answer]"

# Step 4: Create PRD
/bmad-create-prd
# Reference: "Based on research: viking://memory/bmad-prd-best-practices"
```

### Example 2: GSD Phase Planning

```bash
# Step 1: Research implementation approach
python scripts/run.py ask_question.py \
  --question "What is the best approach for implementing Filament v5 resources?"

# Step 2: Verify with project docs
python scripts/run.py ask_question.py \
  --question "Check FixCity project docs: what are the rules for Filament resources?"

# Step 3: Plan phase
/gsd-plan-phase 1
# Reference: "Based on NotebookLM research + project rules"
```

### Example 3: Ralph Loop Implementation

```bash
# Step 1: Quick reference during implementation
python scripts/run.py ask_question.py \
  --question "How to extend XotBaseResource in Filament v5?"

# Step 2: Verify implementation
python scripts/run.py ask_question.py \
  --question "Check: should getHeaderActions() return array with string keys?"

# Step 3: Update Ralph PRD
# Add verified information to .ralph/prd.json
```

## Resources

- **Skill Location**: `~/.claude/skills/notebooklm/`
- **Documentation**: `~/.claude/skills/notebooklm/SKILL.md`
- **Scripts**: `~/.claude/skills/notebooklm/scripts/`
- **Data**: `~/.claude/skills/notebooklm/data/`
- **References**: `~/.claude/skills/notebooklm/references/`

## Next Steps

1. ✅ Skill installed and verified
2. ⏳ Authenticate with Google account
3. ⏳ Create FixCity NotebookLM notebooks
4. ⏳ Upload project documentation
5. ⏳ Integrate with BMAD workflow
6. ⏳ Store insights in OpenViking

---

**Last Updated**: 2026-03-30  
**Status**: Ready for authentication and notebook creation
