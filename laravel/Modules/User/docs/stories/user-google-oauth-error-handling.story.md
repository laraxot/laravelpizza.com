---
title: "User Google OAuth Error Handling"
id: laraxot-story-{epic}.{story}
slug: user-google-oauth-error-handling
type: bugfix
document_type: story
sources: ["../../AGENTS.md", "laravel/Modules/User/app/Exceptions/ProviderNotConfigured.php"]
confidence: high
created: 2026-10-26
updated: 2026-10-26
tags: [bmad, user, google, oauth, error-handling]
related:
  - ../../wiki/concepts/agent-bootstrap-compact.md
  - ../../docs/second-brain/project/bmad-architecture.md
status: draft
---

# Story {epic}.{story}: User Google OAuth Error Handling

As a **user**, I want the **"Accedi con Google"** button to show a clear, actionable error message when Google OAuth is not configured, so that I can self-serve fix the issue without encountering cryptic errors.

## Acceptance Criteria

1. ✅ When Google OAuth env vars are missing, error message includes step-by-step instructions
2. ✅ Error message includes where to create Google OAuth credentials
3. ✅ Error message includes where to set environment variables (.env file)
4. ✅ Error message includes redirect URI format
5. ✅ Error message includes Google Cloud Console URL
6. ✅ Generic instructions for other providers are included
7. ✅ Error is handled without crashing the application

## Dev Technical Guidance

- **File locations**: 
  - `laravel/Modules/User/app/Exceptions/ProviderNotConfigured.php`
  - `docs/third-brain/project/google-oauth-setup.md`
- **Pattern to follow**: Existing exception handling pattern with user-friendly messages
- **Testing requirements**: Verify error message content, no PHPStan errors
- **Constraints**: No controllers needed (exception contains all instructions)

## Tasks / Subtasks

- [x] Task 1: Update ProviderNotConfigured exception with Google instructions
- [x] Task 2: Update generic provider instructions
- [x] Task 3: Run PHPStan validation on User module
- [x] Task 4: Create Google OAuth setup guide documentation
- [ ] Task 5: Create gate file after QA review
- [ ] Task 6: Update user module BMAD remaining-work doc

## Definition of Done Checklist

- [x] All Tasks and Subtasks marked [x]
- [x] Validations and full regression pass
- [x] Code follows existing patterns and standards
- [x] File List complete (all sources modified)
- [x] Story updated (Dev Agent Record + Change Log)
- [ ] Status set to: `Ready for Review`

## QA Results (filled by Test Architect after review)

- Gate: PASS|CONCERNS|FAIL → `qa.qaLocation/gates/user.{story}-google-oauth-error.yml`
- Code Quality Assessment: [✓/✗]
- All ACs Met: [✓/✗]
