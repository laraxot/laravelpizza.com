---
name: ollama-command
description: Executes tasks locally via Ollama to save tokens and costs.
---

# Ollama Slash Command (/ollama)

## 🎯 Vision & Philosophy
The `/ollama` command is a core pillar of our "Local First" strategy. In the Laraxot/Super Mucca methodology, we prioritize local compute over cloud-based APIs for efficiency, privacy, and cost-effectiveness.

## 🛠️ Operational Instructions
When a user types `/ollama [prompt]`, use the unified command bridge.

### Command Bridge Interface:
- `/ollama list`: Show installed models.
- `/ollama pull [model]`: Install/Update a model.
- `/ollama use [model]`: Set session default model.
- `/ollama status`: Check service health.
- `/ollama [any prompt]`: Direct execution via current default model.

**Execution Command:**
```bash
bash bashscripts/ai/ollama-cmd.sh "[prompt]"
```

## 📐 When to use Ollama vs Gemini/Claude
- **Use Ollama (Local):** Trivial refactoring, linting, code documentation, summarizing files, generating unit tests (Pest), translation expansions.
- **Use Cloud (Gemini/Claude):** Complex architectural design, deep debugging of distributed systems, multi-file reasoning that exceeds local context.

## 🚨 Mandatory Policy
1.  **Direct Execution:** Execute the prompt immediately via the script.
2.  **Context Injection:** The output from Ollama should be considered as primary context for your current session.
3.  **Local Mastery:** If you are asked to perform a task that could be handled locally, remind the user about `/ollama`.

---
*Status: Configured for all Agents (Gemini, Claude, OpenCode, Cursor, Windsurf, Cline, Continue)*
