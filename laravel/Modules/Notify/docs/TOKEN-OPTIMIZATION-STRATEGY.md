# Token Optimization Strategy (2026)

This document outlines the mandatory rules for token efficiency in this workspace, based on advanced 2026 research and project-specific constraints.

## 1. Context Engineering Rules
- **Grep-First Approach**: Before reading a file, use `grep_search` to identify relevant line numbers. Never read more than 200 lines of a file without a targeted scope.
- **Selective Reading**: Use `start_line` and `end_line` parameters in `read_file` to capture only the necessary blocks.
- **Session Phasing**: When transitioning from a **Research/Analysis** phase to an **Implementation** phase, summarize the findings and consider a context reset (if supported by the UI) or clearly demarcating the new phase to avoid redundant re-processing of old thoughts.
- **Dependency Loading**: Only load files directly related to the current task. Do not "vacuum" entire directories "just in case."

## 2. Prompt & Communication Rules
- **High-Signal Output**: Use tables, bullet points, and code diffs. Avoid conversational filler and repetitive summaries.
- **Result Compaction**: If a tool output is too large, summarize the key information instead of passing it all back to the model context.
- **Static Prefixing**: Keep system instructions and core project context (like `CLAUDE.md` and `GEMINI.md`) at the top of the context to leverage prompt caching.

## 3. Tool Optimization
- **Parallel Execution**: Batch independent tool calls in a single turn.
- **Sequential Safety**: Use `wait_for_previous: true` only when a tool depends on the output of a prior one in the same turn.
- **CLI over MCP**: Prefer direct shell commands for data-intensive tasks (like file listing or complex grepping) to avoid the overhead of JSON schema overhead in some MCP tools.

## 4. Measurement & KPIs
- **Tokens-per-Outcome**: Focus on completing the task in the fewest turns possible. Each turn adds the entire history to the context.
- **Context Rot Prevention**: Proactively identify when the conversation history is becoming too large and summarize the state to keep the "working set" lean.

## 5. Automatic Enforcement
- This strategy is active by default for all tasks in this workspace.
- Any sub-agent or skill activated must adhere to these rules.
