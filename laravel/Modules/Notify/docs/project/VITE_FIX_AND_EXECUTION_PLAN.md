# 🚀 FixCity Improvement + Vite Fix - EXECUTION PLAN

**Date**: 2026-03-30  
**Status**: ✅ **READY TO EXECUTE**  
**AI Tools**: OpenViking + BMAD + GSD + Ralph Loop + NotebookLM + NotebookLM MCP

---

## 🎯 Today's Priorities

### P0.0: Install NotebookLM MCP ✅ COMPLETE

**Status**: ✅ Installed for Claude Code  
**Command Used**: `claude mcp add notebooklm npx notebooklm-mcp@latest`  
**Config**: `~/.claude.json` (local project config)

**Next Steps**:
1. Authenticate: "Log me in to NotebookLM"
2. Create notebook with FixCity docs
3. Share → Copy link
4. Add to library: "Add [LINK] to my NotebookLM library"

---

### P0.1: Fix Vite Manifest Error 🔴 CRITICAL

**Error**:
```
Vite manifest not found at: /var/www/_bases/base_fixcity_fila5/public_html/themes/<nome tema>/manifest.json
```

**Root Cause Analysis**:
- Vite build not run or build output missing
- Assets not published to public_html
- Theme build pipeline not executed
- Manifest.json not generated during build

**Solution** (DRY + KISS):

```bash
# For EACH theme (Sixteen, TwentyOne)
cd laravel/Themes/Sixteen

# 1. Update dependencies (fixes version conflicts)
composer update -W

# 2. Install Node dependencies
npm install

# 3. Build assets (generates manifest.json)
npm run build

# 4. Copy assets to public_html
npm run copy

# Verify manifest exists
ls -la public_html/themes/Sixteen/manifest.json
```

**Why This Works**:
- `composer update -W`: Updates PHP dependencies with wide dependencies
- `npm install`: Installs correct Node packages from package.json
- `npm run build`: Vite builds assets → generates manifest.json
- `npm run copy`: Copies built assets to public_html/themes/<theme>/

**AI Tool Assignment**:
- **Ralph Loop**: Autonomous execution for both themes
- **OpenViking**: Track progress
- **NotebookLM**: Research Vite best practices

**Execution Command**:
```bash
# Ralph Loop autonomous execution
cat > .ralph/vite-fix.json << 'EOF'
{
  "task": "Fix Vite manifest for all themes",
  "steps": [
    "cd laravel/Themes/Sixteen && composer update -W && npm install && npm run build && npm run copy",
    "cd laravel/Themes/TwentyOne && composer update -W && npm install && npm run build && npm run copy",
    "Verify manifests exist",
    "Test site loading"
  ],
  "verify": "ls -la public_html/themes/*/manifest.json"
}
EOF

./.ralph/ralph-loop.sh .ralph/vite-fix.json true
```

**Expected Output**:
```
✅ Sixteen manifest.json created
✅ TwentyOne manifest.json created
✅ Site loads correctly
```

**Time Estimate**: 15-20 minutes (build time included)

---

### P0.2: FixCity Italian Site Improvement 🟡 ONGOING

See: `.planning/improvements/FIXCITY_IT_IMPROVEMENT_PLAN.md`

**Current Phase**: Phase 0 Foundation (Weeks 1-2)

**P0 Tasks** (60h total):
- [x] P0.0: NotebookLM MCP installed ✅
- [ ] P0.1: Vite manifest fix (20min) - **DO THIS FIRST**
- [ ] P0.2: Test syntax fixes (4h) - Ralph Loop
- [ ] P0.3: Italian translations (16h) - Qwen + NotebookLM
- [ ] P0.4: Eager loading (8h) - Claude
- [ ] P0.5: Accessibility (12h) - Ralph Loop
- [ ] P0.6: Documentation (20h) - Qwen

---

## 📋 Step-by-Step Execution

### Step 1: Fix Vite Manifest (NOW - 20min)

```bash
# Navigate to project
cd /var/www/_bases/base_fixcity_fila5

# Fix Sixteen theme
cd laravel/Themes/Sixteen
composer update -W    # ~5min
npm install           # ~2min
npm run build         # ~3min
npm run copy          # ~1min

# Verify
ls -la public_html/themes/Sixteen/manifest.json
# Should show manifest.json

# Fix TwentyOne theme
cd ../TwentyOne
composer update -W
npm install
npm run build
npm run copy

# Verify
ls -la public_html/themes/TwentyOne/manifest.json

# Test site
firefox http://fixcity.local/it
# Should load without Vite errors
```

**OpenViking Update**:
```bash
openviking add-memory "P0.1 Vite manifest fixed for Sixteen and TwentyOne"
```

---

### Step 2: Initialize GSD Phase 0 (5min)

```bash
# Start GSD
/gsd-new-milestone Phase_0_Foundation

# Discuss first task
/gsd-discuss-phase 0.1

# Plan task
/gsd-plan-phase 0.1
```

---

### Step 3: Execute P0.2 Test Fixes with Ralph (4h)

```bash
# Setup Ralph PRD
cat > .ralph/test-fixes.json << 'EOF'
{
  "task": "Fix test syntax errors",
  "target": "All test files with syntax errors",
  "verify": "php artisan test --stop-on-failure"
}
EOF

# Execute
./.ralph/ralph-loop.sh .ralph/test-fixes.json true
```

---

### Step 4: NotebookLM Integration (Ongoing)

```bash
# 1. Authenticate (one-time)
"Log me in to NotebookLM"

# 2. Create notebook
# Go to notebooklm.google.com
# Create: "FixCity Documentation"
# Upload: AGENTS.md, docs/**/*.md, .planning/**/*.md
# Share → Copy link

# 3. Add to library
"Add [LINK] to my NotebookLM library"

# 4. Research
"Research Laravel Vite build best practices"
"Query FixCity docs about theme configuration"
```

---

## 🤖 AI Tool Coordination

| Tool | Task | Timeline | Status |
|------|------|----------|--------|
| **NotebookLM MCP** | P0.0 installed | ✅ Done | Ready |
| **Ralph Loop** | P0.1 Vite fix | 20min | ⏳ Next |
| **Ralph Loop** | P0.2 Test fixes | 4h | ⏳ Pending |
| **Qwen** | P0.3 Translations | 16h | ⏳ Pending |
| **Claude** | P0.4 Eager loading | 8h | ⏳ Pending |
| **OpenViking** | Context tracking | Ongoing | ✅ Active |
| **BMAD** | Requirements | Week 3+ | ⏳ Pending |
| **GSD** | Phase execution | Ongoing | ✅ Active |

---

## 📊 Success Metrics

### Immediate (Today)

- [x] NotebookLM MCP installed ✅
- [ ] Vite manifest fixed ✅
- [ ] Site loads without errors ✅
- [ ] GSD Phase 0 initialized ✅

### Week 1

- [ ] Test syntax errors fixed
- [ ] Italian translations 50% complete
- [ ] Eager loading implemented
- [ ] Accessibility quick wins done

### Week 2

- [ ] Phase 0 complete (all P0 tasks)
- [ ] Documentation consolidated
- [ ] Ready for Phase 1

---

## 🎯 DRY + KISS Principles

### DRY (Don't Repeat Yourself)

✅ **Single execution plan**: This document  
✅ **Cross-reference**: Link to existing docs  
✅ **Shared context**: OpenViking for all tools  
✅ **One manifest fix**: Same command for both themes

### KISS (Keep It Simple, Stupid)

✅ **Simple commands**: Copy-paste ready  
✅ **Clear priorities**: P0.0, P0.1, P0.2  
✅ **Single verification**: `ls manifest.json`  
✅ **Straightforward workflow**: Fix → Test → Commit

---

## 📝 Commands Quick Reference

### Vite Fix
```bash
cd laravel/Themes/<theme>
composer update -W && npm install && npm run build && npm run copy
```

### Ralph Loop
```bash
./.ralph/ralph-loop.sh <task.json> true
```

### GSD
```bash
/gsd-new-milestone <name>
/gsd-discuss-phase <number>
/gsd-plan-phase <number>
/gsd-execute-phase <number>
```

### OpenViking
```bash
openviking add-memory "<update>"
openviking search "<query>"
openviking ls /memories/
```

### NotebookLM MCP
```bash
# Authenticate
"Log me in to NotebookLM"

# Add notebook
"Add [LINK] to my NotebookLM library"

# Query
"Research [topic] in my FixCity docs"
```

---

## 🔍 Troubleshooting

### Vite Manifest Still Missing

```bash
# Check Node version
node -v  # Should be 18+

# Check npm version
npm -v  # Should be 9+

# Clear cache
npm cache clean --force
rm -rf node_modules package-lock.json
npm install

# Rebuild
npm run build
```

### Ralph Loop Not Working

```bash
# Check Ralph setup
ls -la .ralph/

# Verify PRD file
cat .ralph/task.json | jq .

# Run manually
bash .ralph/ralph-loop.sh
```

### NotebookLM Auth Issues

```bash
# In Claude chat
"Repair NotebookLM authentication"
# Or
"Clear NotebookLM browser data"
```

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **Vite Fix Guide** | This file (Section P0.1) |
| **Improvement Plan** | `.planning/improvements/FIXCITY_IT_IMPROVEMENT_PLAN.md` |
| **Execution Plan** | `.planning/improvements/EXECUTION_PLAN.md` |
| **NotebookLM MCP** | `~/.claude/skills/notebooklm/README.md` |
| **Start Here** | `FIXCITY_IMPROVEMENT_START_HERE.md` |

---

## ✅ Checklist

### Today

- [x] NotebookLM MCP installed
- [ ] Vite manifest fixed (Sixteen + TwentyOne)
- [ ] Site tested (http://fixcity.local/it)
- [ ] GSD Phase 0 initialized
- [ ] Ralph Loop started for test fixes

### This Week

- [ ] P0.2: Test syntax fixes complete
- [ ] P0.3: Italian translations 50%
- [ ] P0.4: Eager loading implemented
- [ ] P0.5: Accessibility quick wins
- [ ] P0.6: Documentation consolidated

---

**Status**: ✅ **READY TO EXECUTE**  
**Next Action**: Fix Vite manifest (20min)  
**Then**: GSD Phase 0 initialization  
**ETA Phase 0 Complete**: 2026-04-13

**Let's fix and improve FixCity! 🚀**
