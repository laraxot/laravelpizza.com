# Claude Code Router – DeepSeek Reasoning Fix

## 1. Context

- Tool: [musistudio/claude-code-router](https://github.com/musistudio/claude-code-router)
- Error seen: `Missing reasoning_content field ... deepseek-reasoner` (provider returns HTTP 400).
- Cause: DeepSeek Reasoner requires `reasoning_content` when tool calls are present. Without a transformer the router forwards an incomplete payload.

## 2. Required Steps

1. **Update configuration** (`docs/tooling/examples/ccr.deepseek.json`): add provider entry with the `deepseek` transformer and a model-specific `reasoning_content` transformer for `deepseek-reasoner`.
2. **Reference config** in the main CCR config (`~/.config/claude-code-router/config.json`) or via `ccr config apply`.
3. **Restart CCR**: `ccr stop && ccr start`.
4. **Activate env** for shell/Agent SDK: `eval "$(ccr activate)"`.

## 3. Example Configuration

```json
{
  "providers": [
    {
      "name": "deepseek",
      "api_base_url": "https://api.deepseek.com/chat/completions",
      "api_key": "env:DEEPSEEK_API_KEY",
      "models": ["deepseek-chat", "deepseek-reasoner"],
      "transformer": {
        "use": ["deepseek", "tooluse"],
        "deepseek-reasoner": {
          "use": [
            [
              "reasoning_content",
              {
                "default": "Tool call requires reasoning_content per DeepSeek spec."
              }
            ]
          ]
        }
      }
    }
  ]
}
```

- `env:DEEPSEEK_API_KEY` uses CCR’s env interpolation; set via export or `.env`.
- `tooluse` ensures tool-call sections are preserved.
- `reasoning_content` transformer injects the required field whenever missing.

## 4. CLI Checklist

1. `npm install -g @musistudio/claude-code-router` (update to latest).
2. `ccr config edit` → include snippet above (or symlink the example file).
3. `ccr stop && ccr start`.
4. `eval "$(ccr activate)"` in each shell before running `ccr code`.
5. Test: `ccr code --provider deepseek --model deepseek-reasoner --prompt "ping"` → should return senza 400.

## 5. Integration Notes

- Add `ccr` env activation to CI if needed (`eval "$(ccr activate)" && npm run your-task`).
- For GitHub Actions, configure `ANTHROPIC_AUTH_TOKEN`, `DEEPSEEK_API_KEY`, ecc. as secrets.
- Document future provider-specific requirements in this folder to keep all agents aligned.
