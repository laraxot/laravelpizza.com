# NotebookLM Skill - Installation & Integration Summary

**Date**: 2026-03-30  
**Status**: ✅ Installed & Integrated  
**Workflow**: BMAD + GSD + Ralph + OpenViking + NotebookLM

## Installation Summary

### ✅ Already Installed

```bash
Location: ~/.claude/skills/notebooklm/
Branch: master (up to date)
Dependencies: Auto-managed (.venv)
Status: Ready for use
```

### Verification

```bash
# Check installation
ls -la ~/.claude/skills/notebooklm/

# Output shows:
# - SKILL.md (main documentation)
# - scripts/ (automation scripts)
# - data/ (authentication + library)
# - requirements.txt
# - README.md, CHANGELOG.md, LICENSE
```

## What is NotebookLM Skill?

**Google NotebookLM integration for Claude Code** that provides:

- ✅ **Source-grounded answers** - Only from uploaded documents
- ✅ **Citation-backed responses** - From Gemini AI
- ✅ **Browser automation** - Query NotebookLM programmatically
- ✅ **Library management** - Save and organize notebooks
- ✅ **Persistent authentication** - One-time Google login
- ✅ **Reduced hallucinations** - Document-only responses

**Key Benefit**: Eliminates copy-paste between NotebookLM browser and editor. Claude asks questions directly and receives answers in CLI.

## Integration with Existing Workflow

### Complete AI Tool Stack

```
┌─────────────────────────────────────────────────────────┐
│              AI Tool Stack - FixCity                    │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  📚 NotebookLM Skill                                    │
│     - Source-grounded research                          │
│     - Technical documentation queries                   │
│     - Citation-backed answers                           │
│                                                          │
│  🧠 BMAD                                                │
│     - Requirements (PRD)                                │
│     - Architecture                                      │
│     - Epics & Stories                                   │
│                                                          │
│  📋 GSD                                                 │
│     - Phase planning                                    │
│     - Execution                                         │
│     - Verification                                      │
│                                                          │
│  🤖 Ralph Loop                                          │
│     - Autonomous implementation                         │
│     - Iterative development                             │
│     - Checkpoint management                             │
│                                                          │
│  💾 OpenViking                                          │
│     - Context preservation                              │
│     - Knowledge base                                    │
│     - Cross-session memory                              │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

### Enhanced Workflow

```
BMAD (Requirements & Architecture)
    ↓
├─ Research with NotebookLM
│  ├─ Query technical docs
│  ├─ Verify architecture patterns
│  └─ Get citation-backed answers
    ↓
├─ Store insights in OpenViking
    ↓
GSD (Planning & Execution)
    ↓
├─ Plan with NotebookLM context
│  ├─ Reference uploaded specs
│  └─ Check implementation details
    ↓
├─ Verify with NotebookLM
    ↓
Ralph Loop (Implementation)
    ↓
├─ Implement with NotebookLM verification
│  ├─ Verify code against docs
│  └─ Check API references
    ↓
├─ Store outcomes in OpenViking
    ↓
OpenViking (Context Preservation)
    ↓
└─ Complete project knowledge base
```

## Quick Start Guide

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

## Usage Examples for FixCity

### Example 1: Technical Research (BMAD)

```bash
# Research Laravel patterns
python scripts/run.py ask_question.py \
  --question "What are Laravel 12 best practices for service architecture?"

# Research Filament v5
python scripts/run.py ask_question.py \
  --question "How to create Filament v5 resources with XotBase extension?"

# Store in OpenViking
openviking add-memory \
  --title="Laravel Architecture Best Practices" \
  --content="[NotebookLM answer with citations]"
```

### Example 2: Implementation Verification (GSD)

```bash
# Verify implementation approach
python scripts/run.py ask_question.py \
  --question "Check the Laraxot documentation: should I use Actions or Services?"

# Verify code patterns
python scripts/run.py ask_question.py \
  --question "What is the correct pattern for Filament table actions?"
```

### Example 3: Quick Reference (Ralph Loop)

```bash
# Quick reference during implementation
python scripts/run.py ask_question.py \
  --question "What is the container0/slug0 pattern in Laraxot?"

# API reference
python scripts/run.py ask_question.py \
  --question "How to use Spatie QueueableAction with Laravel?"
```

## Critical: Follow-Up Mechanism

Every NotebookLM answer ends with: **"Is that ALL you need to know?"**

**Required Workflow**:
1. **STOP** - Don't respond immediately
2. **ANALYZE** - Check if answer is complete
3. **ASK FOLLOW-UP** - If gaps exist:
   ```bash
   python scripts/run.py ask_question.py \
     --question "Follow-up: [specific gap] with context from previous answer"
   ```
4. **REPEAT** - Until information is complete
5. **SYNTHESIZE** - Combine all answers before responding

## Recommended Notebooks for FixCity

Create these NotebookLM notebooks:

### 1. Laraxot Framework Docs
- **Upload**: Laraxot documentation, AGENTS.md, .windsurfrules
- **Topics**: laravel, architecture, modules, filament, xot
- **Use**: Technical research, implementation verification

### 2. PHP Best Practices
- **Upload**: PHP 8.3+ docs, PSR standards, SOLID principles
- **Topics**: php, patterns, quality, testing, phpstan
- **Use**: Code quality, architecture decisions

### 3. Filament v5 Documentation
- **Upload**: Filament docs, examples, tutorials
- **Topics**: filament, admin, resources, forms, tables, widgets
- **Use**: Admin panel development

### 4. Project Documentation
- **Upload**: FixCity docs, module docs, theme docs
- **Topics**: fixcity, project, conventions, documentation
- **Use**: Project-specific queries

## Files Created/Updated

### Created
1. ✅ `docs/project/notebooklm-integration.md` - Complete integration guide
2. ✅ `docs/NOTEBOOKLM_INSTALLATION_SUMMARY.md` - This summary

### Updated
1. ✅ `.windsurfrules` - Added AI Tools Integration section

## Command Reference

### Always Use run.py Wrapper

```bash
# ✅ CORRECT - Always use run.py:
python scripts/run.py auth_manager.py status
python scripts/run.py notebook_manager.py list
python scripts/run.py ask_question.py --question "..."

# ❌ WRONG - Never call directly:
python scripts/auth_manager.py status  # Fails without venv!
```

### Core Commands

```bash
# Authentication
python scripts/run.py auth_manager.py status
python scripts/run.py auth_manager.py setup
python scripts/run.py auth_manager.py clear

# Notebook Management
python scripts/run.py notebook_manager.py list
python scripts/run.py notebook_manager.py add --url URL --name NAME --description DESC --topics TOPICS
python scripts/run.py notebook_manager.py activate --id ID
python scripts/run.py notebook_manager.py search --query QUERY

# Ask Questions
python scripts/run.py ask_question.py --question "..." [--notebook-id ID] [--notebook-url URL]
```

## Configuration

### Environment (.env)

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

### Data Storage

```
~/.claude/skills/notebooklm/data/
├── library.json       # Your notebook library
├── auth_info.json     # Authentication status
└── browser_state/     # Browser cookies and session
```

**Security**: Protected by `.gitignore`, never commit.

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Not authenticated | `python scripts/run.py auth_manager.py setup` |
| ModuleNotFoundError | Always use `run.py` wrapper |
| Rate limit (50/day) | Wait or use different Google account |
| Browser crashes | `python scripts/run.py cleanup_manager.py --preserve-library` |
| Notebook not found | Check with `notebook_manager.py list` |

## Best Practices

1. ✅ **Always use run.py** - Handles environment automatically
2. ✅ **Check auth first** - Before any operations
3. ✅ **Follow-up questions** - Don't stop at first answer
4. ✅ **Include context** - Each question is independent
5. ✅ **Synthesize answers** - Combine multiple responses
6. ✅ **Store in OpenViking** - Preserve insights for future

## Next Steps

1. ✅ Skill installed and verified
2. ⏳ Authenticate with Google account
3. ⏳ Create FixCity NotebookLM notebooks
4. ⏳ Upload project documentation
5. ⏳ Integrate with BMAD workflow
6. ⏳ Store insights in OpenViking

## Resources

- **Skill Location**: `~/.claude/skills/notebooklm/`
- **Documentation**: `~/.claude/skills/notebooklm/SKILL.md`
- **Integration Guide**: `docs/project/notebooklm-integration.md`
- **Scripts**: `~/.claude/skills/notebooklm/scripts/`
- **GitHub**: https://github.com/PleasePrompto/notebooklm-skill

---

**Status**: ✅ Ready for authentication and notebook creation  
**Last Updated**: 2026-03-30  
**Integrated By**: AI Agent (BMAD + GSD + Ralph Workflow)
