# GitHub Issues & Discussions - FixCity Platform

> **Last Updated**: 2026-03-13  
> **Repository**: https://github.com/laraxot/base_fixcity_fila5

---

## 📋 Overview

Questo documento traccia tutte le GitHub Issues e Discussions create per il progetto FixCity.

---

## 🐛 GitHub Issues

### Issue #5: 📁 Fix Database Directory Naming Convention

**URL**: https://github.com/laraxot/base_fixcity_fila5/issues/5  
**Created**: 2026-03-13  
**Author**: @marco76tv  
**Labels**: `documentation`, `good first issue`  
**Status**: 🟢 Open

#### Summary
Alcuni file di documentazione facevano riferimento a directory del database con naming convention errata (iniziale maiuscola invece che minuscolo).

#### Files Fixed
- [x] `laravel/Modules/Blog/docs/structure.md`
- [x] `laravel/Modules/Blog/docs/CHANGELOG_2025-10.md`
- [x] `laravel/Modules/Blog/docs/models/README.md`
- [x] `laravel/Modules/Blog/docs/models/transaction-removal.md`
- [x] `AGENTS.md` (added naming convention rule)
- [x] `docs/conventions/database-naming.md` (new convention doc)

#### Checklist for All Modules
- [ ] Activity
- [ ] AI
- [ ] Blog (✅ Completato)
- [ ] Cms
- [ ] Comment
- [ ] Fixcity
- [ ] Gdpr
- [ ] Geo
- [ ] Job
- [ ] Lang
- [ ] Media
- [ ] Notify
- [ ] Rating
- [ ] Seo
- [ ] Tenant
- [ ] UI
- [ ] User
- [ ] Xot

#### References
- [Database Naming Convention](conventions/database-naming.md)
- [AGENTS.md](../../AGENTS.md)

---

## 💬 GitHub Discussions

### Discussion #1: 📁 Database Directory Naming Best Practices

**URL**: https://github.com/laraxot/base_fixcity_fila5/discussions/1  
**Created**: 2026-03-13  
**Author**: @marco76tv  
**Category**: General  
**Status**: ✅ Active

#### Summary
Discussion per standardizzare la convention delle directory del database in tutti i moduli.

#### Key Points
1. Usare sempre minuscolo: `database/factories/`, `database/migrations/`, `database/seeders/`
2. I namespace possono essere PascalCase: `Database\Factories`
3. I path devono essere minuscoli: `database/factories/`

#### How to Contribute
1. Cerca riferimenti errati con grep
2. Correggi la documentazione
3. Verifica le directory fisiche
4. Rinomina se necessario
5. Aggiorna composer.json

---

## 📊 Issue Templates

### Bug Report Template

```markdown
## 🐛 Bug Description
[Descrivi il bug in modo chiaro e conciso]

## 🔁 Steps to Reproduce
1. [Primo step]
2. [Secondo step]
3. [Terzo step]

## ✅ Expected Behavior
[Cosa ti aspettavi accadesse]

## ❌ Actual Behavior
[Cosa è successo invece]

## 📸 Screenshots
[Se applicabile, aggiungi screenshot]

## 🖥️ Environment
- OS: [e.g. Ubuntu 24.04]
- PHP: [e.g. 8.3]
- Laravel: [e.g. 12.0]
- Database: [e.g. PostgreSQL 16]

## 📋 Additional Context
[Aggiungi qualsiasi altro contesto]
```

### Feature Request Template

```markdown
## 🚀 Feature Description
[Descrivi la feature richiesta]

## 🎯 Problem Statement
[Quale problema risolve questa feature?]

## 💡 Proposed Solution
[Come dovrebbe funzionare questa feature]

## 📋 Alternatives Consider
[Quali alternative hai considerato]

## 📚 Additional Context
[Aggiungi qualsiasi altro contesto]
```

---

## 🏷️ Issue Labels

### Priority Labels
- `🔴 P0: Critical` - Must fix immediately
- `🟠 P1: High` - Should fix soon
- `🟡 P2: Medium` - Nice to have
- `🟢 P3: Low` - Future consideration

### Type Labels
- `bug` - Something isn't working
- `documentation` - Improvements to documentation
- `feature` - New feature or request
- `enhancement` - Improvement of existing feature
- `refactor` - Code refactoring
- `performance` - Performance improvement
- `security` - Security related

### Status Labels
- `🟢 Open` - Issue is open
- `🟡 In Progress` - Someone is working on it
- `🟣 In Review` - Ready for review
- `✅ Complete` - Issue completed
- `❌ Won't Fix` - Will not be fixed

### Module Labels
- `module:blog` - Blog module
- `module:cms` - Cms module
- `module:fixcity` - Fixcity module
- `module:user` - User module
- `module:xot` - Xot module
- [Add more as needed]

---

## 📈 Issue Workflow

```
1. Create Issue
   ↓
2. Triage (add labels, assign)
   ↓
3. In Progress (developer starts working)
   ↓
4. Pull Request Created
   ↓
5. Code Review
   ↓
6. Tests Pass
   ↓
7. Merge
   ↓
8. Issue Closed
```

---

## 💡 Best Practices

### For Issue Creators
1. **Search First**: Check if similar issue exists
2. **Be Specific**: Clear title and description
3. **Add Context**: Environment, steps to reproduce
4. **Use Templates**: Follow issue templates
5. **Label Appropriately**: Add relevant labels

### For Contributors
1. **Comment First**: Before starting work, comment on issue
2. **Follow Guidelines**: Adhere to coding standards
3. **Write Tests**: Include tests with your PR
4. **Update Docs**: Update documentation if needed
5. **Be Responsive**: Respond to feedback promptly

### For Maintainers
1. **Triage Quickly**: Review new issues within 48 hours
2. **Label Consistently**: Use labels appropriately
3. **Assign Fairly**: Distribute work evenly
4. **Mentor**: Help first-time contributors
5. **Close Gracefully**: Thank contributors even if not accepting

---

## 🔗 Useful GitHub Features

### Projects
- **Project Board**: Kanban board for tracking issues
- **Milestones**: Group issues by release/version
- **Roadmap**: Timeline view of milestones

### Actions
- **Auto-label**: Automatically label issues based on content
- **Stale Bot**: Mark and close stale issues
- **Welcome Bot**: Welcome first-time contributors

### Insights
- **Issue Metrics**: Time to close, response time
- **Contributors**: Track contributor activity
- **Code Frequency**: Lines added/removed over time

---

## 📞 Support

For questions about GitHub usage:
- **Documentation**: https://docs.github.com
- **Community**: https://github.community
- **Support**: https://support.github.com

---

**Maintainer**: @marco76tv  
**Contact**: dev @fixcity.example.com
