# Ollama & Local-First AI Strategy: The "Super Mucca" Philosophy

## 1. Vision & Philosophy (Il Perché)
In the Laraxot/Super Mucca ecosystem, efficiency is paramount. Relying solely on cloud-based LLMs (Gemini Pro, Claude 3.5, GPT-4) for every trivial task is efficient neither in terms of cost nor latency.

**The "Local First" Zen:**
*   **Privacy by Default:** Code logic, especially proprietary business logic, should stay local whenever possible.
*   **Zero Marginal Cost:** Running a local LLM costs electricity, not tokens. This encourages experimentation and iteration without fear of the bill.
*   **Speed:** No network latency. Ideal for quick linting, summarizing, or boilerplate generation.
*   **Resilience:** Development can continue even without an internet connection or when APIs are down.

## 2. The Policy (La Politica)
Every agent (Gemini, Cursor, Windsurf, etc.) operating in this workspace MUST evaluate the complexity of a task before escalating:
1.  **Level 1 (Trivial/Boilerplate):** Use Local LLM (Ollama). Examples: PHPDoc generation, Unit Test boilerplate, simple refactoring, translation.
2.  **Level 2 (Logic/Debugging):** Try Local LLM first. If unsatisfactory, escalate.
3.  **Level 3 (Architecture/Complex Reasoning):** Use Cloud LLM (Gemini/Claude).

## 3. Model Lifecycle Management (Gestione dei Modelli)
L'efficienza locale dipende dalla scelta del modello giusto per il compito giusto. Gli agenti devono poter:
*   **Inventory:** Elencare i modelli disponibili per decidere quale usare.
*   **Provisioning:** Scaricare nuovi modelli se quelli presenti non sono adeguati.
*   **Selection:** Cambiare il modello predefinito in base al contesto (es. passare a un modello più grande per compiti difficili).

## 4. Extended Command Interface
Il workspace espone sia il comando generico `/ollama`, sia comandi dedicati per il lifecycle del modello:
*   `/ollama`: esecuzione standard
*   `/ollama-models`: mostra i modelli installati
*   `/ollama-pull [model]`: installa o aggiorna un modello
*   `/ollama-use [model]`: imposta il modello predefinito
*   `/ollama-status`: verifica la salute del servizio locale
*   `/ollama-current-model`: mostra il modello attivo
*   `/ollama-auto-model`: torna alla selezione automatica per intent

### Registered command paths in this workspace
*   **Claude Code:** `bashscripts/ai/.claude/commands/ollama.md`
*   **Gemini Code Assist:** `bashscripts/ai/.gemini/commands/ollama.toml`
*   **OpenCode:** `bashscripts/ai/.opencode/command/ollama.md`

Companion commands are registered alongside the main command in the same client-specific directories.

## 4. Inter-Agent Protocol
*   **Docs as Bus:** This `docs/` folder is the communication bus. If you change how Ollama is used, update this file.
*   **Discussions:** If a local model fails repeatedly at a task, open a GitHub Discussion to tweak the system prompt or switch models. Don't just ignore it.

## 4.1 Scope note
*   Not every client in this workspace has a native slash-command registry.
*   Where native slash commands exist, they should delegate to the same script.
*   Where they do not exist, `/ollama` remains a documented workspace convention rather than a parser-level feature.

## 4.2 Shared persistence
*   lo stato del modello attivo e' persistito in `bashscripts/ai/.ollama-config`
*   valore `AUTO` = routing automatico per intent
*   valore `model-name` = pinning esplicito del modello per `/ollama`

## 5. Recommended Models Matrix
*   **Coding (PHP/Laravel):** `qwen2.5-coder:7b` (Best balance of speed/accuracy)
*   **Logic/Reasoning:** `llama3.1:8b` or `deepseek-coder:6.7b`
*   **Fast Text/Summary:** `mistral:7b`

---
*Created by Gemini CLI Agent - 2026-03-11*
*Part of the Laraxot/Super Mucca Methodology*
