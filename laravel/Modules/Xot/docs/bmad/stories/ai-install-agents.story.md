---
title: "Migliorare l'installer degli AI coding agent"
type: story
module: Xot
epic: agent-os
story_id: "ai-install-agents"
status: done
track: agent-os/tooling
created: 2026-11-04
updated: 2026-11-04
tags: [installer, coding-agents, shell, bmad, second-brain]
qmd: "AI coding agent installer install.sh coding agent Codex Claude Gemini Copilot Amp Aider OpenCode Cursor Kilo"
references:
  - "../../../../../../bashscripts/ai/install.sh"
  - "https://geminicli.com/docs/get-started/installation/"
  - "https://docs.github.com/en/copilot/how-tos/copilot-cli/set-up-copilot-cli/install-copilot-cli"
  - "https://ampcode.com/docs/cli"
  - "https://aider.chat/docs/install.html"
---

# Story: Installer AI coding agent

## Obiettivo

Rendere `bashscripts/ai/install.sh` chiaro e mantenibile, includendo i coding agent CLI utili non ancora presenti e distinguendoli da runtime/router; aggiungere emoji alle intestazioni.

## Acceptance criteria

- [x] Installazioni duplicate eliminate (OpenCode, Kilo, Qwen, Ollama) e comando Qwen canonico mantenuto.
- [x] Gemini CLI, GitHub Copilot CLI, Amp e Aider aggiunti; comandi confrontati con documentazione ufficiale.
- [x] Runtime/router (Ollama, OMP, OmniRoute) separati dagli agenti.
- [x] Aggiunti Codebuff, Auggie, Junie, iFlow, Goose, gptme e ra-aid; binari npm verificati con `npm view <pkg> bin`.
- [x] Emoji usate con moderazione nelle intestazioni, in `--list` (categoria/tipo/stato) e nei messaggi di avanzamento.
- [x] `--only` iterato in modo quotato; npm usa `--no-fund --no-audit`.
- [x] `bash -n`, `--list`, `--dry-run --only` e `git diff --check` superati. ShellCheck non disponibile; script non eseguito per evitare installazioni di sistema.
- [x] Story chiusa e indicizzata con `qmd update`.

## Task

- [x] Esaminare script, second brain e documentazione ufficiale.
- [x] Aggiornare installer sotto lock.
- [x] Verificare disponibilità pacchetti/binari e aggiungere i 7 agent mancanti.
- [x] Validare sintassi, `--list`, `--dry-run`, aggiornare story e second brain (story ricercabile via QMD).
