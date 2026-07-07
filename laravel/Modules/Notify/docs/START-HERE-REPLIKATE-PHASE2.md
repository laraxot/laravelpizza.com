# 🚀 START HERE - REPLIKATE Phase 2

**Status**: Phase 1 Analysis Complete ✅  
**Your Job**: Execute Phase 2 - HTML Structure Fixes ⏳  
**Time Estimate**: ~50 minutes

---

## 📍 You Are Here

```
REPLIKATE Project Lifecycle
├── Phase 1: Analysis ✅ COMPLETE
│   └── Output: Detailed documentation of all problems
│
├── Phase 2: HTML Fixes ⏳ YOUR JOB
│   ├── Task 1: Add section#head-section
│   ├── Task 2: Verify navbar toggler
│   ├── Task 3: Add/remove CSS classes
│   └── Task 4: Build and validate
│
├── Phase 3: CSS/JS Styling (future)
│   └── Tailwind + Alpine.js implementation
│
└── Phase 4: Final Testing (future)
    └── Responsive + i18n validation
```

---

## 📖 What To Read (In Order)

### 1️⃣ Navigation Hub (5 min read)
📍 **File**: `laravel/Themes/Sixteen/docs/REPLIKATE-MASTER-INDEX.md`

This is your master navigation. It explains:
- What Phase 1 found
- What you need to do in Phase 2
- Where all the files are
- How to use them

### 2️⃣ Detailed Analysis (10 min read)
📍 **File**: `laravel/Themes/Sixteen/docs/design-comuni/pages/homepage-structure-diff.md`

This document contains:
- Exact HTML differences (structure only, no formatting)
- **4 Priority 1 tasks** (CRITICAL - do these first)
- **2 Priority 2 tasks** (HIGH - do after priority 1)
- Complete lists of missing/extra CSS classes
- Code examples for each fix

### 3️⃣ Execution Protocol (5 min read)
📍 **File**: `laravel/Themes/Sixteen/docs/prompts/replikate.txt`

Understand the rules:
- HTML FIRST (structure before styling)
- CSS LAST (only after HTML is correct)
- DRY principle (reusable blocks)
- Block system (generic, not page-specific)

---

## ✅ Your 4 Main Tasks

### Task 1: Add Missing `section#head-section` [CRITICAL]

**File to Edit**:
```
laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php
```

**What**: Add a new section right after `<main>` tag

**Why**: The entire "Featured Content" section is missing from local version

**Exact Code**: See section "FIX HTML (PRIMA DI TUTTO)" in `homepage-structure-diff.md`

**Time**: ~15 minutes

---

### Task 2: Verify Navbar Toggler Button

**File to Check**:
```
laravel/Themes/Sixteen/resources/views/components/header.blade.php
(or wherever navbar is defined)
```

**What**: Ensure button structure matches reference exactly

**Time**: ~5 minutes

---

### Task 3: Add Missing CSS Classes & Remove Bootstrap

**Classes to Add** (33 total):
```
border-bottom, mb-5, flex-column, flex-lg-row, fw-bold, fw-normal,
btn-full, btn-next, card-image-wrapper, col-lg-6, and 23 more...
```

See: `homepage-structure-diff.md` → "CLASSI CSS MANCANTI"

**Classes to Remove** (25 total):
```
col-lg-4, col-sm-6, form-check-input, form-check-label,
card-footer, it-grid-item-wrapper, and 19 more...
```

See: `homepage-structure-diff.md` → "CLASSI CSS EXTRA IN LOCAL"

**Time**: ~20 minutes

---

### Task 4: Build and Validate

```bash
cd laravel/Themes/Sixteen

# Build the theme
npm run build

# Copy assets
npm run copy

# Clear cache
php artisan optimize:clear

# Verify (use automation)
cd ../.. && bash bashscripts/design-analysis/replikate-workflow.sh homepage all
```

**What to Check**:
- HTML structure match ≥90%
- No errors in build output
- CSS loads correctly
- All assets copied

**Time**: ~10 minutes

---

## 🧭 Quick Reference

### Important Paths

```
Blade Template:
  laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php

JSON Content:
  laravel/config/local/fixcity/database/content/pages/tests.homepage.json

CSS Files:
  laravel/Themes/Sixteen/resources/css/

Block Components:
  laravel/Themes/Sixteen/resources/views/components/blocks/

Reference URL:
  https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html

Local URL:
  http://127.0.0.1:8000/it/tests/homepage
```

### Useful Commands

```bash
# Go to project
cd /var/www/_bases/base_fixcity_fila5

# View analysis results
cat /tmp/replikate_analysis_homepage/structure-analysis.txt

# Re-run analysis after your changes
bash bashscripts/design-analysis/replikate-workflow.sh homepage all

# Start local server
cd laravel && php artisan serve

# View reference
open https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html

# View local
open http://127.0.0.1:8000/it/tests/homepage
```

---

## 📋 Checklist Before Starting

- [ ] Read `REPLIKATE-MASTER-INDEX.md`
- [ ] Read `homepage-structure-diff.md` completely
- [ ] Read `replikate.txt` (understand HTML FIRST principle)
- [ ] Know where `[slug].blade.php` is
- [ ] Understand what `section#head-section` should contain
- [ ] Have list of 33 missing CSS classes
- [ ] Have list of 25 Bootstrap classes to remove
- [ ] Know how to run `npm run build && npm run copy`

---

## 🎯 Success Criteria

✅ When you're done with Phase 2:

1. **HTML structure ≥90% match** (tested via automation script)
2. **No errors in build output**
3. **All CSS loads correctly**
4. **Local page looks structurally similar to reference**
5. **All tasks documented in comments**
6. **Screenshots before/after saved** (optional but recommended)

---

## 💡 Key Principles

Remember REPLIKATE rules:

| Rule | Means |
|------|-------|
| **HTML FIRST** | Fix structure before touching CSS |
| **CSS LAST** | Only modify CSS after HTML is correct |
| **NO Bootstrap** | Use Tailwind @apply instead |
| **DRY** | One blade file, reusable blocks |
| **KISS** | Blade=structure, JSON=content, CSS=style |

---

## 🚨 Common Mistakes to Avoid

❌ **DON'T** touch CSS before HTML is fixed  
❌ **DON'T** add Bootstrap classes  
❌ **DON'T** hardcode text in blade (use JSON)  
❌ **DON'T** skip reading the analysis document  
❌ **DON'T** modify multiple components at once (test each change)  

✅ **DO** follow tasks in order  
✅ **DO** test after each change  
✅ **DO** use automation script to verify  
✅ **DO** document what you changed  
✅ **DO** ask if something is unclear  

---

## 📞 Getting Help

All information you need is documented:

1. **What to do**: `homepage-structure-diff.md`
2. **How to do it**: `replikate.txt`
3. **Where files are**: `REPLIKATE-MASTER-INDEX.md`
4. **Automation tool**: `bashscripts/design-analysis/replikate-workflow.sh`

---

## 🏁 When You're Done

1. Verify HTML match ≥90% using automation script
2. Take screenshots (before/after)
3. Update `homepage-structure-diff.md` with "COMPLETED" status
4. Document any issues encountered
5. Record results in this session's todo list

---

## 🎓 Remember

This is NOT just copying code. You're:

1. **Fixing structure** (Blade template)
2. **Matching classes** (CSS classnames)
3. **Following a protocol** (REPLIKATE framework)
4. **Creating reusable code** (DRY principle)

Everything is automated, documented, and organized.

**You have all the information you need.**

Just follow the 4 tasks in order and test as you go.

---

## 🚀 Start Now

1. Open `laravel/Themes/Sixteen/docs/REPLIKATE-MASTER-INDEX.md`
2. Read it thoroughly
3. Open `homepage-structure-diff.md`
4. Follow Task 1-4
5. Test with automation script
6. Document results

**Good luck!** 🎉

---

**Status**: Ready to Start  
**Phase**: 2 - HTML Structure Fixes  
**Time**: ~50 minutes  
**Difficulty**: Medium (Clear instructions provided)  

---

**Questions?**  
Read the documentation. Everything is answered there.

---

Last Updated: 2026-04-07  
Maintained By: REPLIKATE System
