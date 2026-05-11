# LLM Wiki - Usage Guide (Module: Geo)

This module provides AddressInput and map-related fields used across ticket wizards.

Docs layout:
- docs/raw/: raw specs, API notes, and example requests
- docs/wiki/: short, LLM-friendly usage pages (e.g., AddressInput usage)

AddressInput guidance:
- Prefer `AddressInput::make()` (module API) instead of custom placeholders
- Document typical usage snippets in docs/wiki/addressinput.md

QMD quick commands (same as global):
- `qmd collection add ./laravel/Modules/Geo/docs --name geo-docs`
- `qmd embed` then `qmd mcp --http --port 8182 &`
