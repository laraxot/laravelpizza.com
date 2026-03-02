# CCR DeepSeek 400 Error Fix: Missing reasoning_content

## Problem
When using `claude-code-router` (CCR) with DeepSeek models (like `deepseek-reasoner`), you may encounter a **400 API Error**:
`Missing reasoning_content field in the assistant message at message index X`.

This happens because DeepSeek requires the reasoning/thinking content from previous assistant turns to be included in subsequent requests using a specific `reasoning_content` field, but CCR by default stores this in an internal `thinking` field which isn't mapped back to the outgoing request.

## Solution: Custom Router
We have implemented a custom router to bridge this gap.

### 1. The Custom Router File
The fix is located at:
`bashscripts/ccr/custom-router.js`

This script intercepts outgoing requests and ensures that any `thinking.content` in assistant messages is duplicated to a `reasoning_content` field, satisfying DeepSeek's requirements.

### 2. Configuration Update
To activate the fix, update your CCR configuration (usually `~/.claude-code-router/config.json`):

```json
{
  "CUSTOM_ROUTER_PATH": "/var/www/_bases/base_ptvx_fila5_mono/bashscripts/ccr/custom-router.js"
}
```

Or, if you want it specifically for the `deepseek-reasoner` model configuration:

```json
"models": {
  "deepseek-reasoner": {
    "provider": "deepseek",
    "name": "deepseek-reasoner",
    "transformers": ["deepseek", "reasoning", "custom"]
  }
}
```
> [!NOTE]
> Setting `CUSTOM_ROUTER_PATH` globally is recommended if you primarily use DeepSeek reasoner.

## Verification
After applying the config, run a command that triggers a tool call:
`cc "explain this code and use a tool to check the file"`

The error should no longer occur.
