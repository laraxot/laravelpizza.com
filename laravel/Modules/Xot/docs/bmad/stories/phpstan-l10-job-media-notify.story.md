---
title: "Xot - phpstan-l10-job-media-notify.story.md"
module: Xot
bmad: true
status: active
---
# BMAD Story: PHPStan L10 Job, Media, Notify

**Epic**: 8.26  
**Sprint**: 2026-10-06  
**Status**: ACTIVE  
**Owner**: Claude Haiku 4.5  

## Context

Three medium-sized, integration-heavy modules require PHPStan L10 remediation:
- **Job**: batch/queue logic with action contracts and queue payload type narrowing
- **Media**: file operations without filesystem error ignores; preserve error handling intent  
- **Notify**: template + channel logic with notifiable interface validation

Key constraint: `//...` developer marker comments are intentional and must NOT be removed.

## Discovery

Running: `./vendor/bin/phpstan analyse laravel/Modules/Job laravel/Modules/Media laravel/Modules/Notify --no-progress --memory-limit=-1`

Workflow:
1. Lock acquired: `phpstan-l10-job-media-notify`
2. Scan to identify errors per module
3. Fix by module (batch action contracts → file service → notification interface)
4. Quality gate + Pest
5. Document pattern in second brain if recurring
6. Commit with reference to this story

## Errors Found

(Placeholder: scanning in progress)

## Approach per Module

### Job (batch/queue)
- Validate action contract signatures
- Type narrowing on queue payload
- Ensure QueueableAction execute() matches interface
- Preserve action result handling

### Media (file operations)
- File::exists() / File::put() type safety
- Error handling intent (not silenced with @)
- Storage facade contracts
- Preserve exception handling patterns

### Notify (channels + templates)
- Notifiable interface validation
- Channel routing logic
- Template data array contracts
- Preserve closure type hints

## Deliverables

- [ ] All errors fixed per module
- [ ] `//...` comments preserved
- [ ] PHPStan 0 errors verified
- [ ] Pattern documented in second brain (if recurring)
- [ ] Pest gate green (no new test failures)
- [ ] Commit with story reference

## Blockers

None initially; escalate if type narrowing requires base contract changes.

## Notes

- No destructive operations (no migrate:fresh, data sacred)
- Second brain: pattern memory if batch action / file service / notification contracts differ from Xot base
