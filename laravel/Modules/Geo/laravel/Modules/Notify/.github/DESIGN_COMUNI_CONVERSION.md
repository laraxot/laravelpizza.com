# Design Comuni Pages Conversion Project

> **Goal**: Convert all 32 Design Comuni pages from Bootstrap Italia to Tailwind CSS + Alpine.js  
> **Status**: 🚀 Phase 2 (CSS + Alpine implementation starting)  
> **Progress**: HTML structure verified ✅ | CSS/Alpine in progress 🔄

---

## 📊 Project Overview

### Pages to Convert: 32
- **Sito** (9 pages): homepage, domande-frequenti, risultati-ricerca, argomenti, argomento, lista-risorse, lista-categorie, lista-risorse-categorie, mappa-sito
- **Amministrazione** (10 pages): amministrazione, aree-amministrative, area-amministrativa-dettaglio, organo, persona, persona-dettaglio, ufficio, ufficio-dettaglio, enti-e-fondazioni, ente-dettaglio
- **Data** (3 pages): documenti-dati, documento-dettaglio, dataset-dettaglio
- **News** (2 pages): novita, novita-dettaglio
- **Services** (3 pages): servizi, servizi-categoria, servizio-dettaglio
- **Events** (2 pages): eventi, evento-dettaglio
- **Places** (2 pages): luoghi, luogo-dettaglio
- **Other** (1 page): contatti

### Reference Design
- https://italia.github.io/design-comuni-pagine-statiche/

### Local Implementation
- Base URL: http://127.0.0.1:8000/it/tests/
- Blade template: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- Config system: JSON-driven content in `laravel/config/local/fixcity/database/content/pages/`

---

## 🎯 Current Status

### Phase 1: Analysis ✅ COMPLETE
- [x] HTML structure verification (99% match across all 32 pages)
- [x] Reference design documentation
- [x] Component identification
- [x] Bootstrap Italia class extraction

### Phase 2A: CSS Mapping 🔄 IN PROGRESS
- [ ] Create comprehensive Bootstrap Italia → Tailwind mapping
- [ ] Identify 12 core components to style
- [ ] Document responsive design patterns
- [ ] Create CSS implementation plan

### Phase 2B: CSS Implementation ⏳ PENDING
- [ ] Update component templates with Tailwind classes
- [ ] Create faq-replication.css with @apply rules
- [ ] Test responsive breakpoints
- [ ] Verify no Bootstrap Italia classes

### Phase 3: Alpine.js ⏳ PENDING
- [ ] Implement accordion toggle
- [ ] Implement search/filter
- [ ] Implement form interactions
- [ ] Add keyboard navigation
- [ ] Test accessibility

### Phase 4: Testing & QA ⏳ PENDING
- [ ] Screenshot comparisons
- [ ] Visual regression testing
- [ ] Accessibility audit (WCAG)
- [ ] Browser compatibility
- [ ] Performance testing

### Phase 5: Deployment ⏳ PENDING
- [ ] Final build: `npm run build && npm run copy`
- [ ] Comprehensive testing
- [ ] Documentation finalization
- [ ] Merge to main

---

## 📂 Documentation

### Main Resources
- [🗂️ Master Index](./laravel/Themes/Sixteen/docs/DESIGN_COMUNI_REPLICATION_INDEX.md)
- [📋 Strategy & Phases](./laravel/Themes/Sixteen/docs/implementation/STRATEGY.md)
- [👥 Team Coordination](./laravel/Themes/Sixteen/docs/implementation/TEAM_COORDINATION.md)
- [📊 Reference Analysis](./laravel/Themes/Sixteen/docs/analysis/REFERENCE_DESIGN_ANALYSIS.md)

### Per-Page Issues
Each page has a dedicated GitHub issue:
- Search: `label:design-comuni`
- View all: [Design Comuni Issues](../../issues?q=label%3Adesign-comuni)
- View discussions: [Design Comuni Discussions](../../discussions?discussions_q=Design+Comuni)

### Quick Links
- 🎨 [Component Catalog](./laravel/Themes/Sixteen/docs/COMPONENT_CATALOG.md)
- 🔧 [Development Guide](./laravel/Themes/Sixteen/docs/DEVELOPMENT.md)
- 📸 [Screenshots Folder](./laravel/Themes/Sixteen/docs/screenshots/)
- 🧪 [Testing Guide](./laravel/Themes/Sixteen/docs/TESTING.md)

---

## 🚀 Getting Started

### For New Contributors
1. Browse [open issues with label `design-comuni`](../../issues?q=label%3Adesign-comuni)
2. Pick a page/component
3. Assign yourself to issue
4. Work through checklist
5. Create PR when done
6. Link to issue

### Tech Stack
- **CSS**: Tailwind CSS (no Bootstrap Italia)
- **JS**: Alpine.js for interactions
- **Framework**: Laravel + Folio + Volt
- **Build**: Vite, npm scripts
- **Testing**: Playwright, Lighthouse

### Commands
```bash
# Install dependencies
cd laravel/Themes/Sixteen
npm install

# Build CSS/JS
npm run build

# Copy assets to public_html
npm run copy

# Test in browser
open http://127.0.0.1:8000/it/tests/

# Run tests
npm run test
```

---

## 📊 Progress Tracking

### By Category
| Category | Pages | HTML ✅ | CSS 🔄 | Alpine ⏳ | Testing ⏳ | Total |
|----------|-------|--------|--------|-----------|-----------|-------|
| Sito | 9 | 9 | 0 | 0 | 0 | 0% |
| Amministrazione | 10 | 10 | 0 | 0 | 0 | 0% |
| Data | 3 | 3 | 0 | 0 | 0 | 0% |
| News | 2 | 2 | 0 | 0 | 0 | 0% |
| Services | 3 | 3 | 0 | 0 | 0 | 0% |
| Events | 2 | 2 | 0 | 0 | 0 | 0% |
| Places | 2 | 2 | 0 | 0 | 0 | 0% |
| Other | 1 | 1 | 0 | 0 | 0 | 0% |
| **TOTAL** | **32** | **32 (100%)** | **0 (0%)** | **0 (0%)** | **0 (0%)** | **0%** |

### By Phase
- ✅ Phase 1: 100% (Analysis)
- 🔄 Phase 2A: 0% (CSS Mapping)
- ⏳ Phase 2B: 0% (CSS Implementation)
- ⏳ Phase 3: 0% (Alpine.js)
- ⏳ Phase 4: 0% (Testing)
- ⏳ Phase 5: 0% (Deployment)

---

## 🤝 Team & Coordination

### Multi-Agent Approach
- **CSS Team**: Bootstrap → Tailwind mapping + implementation
- **Alpine Team**: Interactions and animations
- **QA Team**: Screenshots, testing, validation
- **Docs Team**: Analysis, guides, index maintenance

### Communication
- **GitHub Issues**: Per-page coordination
- **GitHub Discussions**: Real-time team coordination
- **Docs**: [TEAM_COORDINATION.md](./laravel/Themes/Sixteen/docs/implementation/TEAM_COORDINATION.md)

### Daily Standup
Teams post status in issue comments:
- ✅ Completed tasks
- �� In-progress tasks
- ⏸️ Blockers
- 📌 Next steps

---

## 🎓 Design System Reference

- **Bootstrap Italia**: https://italiadesignsystem.it/
- **Tailwind CSS**: https://tailwindcss.com/
- **Alpine.js**: https://alpinejs.dev/
- **WCAG Accessibility**: https://www.w3.org/WAI/WCAG21/quickref/

---

## ❓ FAQ

**Q: Why 32 pages?**  
A: All pages at https://italia.github.io/design-comuni-pagine-statiche/sito/ need conversion

**Q: Already 99% HTML match - why convert CSS?**  
A: Reference uses Bootstrap Italia (heavy/complex). Local uses Tailwind (lightweight/modern).

**Q: How long will this take?**  
A: ~21 hours effort with full parallelized team. ~4-5 days total.

**Q: Can I work on just one page?**  
A: Yes! Pick an issue, work through the checklist, create PR. Each page is independent.

**Q: What about multi-step forms?**  
A: Same approach: identify components, style once, reuse everywhere.

---

## 📞 Support & Escalation

- 🐛 **Bug Report**: Create issue with label `bug`
- 💡 **Question**: Use issue comment or GitHub discussion
- 🆘 **Blocker**: Tag maintainers in issue
- 📚 **Documentation**: Update relevant docs file

---

## Useful Commands

```bash
# Search for Bootstrap Italia classes in output
curl -s http://127.0.0.1:8000/it/tests/domande-frequenti | grep -o 'class="[^"]*"' | sort | uniq

# Run analysis on specific page
python3 bashscripts/compare/page-analyzer.py \
  "https://italia.github.io/design-comuni-pagine-statiche/sito/argomenti.html" \
  "http://127.0.0.1:8000/it/tests/argomenti" \
  "argomenti"

# View all created issues
gh issue list -L 100 -l design-comuni

# Create issue locally (for testing)
gh issue create --title "[Design Comuni] test page" --label design-comuni
```

---

**Project Started**: 2026-04-03  
**Maintained By**: Copilot CLI + Multi-Agent Team  
**Last Updated**: 2026-04-03
