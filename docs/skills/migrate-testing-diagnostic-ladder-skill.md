# Skill: Migrate Testing Diagnostic Ladder

## Trigger
Use this skill whenever `php artisan migrate --env=testing` fails.

## Procedure
1. Run migrate in current environment and capture first blocking error.
2. If error indicates connection/sandbox ambiguity, re-run with elevated permissions.
3. If parse error appears, lint and open the referenced migration file.
4. Re-run migrate and capture first schema error after parse blockers.
5. Document ordered root-cause chain in module/theme docs and collaboration threads.
6. Apply minimal fix only after docs are written.
7. Re-run migrate to confirm next blocker or success.

## Expected artifacts
- Root-memory note under `docs/memory/`.
- Module analysis doc under `laravel/Modules/*/docs/`.
- Theme impact note under `laravel/Themes/*/docs/`.
- Progress + release notes in GitHub Issue/Discussion.
