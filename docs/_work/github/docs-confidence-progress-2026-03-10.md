Documentation and quality-governance progress update for the current recovery pass.

This wave did not just patch code. It also refreshed module/theme documentation so the repository state is described honestly after the latest regressions:

- `Modules/Cms/docs/phpstan-syntax-blockers-2026-03-10.md`
- `Modules/User/docs/phpstan-syntax-blockers-2026-03-10.md`
- `Themes/Meetup/docs/phpstan-module-blockers-impact-2026-03-10.md`

Important outcome:

- we are no longer in the earlier "parse errors hide everything" state for the repaired Cms/User clusters
- the repo moved from hidden parse blockers to actionable semantic failures and then to a green global PHPStan run
- current measured global status for `cd laravel && ./vendor/bin/phpstan analyse Modules --no-progress` is now clean

The docs now explicitly separate:

- repaired syntax clusters
- residual semantic/type clusters
- theme impact vs module blocker impact

This matters because theme/frontoffice work was at risk of being reported as healthy while infrastructure-level module regressions were still breaking the reliability of global quality gates.
