# 13. Pre-Commit Checklist

Before committing or pushing:
- [ ] Module docs and theme docs were studied and improved before any code edit
- [ ] GitHub Issue/Discussion need was evaluated for the work just done
- [ ] PHPStan Level 10 passes on the required scope (if the user asks total verification, run the full required scope)
- [ ] PHPMD passes on the same scope
- [ ] PHP Insights passes on the same scope
- [ ] Pint formatting applied
- [ ] Tests pass on the same scope
- [ ] Runtime/UAT verification completed on the affected flow
- [ ] If one of these gates was skipped, no commit/push is allowed and the gap is declared explicitly
- [ ] No hardcoded strings (use translations)
- [ ] XotBase classes used (not raw Filament)
- [ ] No Controllers for frontoffice
- [ ] JSON pages for dynamic content

---
