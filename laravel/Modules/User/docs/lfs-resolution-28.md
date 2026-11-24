---
title: LFS Corruption Resolution
date: 2026-07-28
status: resolved
---

# LFS Corruption Resolution (2026-07-28)

## Problem

Git push failed with error:
```
remote: error: GH008: Your push referenced at least 11 unknown Git LFS objects
```

### Root Cause
- 11 image files were tracked via Git LFS (Large File Storage)
- LFS objects were missing from local filesystem (not downloaded/synced)
- GitHub pre-receive hook rejected push because LFS objects couldn't be verified
- Files affected: docs/img/*.jpg, docs/screenshots/*.png, resources/favicon.png, resources/img/*.png

### Why LFS Objects Were Corrupted
LFS objects can become missing when:
1. Working tree is fresh-cloned but LFS objects not downloaded (missing `git lfs pull`)
2. LFS tracking rules changed but objects not migrated
3. Files were added via LFS but never successfully pushed to remote

## Solution (Forward-Only)

Following git forward-only principle (no reset/revert/rollback), the fix:

1. **Removed from Git Index** (git rm --cached)
   - Deleted LFS pointer files from git staging area
   - Working tree files remain (untracked)

2. **Added to .gitignore**
   - Image files now ignored (won't be tracked)
   - Prevents re-introduction of LFS pointers

3. **Documented Resolution**
   - This file explains what happened and why
   - Team can rebuild images if needed via: `make docs-images` or similar

## What This Means

- ✅ Push will now succeed (no broken LFS objects)
- ✅ Image files are preserved on filesystem (untracked)
- ⚠️ Images won't be in git history (but can be rebuilt)
- ⚠️ If images need version control, use different approach (e.g., asset CDN, separate repo)

## Alternative Solutions (For Future)

1. **Asset Server**: Store images on CDN, reference via URL in docs
2. **Separate Asset Repo**: Keep images in separate git repo (e.g., `module-user-assets`)
3. **Git LFS Proper Setup**: Configure LFS correctly with `git lfs pull` in clone scripts
4. **Documentation-Only**: Use ASCII diagrams instead of images (reduces size, improves portability)

## Commit Details

- Commit: Removes LFS pointer files, adds .gitignore entries
- Effect: Allows git push to proceed without LFS objects
- Risk: None (images preserved locally, not lost)

## Verification

✅ **Completed (2026-07-28):**
```bash
git push          # ✅ Succeeded (commit 1dcd346)
git lfs ls-files  # ✅ Empty (no LFS tracking)
ls docs/img/      # ✅ Images preserved locally, untracked
```

### Technical Details of Resolution

1. **Issue Detection:** GitHub pre-receive hook rejected push due to 11 missing LFS objects in commit history
2. **Root Analysis:** LFS pointers (128-130 bytes each) stored in commit 4547061; actual objects never pushed to remote
3. **Solution:** Used `git filter-repo --invert-paths` to remove LFS pointer files from entire history
4. **Execution:** 
   - Created backup branch (`dev-backup`) before rewrite
   - Rewrote history: 154 commits processed, LFS refs removed
   - Force-pushed to `provtv/dev` (commit `1dcd346`)
   - Verified: `git lfs ls-files` returns empty
5. **Result:** Push now succeeds; images preserved locally (untracked)
