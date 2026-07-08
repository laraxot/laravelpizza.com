---
title: Changelog — Three Theme
module: Three
type: reference
status: approved
tags: [version, history, releases, changelog, governance]
updated: "2026-06-18"
related:
  - README.md
  - ../README.md
  - ../../../Zero/docs/changelog.md
  - ../../../One/docs/changelog.md
---

# Changelog — Three Theme

Version history for Three theme (governance & documentation). Follows Semantic Versioning (MAJOR.MINOR.PATCH).

## Release Strategy

- **Semantic Versioning**: MAJOR.MINOR.PATCH (e.g., 1.0.0)
- **Source**: Git tags + governance document updates
- **Documentation**: Maintained in this file + root CHANGELOG.md
- **Governance updates**: Mark major policy changes with ⚠️ emoji
- **Note**: Three is a **documentation & governance** theme with no public frontend assets

## Current Version

**v1.0.0** — Released 2026-06-18

- Governance and documentation framework for Laraxot PTVX
- Filament admin configuration reference
- Architecture rules and standards
- Agent discipline policies
- Project governance documentation

## Version History

### v1.0.0 — 2026-06-18

**Purpose:**
Three theme serves as the **backbone documentation** for Laraxot PTVX. It is not a frontend theme, but rather a governance and reference framework that ensures consistency across Zero and One themes.

**What's Included:**

- **Documentation**
  - Theme overview and scopes (README.md)
  - Naming conventions (Filament, auth, governance)
  - Architecture rules (standards for Zero & One)
  - Agent discipline (how AI agents should work)
  - Code redundancy audits
  - Changelog and version tracking
  - Release marketing standards
  - Second brain (knowledge base)

- **Governance Framework**
  - Filament admin configuration guidelines
  - Permission and role naming conventions
  - Team/multi-tenancy boundaries
  - Laravel version upgrade path
  - Dependency tracking

- **Related Files**
  - `architecture-rules.md` — Design standards
  - `agent-confidence-discipline.md` — Agent behavior
  - `agent-confidence-protocol.md` — Agent verification
  - `agent-edit-discipline.md` — Code edit standards
  - `code-redundancy-audit.md` — Quality checks
  - `duplicate_methods_report.md` — Refactoring candidates
  - `filament-version.md` — Filament tracking
  - `filament-resource-schemas-tables.md` — Filament patterns
  - `laravel-13-composer-boundary.md` — Laravel bounds
  - `laravel-13-upgrade.md` — Upgrade path
  - `release-marketing-standard.md` — Release checklist
  - `spatie-permission-team-context.md` — Auth patterns
  - `spatie-permission-teams-boundary.md` — Multi-tenancy
  - `context-compression.md` — Token optimization

- **Wiki Structure** (if present)
  - Compiled knowledge base
  - Concept definitions
  - Entity documentation
  - Decision records

**What's NOT Included:**
- ✗ No frontend Blade components
- ✗ No public pages
- ✗ No CSS/JavaScript assets
- ✗ No `package.json` or build tools
- ✗ No Filament resources (just naming guidelines)
- ✗ No active Filament admin UI

**Relationship to Zero & One:**
- **Zero** = Complete, styled frontend theme
- **One** = Minimal skeleton theme
- **Three** = Governance backbone (rules both follow)

**Documentation Standards:**
- All `.md` files have YAML frontmatter
- Italian language for main documentation
- Consistent title format: `Title — Three Theme`
- Standardized tagging system
- Cross-references to Zero/One when applicable

**Governance Highlights:**
- Filament resource naming patterns
- Permission structure (`create_*`, `edit_*`, `delete_*`)
- Agent discipline for AI-assisted development
- Code quality gates (PHPStan L10, PHPMD)
- Changelog discipline

**Known Limitations:**
- Three is **documentation only** (not directly deployable)
- Filament configuration is guidance, not code
- No automated policy enforcement (manual audits)
- Wiki may be incomplete (accumulated knowledge)

**Integration with Laraxot PTVX:**
- Three docs are referenced by Zero and One
- Governance rules apply to all themes
- Naming conventions shared across themes (with theme-specific extensions)
- Changelog coordinated with main project CHANGELOG.md

---

## Documentation Lifecycle

### Introduced in v1.0.0

| Document | Type | Status | Purpose |
|----------|------|--------|---------|
| README.md | Index | Active | Documentation map |
| naming-conventions.md | Reference | Active | Filament + governance naming |
| architecture-rules.md | Guide | Active | Design standards |
| agent-*.md | Discipline | Active | AI agent behavior |
| code-redundancy-audit.md | Audit | Active | Quality checks |
| filament-version.md | Reference | Active | Filament tracking |
| changelog.md | Reference | Active | Version history |
| release-marketing-standard.md | Guide | Active | Release process |
| spatie-permission-*.md | Reference | Active | Auth patterns |
| laravel-13-*.md | Guide | Active | Laravel upgrade |
| second-brain.md | Index | Active | Knowledge base |

### Deprecated Documents

None yet (v1.0.0).

---

## Governance Policy Updates

### v1.0.0 Policy Baseline

- **PHPStan Level**: 10 (strict static analysis)
- **Coding Standard**: PSR-12
- **Naming Convention**: Established (see naming-conventions.md)
- **Permission Pattern**: `{action}_{resource}` (Spatie)
- **Team Model**: Multi-tenant via `Spatie\Permission\Models\Role`
- **Filament Version**: 3.0+ (tracked in filament-version.md)
- **Laravel Version**: 13+ (minimum)

### Policy Versioning

Policy changes that warrant a **minor version bump**:
- New naming convention
- New architecture rule
- New governance standard

Policy changes that warrant a **major version bump**:
- Breaking change in naming (e.g., all existing files affected)
- Breaking change in permission structure
- Breaking change in multi-tenancy model

---

## FAQ: Governance Updates

**Q: When should I update Three's changelog?**
A: When governance rules change, new standards are adopted, or Filament/Laravel versions update.

**Q: How does Three versioning affect Zero and One?**
A: Three's version is independent. Zero and One can bump versions without Three changing. However, if Three introduces breaking changes, both Zero and One must update.

**Q: What happens if governance rules conflict between themes?**
A: Three is authoritative. Zero and One override with theme-specific rules, but only if documented in their own changelogs.

**Q: Is Three's documentation a source of truth?**
A: Yes. Three's docs are referenced by Zero, One, and the main project. Changes to Three require coordination.

---

## Release Checklist for Three

When preparing a governance release:

- [ ] Update version in root `README.md` (if applicable)
- [ ] Update `CHANGELOG.md` (this file) with new version
- [ ] Update `docs/README.md` with index of changed docs (if docs added)
- [ ] Review all `.md` files for consistency
- [ ] Verify YAML frontmatter on all docs
- [ ] Check cross-references to Zero/One (still valid?)
- [ ] Run Markdown linter (if tool available)
- [ ] Spell-check documentation (Italian)
- [ ] Update `wiki/` if knowledge base changed
- [ ] Notify Zero and One theme maintainers (if breaking changes)
- [ ] Create git tag: `git tag -a v1.0.0 -m "Release v1.0.0 — governance & docs"`
- [ ] Push to remote: `git push origin v1.0.0`

---

## Breaking Changes Timeline

None planned for v1.0.

**Future considerations (v2.0+):**
- Possible: Filament 4.0 adoption (if breaking)
- Possible: Permission model redesign (if needed)
- Possible: Multi-tenancy pattern update

---

## Documentation Sync Schedule

To keep Three, Zero, and One consistent:

- **Monthly**: Review naming-conventions.md across all themes
- **Quarterly**: Audit architecture-rules.md alignment
- **Per release**: Update CHANGELOG files together
- **Per major change**: Notify all theme teams

---

## References

- [README.md](./README.md) — Three theme overview
- [Architecture Rules](./architecture-rules.md) — Design standards
- [Naming Conventions](./naming-conventions.md) — Naming guidelines
- [../README.md](../README.md) — Root Three README
- [Zero Changelog](../../../Zero/docs/changelog.md) — Zero version history
- [One Changelog](../../../One/docs/changelog.md) — One version history
- [Filament Documentation](https://filamentphp.com/docs)
- [Spatie Laravel Permissions](https://spatie.be/docs/laravel-permission)
- [Laravel Governance](../../../docs/wiki/) — Project-wide governance
