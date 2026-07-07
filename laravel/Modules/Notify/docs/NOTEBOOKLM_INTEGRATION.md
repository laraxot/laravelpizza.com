# NotebookLM Integration

## Overview

This project integrates **Google NotebookLM** with Claude Code/OpenCode for source-grounded research and documentation assistance.

## What is NotebookLM?

NotebookLM is Google's AI-powered research assistant that lets you:
- Upload documents (PDF, Markdown, Google Docs, URLs, YouTube)
- Chat with your sources using Gemini 2.5
- Generate podcasts (Audio Overview), videos, quizzes, flashcards, and more

## Installation

### 1. Install notebooklm-py

```bash
pipx install notebooklm-py
pipx inject notebooklm-py "notebooklm-py[browser]"
```

### 2. Install Claude Code Skill

```bash
notebooklm skill install
```

This installs the skill to `~/.claude/skills/notebooklm/`

### 3. Authenticate

```bash
notebooklm login
```

This opens a browser window. Complete the Google login and press ENTER to save.

### 4. Verify Authentication

```bash
notebooklm auth check --test
```

## Usage

### CLI Commands

```bash
# List notebooks
notebooklm list

# Create a notebook
notebooklm create "FixCity Research"

# Add sources
notebooklm use <notebook_id>
notebooklm source add "https://laravel.com/docs/11.x"
notebooklm source add "./docs/ARCHITECTURE.md"

# Chat with sources
notebooklm ask "How does the XotBase pattern work?"

# Generate audio overview (podcast)
notebooklm generate audio "explain this like a podcast"
notebooklm download audio ./podcast.mp3
```

### Claude Code Integration

Once authenticated, you can ask Claude Code to:

```
"NotebookLM: Create a podcast about Laravel Actions patterns"
"NotebookLM: What's in my FixCity Research notebook?"
"NotebookLM: Generate a quiz about Filament Forms"
```

## FixCity-Specific Notebooks

Recommended notebooks to create:

1. **FixCity Architecture** - AGENTS.md, docs/architecture/*
2. **FixCity Modules** - laravel/Modules/*/docs/README.md
3. **FixCity API** - API documentation, Swagger specs

## Configuration

The skill is installed at: `~/.claude/skills/notebooklm/`

Key files:
- `SKILL.md` - Claude Code skill definition
- `AUTHENTICATION.md` - Authentication architecture
- `README.md` - Full documentation

## Troubleshooting

### Login Failed

```bash
# Re-run login
notebooklm login
```

### Authentication Issues

```bash
# Check auth status
notebooklm auth check --test

# Reset authentication
rm ~/.notebooklm/storage_state.json
notebooklm login
```

### Browser Issues

If login fails with browser errors, ensure Playwright browsers are installed:

```bash
pipx run notebooklm-py playwright install chromium
```

## Quick Reference

| Command | Description |
|---------|-------------|
| `notebooklm login` | Authenticate with Google |
| `notebooklm list` | List notebooks |
| `notebooklm create "Name"` | Create notebook |
| `notebooklm use <id>` | Switch notebook |
| `notebooklm source add <url>` | Add source |
| `notebooklm ask "?"` | Ask question |
| `notebooklm generate audio` | Generate podcast |

## Files

- **Installed**: `~/.claude/skills/notebooklm/`
- **Storage**: `~/.notebooklm/`
- **Config**: `~/.notebooklm/config.json`
