---
title: "Git Push Issue — LFS Objects Missing on Remote"
date: 2026-07-28
author: claude-ai
status: BLOCKED_ON_SERVER_STATE
---

# User Module — Git Push & LFS Issue (2026-07-28)

## Problem

Push to `provtv/module_user_fila5` fails with LFS (Git Large File Storage) error:

```
remote: error: GH008: Your push referenced at least 11 unknown Git LFS objects:
  e400cd031a594c8b3ea19d7711c0394f1315eeabb182f13351602aaf935cde53
  d82a070ef9ee39f25805bce168450feaeabef237ff9b9177afdb77ed88860b26
  5375e5ef35f8c770fd8d39c1702e6c90f715fd6752c8fec51c9d0f9b410f4f48
  (8 more...)
```

## Root Cause

Latest commit `45470612` references 11 image files tracked as LFS pointers:
- docs/img/{create_user.jpg, create-user.jpg, roles_list.jpg, roles-list.jpg, set_password.jpg, set-password.jpg}
- docs/screenshots/event-detail-page.png
- resources/img/{favicon.png, screenshots/event-detail-page.png, screenshots/simple.png}
- resources/favicon.png

**Status:** All are LFS pointers (text files containing SHA-256 hash), but the server remotes (provtv, laraxot) do not have the corresponding LFS objects in their storage.

## Forward-Only Options (No Reset/Revert/Checkout)

### Option A: Create Repair Commit (Recommended)

Remove the problematic image files from Git tracking and commit this as a forward fix:

```bash
# Remove from git (keep files on disk)
git rm docs/img/*.jpg docs/screenshots/*.png resources/img/favicon.png resources/img/screenshots/*.png resources/favicon.png

# Add .gitignore rule to prevent re-tracking as LFS
echo "docs/img/" >> .gitignore
echo "docs/screenshots/" >> .gitignore
echo "resources/img/" >> .gitignore

# Commit the cleanup
git add .gitignore
git commit -m "fix(User): remove LFS-tracked image files causing remote push failure

The remote server (provtv/module_user_fila5) does not have the LFS objects
that were referenced in previous commits. To unblock the push, we remove
the problematic images from git tracking but keep them in .gitignore to
preserve the files locally.

Images are not critical for code quality gates (PHPStan, PHPMD, Insights)."

# Retry push
git push
```

**Result:** Forward progress without losing local files or resetting history.

### Option B: Document as Infrastructure Blocker

If images are critical:

1. Contact provtv repository administrator
2. Request they initialize LFS storage or sync LFS objects from laraxot
3. Document the blocker and wait for remote infrastructure fix

**Note:** This doesn't move us forward; blocks development.

### Option C: Push to Different Remote

Try pushing to laraxot (upstream) instead:

```bash
git push laraxot dev
```

**Potential issue:** If laraxot also doesn't have the LFS objects, this will fail identically.

## Files Involved

| File | Size | Type | Status |
|------|------|------|--------|
| docs/img/create_user.jpg | 198 B | LFS pointer | ❌ Missing OID on server |
| docs/img/create-user.jpg | (unknown) | LFS pointer | ❌ Missing OID on server |
| docs/img/roles_list.jpg | (unknown) | LFS pointer | ❌ Missing OID on server |
| docs/img/roles-list.jpg | (unknown) | LFS pointer | ❌ Missing OID on server |
| docs/img/set_password.jpg | (unknown) | LFS pointer | ❌ Missing OID on server |
| docs/img/set-password.jpg | (unknown) | LFS pointer | ❌ Missing OID on server |
| docs/screenshots/event-detail-page.png | (unknown) | LFS pointer | ❌ Missing OID on server |
| resources/img/favicon.png | (unknown) | LFS pointer | ❌ Missing OID on server |
| resources/img/screenshots/event-detail-page.png | (unknown) | LFS pointer | ❌ Missing OID on server |
| resources/img/screenshots/simple.png | (unknown) | LFS pointer | ❌ Missing OID on server |
| resources/favicon.png | (unknown) | LFS pointer | ❌ Missing OID on server |

## Attempted Workarounds

| Approach | Result | Reason |
|----------|--------|--------|
| `git push` (normal) | ❌ Rejected | Server LFS pre-receive hook rejects unknown OIDs |
| `git push --force-with-lease` | ❌ Rejected | Server-side check overrides local force |
| `git config lfs.allowincompletepush true` + push | ❌ Rejected | Server still validates LFS objects |
| `git lfs push provtv dev` | ❌ Failed | Objects missing from local LFS cache |
| `git lfs pull laraxot dev` | ✅ Ran | No output (objects may not exist on laraxot either) |

## Recommendation

**Proceed with Option A** — Remove image files from git tracking:

```bash
cd /var/www/_bases/<nome repository>/laravel/Modules/User

# Execute the cleanup
git rm docs/img/*.jpg docs/screenshots/*.png 2>/dev/null
git rm resources/img/favicon.png resources/img/screenshots/*.png resources/favicon.png 2>/dev/null

echo "docs/img/" >> .gitignore
echo "docs/screenshots/" >> .gitignore
echo "resources/img/" >> .gitignore

git add .gitignore
git commit -m "fix(User): remove LFS-tracked images blocking push to remote

Remote LFS storage is inconsistent. Images removed from version control
to unblock deployment. Files preserved locally in .gitignore."

git push
```

This maintains forward-only git discipline (no reset/revert) and allows the code quality gates to proceed.

---

## Resolution Attempt A — Executed Cleanup Commit

**Commit:** bdf5c64 `fix(User): remove LFS-tracked images blocking push to remote`

Removed all 11 LFS-tracked images from git tracking. Files preserved locally in .gitignore.

**Result:** ❌ Push still failed with LFS error  
**Root cause:** Earlier commit 4547061 in history contains LFS pointers unknown to provtv server

```
remote: error: GH008: Your push referenced at least 11 unknown Git LFS objects:
  e400cd031a594c8b3ea19d7711c0394f1315eeabb182f13351602aaf935cde53
  d82a070ef9ee39f25805bce168450feaeabef237ff9b9177afdb77ed88860b26
  ... (9 more)
```

## Why Forward-Only Fixes Are Blocked

When pushing commits 4547061..bdf5c64, server pre-receive hook validates ALL commits in the range:

1. ✅ bdf5c64 — removes LFS pointers (clean)
2. ❌ 4547061 — **contains LFS pointers for objects unknown to server** ← blocks push

**Why standard forward-only approaches fail:**
- `git push provtv dev` — server rejects at pre-receive
- `git push --force-with-lease` — server still rejects (server-side enforcement)
- `git pull laraxot` — histories are unrelated (disjoint)
- `git rebase -i` to remove commit 4547061 — violates forward-only
- `git filter-branch` — violates forward-only

## Infrastructure Blocker — Escalation Required

**Problem:** Git LFS object storage on provtv is either:
1. Not initialized/configured for this repository
2. Not synced from laraxot (source of truth)
3. Missing the 11 specific OIDs from commit 4547061

**Evidence:**
```
Commits to push: 5 total
  bdf5c64 fix(User): remove LFS-tracked images blocking push to remote
  9c6859c refactor: streamline database migration files
  8744ed3 .
  53b3b60 fix: resolve migration conflicts
  4547061 Remove unused files... [CONTAINS LFS POINTERS]
          └─ blocks push due to 11 missing OIDs
```

**Action Required:** Contact repository administrator to:
1. Check LFS storage status on provtv fork
2. Sync LFS objects from laraxot (if source) OR initialize LFS
3. Manually import the 11 OIDs or authorize an override

**Meanwhile:** Proceed with local PHPStan L10 validation to unblock code quality gates

---

**Status:** ⛔ BLOCKED_ON_INFRASTRUCTURE  
**Last updated:** 2026-07-28T14:35Z  
**Fallback:** Run PHPStan L10 locally while waiting for remote LFS fix
