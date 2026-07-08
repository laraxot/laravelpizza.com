# Design Comuni Conversion Roadmap

**Status**: 🟢 Phase 1 Complete - Visual Parity Assessment Done
**Last Updated**: 2026-04-03
**Target**: Make all 54 test pages visually identical to Design Comuni reference using Tailwind CSS + Alpine.js

---

## 📊 Executive Summary

### Current State
- ✅ All 54 pages assessed using visual height comparison
- ✅ 7 pages ready for immediate CSS fixes (95%+ parity)
- ✅ 8 more pages nearly ready (85-95% parity)
- ⏳ 38 pages need structural investigation (<80% parity)

### Key Metrics
```
🔴 100% Perfect:      1 page   (persona)
🟠 95-99% Ready:      6 pages  
⚠️  90-94% Good:       4 pages
⚠️  85-89% Fair:       4 pages
🔵 <85% TBD:         39 pages
```

### Time Estimate
- **Quick wins (7 pages)**: 2-3 days
- **Medium work (8 pages)**: 3-5 days
- **Structural fixes (39 pages)**: 2+ weeks
- **Total**: 3-4 weeks (with parallel teams)

---

## 🎯 Phase Breakdown

### Phase 1: Quick Wins (Start Immediately) ⭐
**Duration**: 2-3 days | **Effort**: Low | **ROI**: High

**Pages** (7 total):
1. persona - 100% (0px diff)
2. appuntamento-01-ufficio - 99% (16px diff)
3. risultati-ricerca - 98% (90px diff)
4. assistenza-02-conferma - 97% (64px diff)
5. segnalazione-01-privacy - 97% (60px diff)
6. domande-frequenti - 96% (121px diff)
7. assistenza-01-dati - 95% (162px diff)

**Tasks**:
- [ ] Create GitHub issues (use `node bashscripts/github/create-design-issues.mjs`)
- [ ] Assign developers to each page
- [ ] Run detailed analysis on each page
- [ ] Identify specific CSS changes needed
- [ ] Apply fixes in parallel
- [ ] Verify with screenshots
- [ ] Commit with documentation

**Expected Outcome**: 7 pages at 99%+ visual parity

---

### Phase 2: Medium Work (Week 2) ⚡
**Duration**: 3-5 days | **Effort**: Medium | **ROI**: Medium

**Pages** (8 total):
- segnalazione-dettaglio (93%, 302px)
- homepage (92%, 350px)
- appuntamento-04-richiedente-autenticato (92%, 147px)
- appuntamento-04-richiedente (91%, 181px)
- argomenti (89%, 412px)
- appuntamento-03-dettagli (87%, 261px)
- appuntamento-06-conferma (87%, 385px)
- segnalazioni-elenco (85%, 490px)

**Tasks**:
- [ ] Detailed visual comparison for each page
- [ ] CSS difference analysis
- [ ] Identify container/section spacing issues
- [ ] Apply targeted fixes
- [ ] Build and verify (npm run build && npm run copy)
- [ ] Cross-browser testing

**Expected Outcome**: 15 total pages at 95%+ visual parity (28% conversion complete)

---

### Phase 3: Investigation & Structural Fixes (Week 3+) 🔍
**Duration**: 2+ weeks | **Effort**: High | **ROI**: Medium

**Problem Categories**:
1. **List/Pagination** (5 pages) - lista-risorse, documenti-dati, lista-categorie, etc.
2. **Detail Pages** (3 pages) - pagamento-dettaglio, novita-dettaglio, servizio-dettaglio
3. **Form Wizards** (4 pages) - prenotazione-appuntamento, richiesta-assistenza, segnalazione-disservizio
4. **Complex Layouts** (1 page) - servizi-categoria
5. **Completely Different** (1 page) - evento-dettaglio

**Required Tasks**:
- [ ] Deep HTML structure analysis for each page
- [ ] Identify if structural (template) changes needed
- [ ] Check if content/data is missing
- [ ] Plan CSS vs structural fixes
- [ ] Coordinate with template/data team if needed
- [ ] Implement fixes incrementally
- [ ] Test thoroughly

**Note**: Some pages may require changes beyond CSS (template or JSON data modifications)

---

## 📁 Documentation Structure

### For Every Page (Automated)
```
laravel/Themes/Sixteen/docs/pages/<page-name>/
├── DETAILED-ANALYSIS.md           # Metrics and recommendations
├── HTML-STRUCTURE-DIFF.md         # Element comparison
├── VISUAL-COMPARISON.md           # Screenshots
├── local-full.png                 # Full page local
├── reference-full.png             # Full page reference
├── local-viewport-1920.png        # Desktop local
├── reference-viewport-1920.png    # Desktop reference
├── local-viewport-768.png         # Tablet local
└── reference-viewport-768.png     # Tablet reference
```

### Theme-Level
```
laravel/Themes/Sixteen/docs/
├── INDEX.md                                    # Main index
├── COMPLETE-VISUAL-PARITY-REPORT.md          # All 54 pages
├── PRIORITY-MATRIX.json                       # Workload planning
├── visual-parity-data.json                    # Machine-readable data
├── CONTAINER-WIDTH-RESOLUTION.md              # Technical docs
├── SECTION-STRUCTURE-DIFF.md                  # Historical
└── GITHUB-ISSUES-MAPPING.json                 # Issue tracking
```

### Bash Scripts
```
bashscripts/docs/
├── INDEX.md                    # Tools overview
└── github-issues-batch.md      # GitHub CLI guide
```

---

## 🛠️ Tools & Commands

### Analysis
```bash
# Full batch assessment (all 54 pages, ~3-4 min)
node bashscripts/analysis/batch-visual-assessment-parallel.mjs

# Single page analysis
node bashscripts/analysis/page-detailed-analysis.mjs <page-name>

# Visual comparison (multi-viewport)
node bashscripts/analysis/generate-page-comparison.mjs <page-name>

# HTML structure diff
node bashscripts/analysis/html-structure-diff.mjs <page-name>
```

### Development
```bash
# Build CSS/JS
cd laravel/Themes/Sixteen
npm run build

# Copy to public
npm run copy

# View reports
cat laravel/Themes/Sixteen/docs/COMPLETE-VISUAL-PARITY-REPORT.md
cat laravel/Themes/Sixteen/docs/visual-parity-data.json
```

### GitHub Issues
```bash
# Create all 54 issues at once
node bashscripts/github/create-design-issues.mjs

# View issues
gh issue list --repo laraxot/base_fixcity_fila5 --label "design-comuni"

# Filter by priority
gh issue list --repo laraxot/base_fixcity_fila5 --label "priority:critical"
```

---

## 🔧 CSS Modification Workflow

### For Each Page:
1. **Analyze** → Run `page-detailed-analysis.mjs` to identify differences
2. **Screenshot** → Compare local vs reference side-by-side
3. **Identify** → Document CSS changes needed (spacing, colors, layout)
4. **Modify** → Edit `laravel/Themes/Sixteen/resources/css/app.css`
5. **Build** → Run `npm run build && npm run copy`
6. **Test** → View page at http://127.0.0.1:8000/it/tests/<page>
7. **Verify** → Take screenshot, compare with reference
8. **Iterate** → Repeat steps 3-7 until visual parity achieved
9. **Commit** → Git commit with before/after screenshots

### Key Files to Edit
- `laravel/Themes/Sixteen/resources/css/app.css` - Main CSS (line 852+ for variables)
- `laravel/Themes/Sixteen/resources/js/app.js` - Alpine.js interactions
- `laravel/Themes/Sixteen/tailwind.config.js` - Tailwind configuration

### Build Pipeline
```bash
cd laravel/Themes/Sixteen
npm run build    # ~2 seconds
npm run copy     # ~1 second
# New CSS hash appears in output (e.g., app-DCbieyUp.css)
```

---

## 📊 Success Metrics

### Phase 1 Complete
- [ ] 7 pages at 95%+ visual parity
- [ ] 7 GitHub issues marked complete
- [ ] Documentation generated for each page
- [ ] Build verified to work

### Phase 2 Complete
- [ ] 15 total pages at 95%+ visual parity
- [ ] All Phases 1-2 pages have before/after screenshots
- [ ] CSS changes documented with comments
- [ ] No build errors

### Full Conversion Complete
- [ ] All 54 pages at 95%+ visual parity
- [ ] Visual parity data.json shows all pages ≥95%
- [ ] All pages tested across responsive breakpoints
- [ ] Documentation complete and cross-linked
- [ ] No Bootstrap Italia used (Tailwind CSS + Alpine.js only)

---

## 🚀 Getting Started

### Today (Start Phase 1)
```bash
# 1. Review the analysis
cd /var/www/_bases/base_fixcity_fila5
cat laravel/Themes/Sixteen/docs/COMPLETE-VISUAL-PARITY-REPORT.md

# 2. Create GitHub issues
node bashscripts/github/create-design-issues.mjs

# 3. Pick a page (start with persona - 100% parity)
node bashscripts/analysis/page-detailed-analysis.mjs persona

# 4. View the analysis
open laravel/Themes/Sixteen/docs/pages/persona/DETAILED-ANALYSIS.md
```

### This Week (Complete Phase 1-2)
- Assign developers to pages 1-7
- Work through Phase 1 in parallel
- Start Phase 2 once Phase 1 is half done
- Commit daily with progress

### Next Week (Start Phase 3 Investigation)
- Form sub-team to investigate <80% parity pages
- Determine if structural changes needed
- Plan template/data modifications if required
- Continue CSS fixes on high-parity pages

---

## 📞 Communication

### Daily Standup
- Pages completed: List with parity %
- Blockers: Any issues with CSS fixes
- Next: What pages being worked on today
- Metrics: Progress toward Phase 1-2 complete

### Issue Tracking
- GitHub Issues: One per page (54 total)
- Labels: `design-comuni`, `priority:X`, `css-conversion`, `tailwind`
- Status: Use comment updates to track progress
- Screenshots: Attach before/after screenshots to issues

### Documentation
- Keep `docs/pages/<page>/DETAILED-ANALYSIS.md` updated
- Add CSS change notes directly in issues
- Link related issues (e.g., similar form pages)

---

## ⚠️ Important Notes

1. **No Bootstrap Italia** - Use only Tailwind CSS + Alpine.js
2. **CSS-Only Fixes** - Modify only CSS/JS, not HTML templates (unless absolutely needed)
3. **Build & Copy** - Always run `npm run build && npm run copy` to test changes
4. **Screenshots** - Compare local vs reference using same viewport (1920px default)
5. **Git Commits** - Include screenshot comparisons in commit descriptions
6. **Parallel Work** - Pages are independent, can be worked on simultaneously

---

## 📈 Progress Tracking

### Real-Time Metrics
```bash
# Current status
cat laravel/Themes/Sixteen/docs/COMPLETE-VISUAL-PARITY-REPORT.md | grep "Parity"

# JSON for dashboards
cat laravel/Themes/Sixteen/docs/visual-parity-data.json
```

### Automated Updates
- Run `batch-visual-assessment-parallel.mjs` weekly to track progress
- Compare output with previous run
- Update PRIORITY-MATRIX.json as pages are completed

---

## 🎓 Learning Resources

- **Design Comuni**: https://italia.github.io/design-comuni-pagine-statiche/
- **Tailwind CSS**: https://tailwindcss.com/
- **Alpine.js**: https://alpinejs.dev/
- **Internal Docs**: `laravel/Themes/Sixteen/docs/INDEX.md`
- **Tools Guide**: `bashscripts/docs/INDEX.md`

---

**Ready to start? Run this now:**
```bash
cd /var/www/_bases/base_fixcity_fila5
node bashscripts/github/create-design-issues.mjs
```

Then pick issue #1 and get coding! 🚀

