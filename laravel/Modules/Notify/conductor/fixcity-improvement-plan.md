# FixCity Improvement Plan - Phase 1

## Objective
Improve `http://fixcity.local/it` using the integrated AI agent workflow (OpenViking + BMAD + GSD + Ralph Loop + NotebookLM).

## Phase 1.1: Documentation Foundation
Organize the current documentation chaos to provide a clear context for all AI agents.

### 1. Root File Reorganization
Move the following files from the root to `docs/reports/` or `docs/project/`:
- `BUGFIX_REPORT_2025-01-14.md` -> `docs/reports/`
- `FINAL_SUCCESS_REPORT.md` -> `docs/reports/`
- `MULTI_AGENT_FINAL_REPORT.md` -> `docs/reports/`
- `THEME_UPDATE_FINAL_REPORT.md` -> `docs/reports/`
- `AI_AGENT_LESSONS_LEARNED.md` -> `docs/project/`
- `AI_SKILLS_AND_PLUGINS_COMPLETE.md` -> `docs/project/`
- `KILO_CONFIGURATION_COMPLETE.md` -> `docs/project/`
- `NOTEBOOKLM_SETUP_COMPLETE.md` -> `docs/project/`
- `FIXCITY_IMPROVEMENT_PLAN.md` -> `docs/project/`
- `PROJECT.md` -> `docs/project/`
- `REQUIREMENTS.md` -> `docs/project/`
- `ROADMAP.md` -> `docs/project/`

### 2. Docs Folder Cleanup
Move scattered files in `docs/` to appropriate subdirectories:
- `ABSOLUTE_COMPLETION_100.md` -> `docs/reports/`
- `PHPSTAN_*` -> `docs/phpstan/`
- `GITHUB_*` -> `docs/github/`
- `MASTER_ROADMAP.md` -> `docs/project/`

### 3. Master Index
Create `docs/master-index.md` that links to all categorized documentation.

## Phase 1.2: Homepage Improvements
Implement cinematic UI features as per `_bmad/bmm/2-plan/fixcity-homepage-improvement-prd.json`.

### 1. Hero Section
- Update `laravel/Themes/Sixteen/resources/views/pages/index.blade.php`.
- Add cinematic gradient background.
- Integrate particles.js or similar for background effects.

### 2. GSAP Integration
- Configure `ScrollTrigger`.
- Add fade-in and slide animations for home sections.

### 3. Featured Content
- Update featured reports/services with professional cards and hover effects.

## Verification & Quality Gates
- Run `openviking index` after reorganization.
- Validate `PHPStan Level 10` on any PHP changes.
- Verify `Lighthouse` score > 90 for the homepage.
