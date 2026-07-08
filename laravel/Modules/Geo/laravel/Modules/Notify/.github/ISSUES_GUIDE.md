# GitHub Issues Guide - Design Comuni Replication

## Overview
This guide explains how to use the GitHub issue templates for the Design Comuni replication project.

## Issue Templates

### 1. Epic Issues
**Template**: `epic-*.md`  
**Purpose**: Track high-level phases of the project  
**When to use**: At the start of each phase (6 epics total)

**Structure**:
- Epic overview with goals
- Timeline and status
- Child issues list
- Acceptance criteria
- Definition of Done

**Example**:
```
Epic #1: Foundation & Homepage (Weeks 1-2)
Epic #2: List Pages (Weeks 3-4)
Epic #3: Detail Pages (Weeks 5-6)
Epic #4: Multi-Step Forms - Part 1 (Weeks 7-8)
Epic #5: Multi-Step Forms - Part 2 (Weeks 9-10)
Epic #6: Polish & Documentation (Weeks 11-12)
```

---

### 2. Architecture Decision Records (ADR)
**Template**: `adr-architecture-decision.md`  
**Purpose**: Document important architectural decisions  
**When to use**: Before implementing major technical changes

**Structure**:
- Status (Proposed/Accepted/Deprecated)
- Context (problem statement)
- Decision (proposed solution)
- Consequences (positive/negative)
- Implementation plan
- Validation criteria

**Example ADRs**:
- ADR: Use Tailwind @apply instead of Bootstrap Italia CDN
- ADR: Single [slug].blade.php for all pages
- ADR: JSON-driven content blocks
- ADR: Use <x-layouts.app> for all public pages

---

### 3. Component Implementation
**Template**: `component-implementation.md`  
**Purpose**: Track implementation of reusable components  
**When to use**: For each of the 47 components

**Structure**:
- Component name and type
- Design references (URLs)
- Implementation plan (Blade, CSS, JS)
- Acceptance criteria
- Testing strategy
- Definition of Done

**Component Tiers**:
- **Tier 1** (7 components): Critical - implement first
- **Tier 2** (12 components): High priority
- **Tier 3** (15 components): Medium priority
- **Tier 4** (8 components): Low priority
- **Tier 5** (5 components): Specialized

**Example**:
```
Component: Hero Section
Type: Layout
Priority: Tier 1
Used by: Homepage, Detail pages, Event pages
```

---

### 4. Page Implementation
**Template**: `page-implementation.md`  
**Purpose**: Track replication of individual pages  
**When to use**: For each of the 38 pages

**Structure**:
- Source and target URLs
- JSON content file structure
- Component dependencies
- HTML parity checklist
- Visual parity checklist
- Screenshot analysis requirements
- Testing strategy

**Page Categories**:
- **General** (9 pages): Homepage, Topics, Administration, etc.
- **Amministrazione** (2 pages): Administration, Documents & Data
- **Novità** (2 pages): News List, News Detail
- **Servizi** (3 pages): Services List, Category, Detail
- **Vivere il Comune** (2 pages): Events List, Event Detail
- **Prenotazione** (8 pages): 6-step booking flow
- **Assistenza** (2 pages): 2-step assistance request
- **Segnalazione** (7 pages): 4-step report + personal area + list

**Example**:
```
Page: Homepage
URL: /it/tests/homepage
Source: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html
Epic: #1
Priority: P1
```

---

## Issue Workflow

### 1. Create Issue
1. Click "New Issue" on GitHub
2. Select appropriate template
3. Fill in all sections
4. Add labels (epic, component, page, priority)
5. Assign to milestone
6. Submit

### 2. Work on Issue
1. Comment on issue to start work
2. Create branch: `feature/[issue-number]-[component-name]`
3. Make atomic commits with conventional commits
4. Link PR to issue ("Closes #123")
5. Update issue status

### 3. Review Issue
1. Code review by team
2. Verify acceptance criteria
3. Check tests passing
4. Verify documentation updated
5. Approve or request changes

### 4. Close Issue
1. All acceptance criteria met
2. All tests passing
3. Documentation complete
4. Code merged to main
5. Deployed to staging
6. Close issue with comment

---

## Labels

### Type Labels
- `epic` - High-level phase tracking
- `component` - Reusable component
- `page` - Page replication
- `adr` - Architecture decision record
- `bug` - Something isn't working
- `documentation` - Documentation improvements

### Priority Labels
- `priority-high` - Must do first
- `priority-medium` - Should do soon
- `priority-low` - Can do later

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

## Milestones

### v1.0 - Design Comuni Replication
**Timeline**: April 1 - June 30, 2026 (12 weeks)  
**Issues**: 38 pages + 47 components + 6 epics = 91 issues minimum

**Sub-milestones**:
- **Phase 1** (Apr 1-14): Homepage complete
- **Phase 2** (Apr 15-28): List pages complete
- **Phase 3** (Apr 29 - May 12): Detail pages complete
- **Phase 4** (May 13-26): Multi-step forms Part 1
- **Phase 5** (May 27 - Jun 9): Multi-step forms Part 2
- **Phase 6** (Jun 10-30): Polish, testing, documentation

---

## Best Practices

### Issue Titles
- **Clear and specific**: "Component: Hero Section" NOT "New component"
- **Include type**: Start with "Component:", "Page:", "Epic:", "ADR:"
- **Include URL**: For pages, include `/it/tests/[slug]`

### Issue Descriptions
- **Fill all sections**: Don't leave sections blank
- **Add screenshots**: Visual comparison is critical
- **Link related issues**: Use "Depends on", "Blocks", "Related to"
- **Be specific**: Exact file paths, exact URLs, exact metrics

### Comments
- **Progress updates**: Comment daily with progress
- **Blockers**: Comment immediately if blocked
- **Questions**: Ask questions in comments, tag relevant people
- **Decisions**: Document decisions in comments

---

## Integration with Other Tools

### GSD Workflow
- Issues link to `.planning/ROADMAP.md` phases
- State tracked in `.planning/STATE.md`
- Progress tracked in `.planning/PROJECT.md`

### BMad Documentation
- Issues reference BMad docs in `_bmad-output/`
- ADRs stored in `docs/project/adr/`
- Component docs in `Themes/Sixteen/docs/`

### OpenViking
- Project context stored in OpenViking
- Issues reference OpenViking memories
- Decisions synced to OpenViking

---

## Metrics

### Velocity
- Issues completed per week
- Points completed per sprint
- Cycle time (create → close)

### Quality
- Issues reopened rate
- Bug rate (bugs / features)
- Test coverage %

### Documentation
- Docs updated per issue
- Bidirectional links count
- Index completeness

---

## Troubleshooting

### Issue Too Vague
**Problem**: Issue description is unclear  
**Solution**: Add more details, screenshots, examples, acceptance criteria

### Issue Too Large
**Problem**: Issue covers too much work  
**Solution**: Break into smaller sub-issues, create checklist

### Blocked Issue
**Problem**: Cannot proceed due to dependency ADR, dependency  
**Solution**: 
1. Comment "BLOCKED: [reason]"
2. Tag relevant team members
3. Create dependency issue if needed
4. Move to next sprint

### Duplicate Issue
**Problem**: Issue already exists  
**Solution**: 
1. Comment "Duplicate of #[issue number]"
2. Close issue
3. Link to original issue

---

## Examples

### Good Epic Issue
https://github.com/laraxot/base_fixcity_fila5/issues/1

### Good Component Issue
https://github.com/laraxot/base_fixcity_fila5/issues/2

### Good Page Issue
https://github.com/laraxot/base_fixcity_fila5/issues/9

### Good ADR
https://github.com/laraxot/base_fixcity_fila5/discussions/1

---

## Questions?

If you have questions about using these templates:
1. Check this guide first
2. Search existing issues for examples
3. Ask in GitHub Discussions
4. Tag project maintainers

---

**Last Updated**: April 1, 2026  
**Maintained By**: Project maintainers  
**Version**: 1.0
