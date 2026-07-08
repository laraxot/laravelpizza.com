# GitHub Issues & Discussions - Design Comuni Replication

Benvenuto nel sistema di tracking delle issue per il progetto **Design Comuni Replication**.

## 📋 Quick Links

- **🗺️ Roadmap**: [View 12-week plan](../.planning/ROADMAP.md)
- **📊 Project Summary**: [View status](../laravel/Themes/Sixteen/docs/DESIGN_COMUNI_PROJECT_SUMMARY.md)
- **📚 Team Guide**: [Read guide](../laravel/Themes/Sixteen/docs/DESIGN_COMUNI_TEAM_GUIDE.md)
- **🏗️ Architecture**: [View decisions](../_bmad-output/design-comuni-architecture.md)
- **🔍 Research**: [View analysis](../.planning/research/design-comuni-pages.md)

---

## 🎯 What We're Building

Replicating **38 Design Comuni static pages** using **Tailwind CSS + Alpine.js** with **JSON-driven content blocks**.

**Source**: https://italia.github.io/design-comuni-pagine-statiche/  
**Target**: http://fixcity.local/it/tests/[page-slug]  
**Timeline**: 12 weeks (April 1 - June 30, 2026)

---

## 📝 Issue Templates

We have 4 issue templates to help you track different types of work:

### 1. Epic Issues
**When**: At the start of each phase (6 epics total)  
**Purpose**: Track high-level phases  
**Example**: `Epic #1: Foundation & Homepage (Weeks 1-2)`

### 2. Component Implementation
**When**: For each of the 47 reusable components  
**Purpose**: Track component development  
**Example**: `Component: Hero Section (Tier 1)`

### 3. Page Implementation
**When**: For each of the 38 pages  
**Purpose**: Track page replication  
**Example**: `Page: Homepage - /it/tests/homepage`

### 4. Architecture Decision Record (ADR)
**When**: Before major technical decisions  
**Purpose**: Document architectural decisions  
**Example**: `ADR: Use Tailwind @apply Instead of Bootstrap Italia CDN`

---

## 🏷️ Labels

We use labels to categorize and prioritize issues:

### Type Labels
- `epic` - High-level phase tracking
- `component` - Reusable component
- `page` - Page replication
- `adr` - Architecture decision record
- `bug` - Something isn't working
- `documentation` - Documentation improvements

### Priority Labels
- `priority-high` - Must do first (Tier 1 components, Homepage)
- `priority-medium` - Should do soon (Tier 2-3 components)
- `priority-low` - Can do later (Tier 4-5 components)

### Status Labels
- `status-proposed` - Issue created, not started
- `status-in-progress` - Currently working on it
- `status-review` - Ready for review
- `status-done` - Complete and merged

### Category Labels
- `design-comuni` - Related to Design Comuni replication
- `frontend` - Frontend development
- `backend` - Backend development
- `testing` - Testing and QA
- `accessibility` - WCAG compliance
- `performance` - Performance optimization

---

## 🚀 How to Contribute

### Step 1: Find an Issue
Browse the [Issues tab](../../issues) and look for:
- Issues labeled `priority-high`
- Issues in `status-proposed` or `status-in-progress`
- Issues matching your skills

### Step 2: Comment to Start
Before starting work:
1. Comment on the issue: "I'll work on this"
2. Tag the project lead if needed
3. Wait for assignment

### Step 3: Create Branch
```bash
git checkout -b feature/[issue-number]-[component-name]
# Example: git checkout -b feature/2-header-main
```

### Step 4: Make Atomic Commits
Follow [Conventional Commits](https://www.conventionalcommits.org/):
```bash
git commit -m "feat(header): create universal header component

- Add Blade component with Alpine.js dropdown
- Replicate Bootstrap Italia styles with Tailwind @apply
- Ensure WCAG 2.1 AA compliance
- Closes #2"
```

### Step 5: Create Pull Request
1. Push branch to GitHub
2. Create PR with template
3. Link to issue ("Closes #2")
4. Add screenshots if applicable

### Step 6: Code Review
1. Wait for review
2. Address feedback
3. Update PR if needed
4. Get approval

### Step 7: Merge and Deploy
1. Merge to main branch
2. Deploy to staging
3. Verify on staging
4. Close issue

---

## 💬 GitHub Discussions

Use [Discussions](../../discussions) for:

### Architecture Decisions
Propose and discuss major technical decisions before implementation.

**Example**:
- Title: "ADR: Use Tailwind @apply Instead of Bootstrap Italia CDN"
- Category: Architecture Decisions
- Labels: adr, architecture, tailwind

### Component Design
Propose new components and get feedback on design.

**Example**:
- Title: "Component Design: Hero Section"
- Category: Component Design
- Labels: component, hero, design

### Q&A
Ask questions and get help from the team.

**Example**:
- Title: "How to replicate Bootstrap Italia grid system?"
- Category: Q&A
- Labels: question, css, grid

---

## 📊 Project Boards

We use GitHub Projects to track progress:

### Board 1: Design Comuni Replication
**URL**: [View Project Board](../../projects/1)  
**Purpose**: Track all 38 pages and 47 components  
**Columns**:
- Backlog
- Ready
- In Progress
- Review
- Done

### Board 2: Sprint Planning
**URL**: [View Sprint Board](../../projects/2)  
**Purpose**: Track current sprint (2-week cycles)  
**Columns**:
- Sprint Backlog
- This Week
- Blocked
- Done
- Next Sprint

---

## 📈 Metrics

### Velocity
- **Issues per week**: Target 8-10 issues
- **Points per sprint**: Target 40-50 points
- **Cycle time**: Target <5 days (create → close)

### Quality
- **Reopen rate**: Target <10%
- **Bug rate**: Target <5% (bugs / features)
- **Test coverage**: Target >80%

### Documentation
- **Docs per issue**: Every issue updates docs
- **Bidirectional links**: All docs cross-referenced
- **Index completeness**: Master index always up-to-date

---

## 🎓 Learning Resources

### Design Comuni
- [Official Website](https://italia.github.io/design-comuni-pagine-statiche/)
- [Bootstrap Italia Docs](https://italia.github.io/bootstrap-italia/)
- [Design System](https://github.com/italia/design-comuni-pagine-statiche)

### Technical
- [Laravel Folio](https://laravel.com/docs/12.x/folio)
- [Livewire Volt](https://livewire.laravel.com/docs/volt)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Alpine.js](https://alpinejs.dev/)
- [DaisyUI](https://daisyui.com/components/)
- [Flowbite](https://flowbite.com/blocks/)

### Testing
- [Pest PHP](https://pestphp.com/)
- [WCAG 2.1 AA](https://www.w3.org/WAI/WCAG21/quickref/)
- [Lighthouse](https://developer.chrome.com/docs/lighthouse/overview/)

---

## ❓ FAQ

### Q: How do I know which issue to work on?
**A**: Look for issues labeled `priority-high` and `status-proposed`. Check the [Roadmap](../.planning/ROADMAP.md) for current phase.

### Q: Can I work on multiple issues?
**A**: Yes, but focus on one at a time. Complete and close issues before starting new ones.

### Q: What if I find a bug?
**A**: Create a new issue with the `bug` label. Include steps to reproduce, expected vs actual behavior, and screenshots.

### Q: How do I request a new component?
**A**: Create a Discussion in the "Component Design" category. Propose the component, explain use cases, and get feedback.

### Q: Where do I document my work?
**A**: Update the component catalog (`Themes/Sixteen/docs/COMPONENT_CATALOG.md`) and add bidirectional links to the [Master Index](../docs/MODULE_DOCS_INDEX.md).

### Q: How do I run tests?
**A**: See the [Team Guide](../laravel/Themes/Sixteen/docs/DESIGN_COMUNI_TEAM_GUIDE.md#testing) for test commands and examples.

---

## 📞 Contact

### Project Lead
- **Name**: [Project Lead Name]
- **Email**: [email@example.com]
- **GitHub**: [@username]

### Office Hours
- **When**: Every Tuesday 14:00-16:00 CET
- **Where**: Google Meet
- **Who**: All team members welcome

### Emergency Contact
For urgent issues (production down, critical bug):
- **Slack**: #design-comuni-emergency
- **Phone**: [+XX XXX XXX XXXX]

---

## 🎉 Celebrating Milestones

We celebrate completing each phase! 🎊

### Phase 1: Homepage Complete ✅
- **Date**: April 14, 2026
- **Celebration**: Team lunch / virtual happy hour
- **Recognition**: Shout-out in company meeting

### Phase 2: List Pages Complete
- **Date**: April 28, 2026
- **Celebration**: [TBD]

### Phase 3: Detail Pages Complete
- **Date**: May 12, 2026
- **Celebration**: [TBD]

### Phase 4: Multi-Step Forms Part 1 Complete
- **Date**: May 26, 2026
- **Celebration**: [TBD]

### Phase 5: Multi-Step Forms Part 2 Complete
- **Date**: June 9, 2026
- **Celebration**: [TBD]

### Phase 6: Project Complete! 🎉
- **Date**: June 30, 2026
- **Celebration**: Big team celebration!
- **Recognition**: Certificates, bonuses, public acknowledgment

---

## 📜 Code of Conduct

### Be Respectful
Treat all team members with respect and kindness.

### Be Inclusive
Welcome contributors of all backgrounds and skill levels.

### Be Constructive
Provide helpful feedback, not criticism.

### Be Collaborative
Work together, share knowledge, help each other grow.

### Be Professional
Maintain professional communication at all times.

---

**Last Updated**: April 1, 2026  
**Version**: 1.0  
**Maintained By**: Project maintainers

---

## 🔗 Quick Navigation

- [Back to Project Summary](../laravel/Themes/Sixteen/docs/DESIGN_COMUNI_PROJECT_SUMMARY.md)
- [Back to Team Guide](../laravel/Themes/Sixteen/docs/DESIGN_COMUNI_TEAM_GUIDE.md)
- [Back to Master Index](../docs/MODULE_DOCS_INDEX.md)
- [View Roadmap](../.planning/ROADMAP.md)
