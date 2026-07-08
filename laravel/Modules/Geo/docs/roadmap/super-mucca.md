# Roadmap: Super Mucca Transition 🐄✨

## 🎯 Goal
Achieve **Level 3 Confidence** (Super Mucca) and refactor all 40+ prompts in `bashscripts/tools/prompts` to be **Project-Agnostic**.

## 📊 Status
- **Current Phase**: Phase 1: Audit & Initialization
- **Total Progress**: 5%

## 🗺️ Phases

### Phase 1: Audit & Initialization [/]
- [x] Standardize `laravel/config/database.php`
- [x] Update `docs/ai-guidelines.md` to Version 4.0
- [x] Create this roadmap (`docs/roadmap/super-mucca.md`)
- [/] Audit `bashscripts/tools/prompts/` list

### Phase 2: Core Prompt Refactoring [ ]
- [ ] Refactor `start.txt` (Main Entry Point)
- [ ] Refactor `rules.txt` (Core Architecture Rules)
- [ ] Refactor `init.txt` (Environment Initialization)
- [ ] Refactor `phpstan.txt` (Static Analysis Philosophy)

### Phase 3: Domain Prompt Refactoring [ ]
- [ ] Refactor `filament-rules.md` (Standardized UI)
- [ ] Refactor `docs.txt` & `md.txt` (Documentation Standards)
- [ ] Refactor `test.txt` (Testing Philosophy)
- [ ] Refactor `spatie.txt` & `webmozarts_assert_rules.txt` (Third-party integrations)

### Phase 4: Verification & Handoff [ ]
- [ ] Verify zero hardcoded "PTVX" references in `bashscripts/tools/prompts`
- [ ] Final project-agnostic audit
- [ ] Update [walkthrough.md](file:///home/zorin/.gemini/antigravity/brain/bebc8241-1ff2-4ed9-8c36-6b09f97fddfc/walkthrough.md)

## 🧠 Architectural Decisions
- **Standardization**: All prompts must use relative paths or placeholders.
- **Philosophy First**: Prompts should explain "Why" (Laraxot Zen) before "How".
- **Self-Refining**: Prompts should encourage the agent to improve the codebase during every task.
