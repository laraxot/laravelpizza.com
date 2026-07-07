# Headless Mode

Load this file when gds-gdd is invoked headless (no interactive user). Follow it for the whole run.

## General

Do not ask. Complete the intent using what is provided, what exists in `{doc_workspace}`, or what you can discover yourself. If intent remains ambiguous after inference, halt with a `blocked` JSON status and a `reason` field — do not prompt. Do not greet.

For Create and Update, detect the game type by matching the inputs against `assets/game-types.csv` and load the matched genre guide rather than asking. Record the resolved `game_type` and the `needs_narrative` flag in the JSON status block.

End with a JSON response listing status, intent, and artifact paths. The `intent` field must match the detected intent: `"create"`, `"update"`, or `"validate"`. Omit keys for artifacts not produced. Full schemas with examples for each intent are in `assets/headless-schemas.md`. Minimal shape:

```json
{
  "status": "complete",
  "intent": "validate",
  "validation_report": "{doc_workspace}/validation-report.md",
  "offer_to_update": true
}
```

## Mode-specific overrides

**Update.** Log the reversal to `decision-log.md`, then apply. Halt `blocked` if intent is ambiguous.

**Validate.** Always write `validation-report.md` to `{doc_workspace}` regardless of finding count. Always include `"offer_to_update": true` in the JSON status block.
