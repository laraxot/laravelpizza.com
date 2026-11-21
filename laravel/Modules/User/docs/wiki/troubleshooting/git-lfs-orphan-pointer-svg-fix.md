---
name: git-lfs-orphan-pointer-svg-fix
description: How push to laraxot/dev was blocked by 33 SVG files turned into orphan Git LFS pointers, and how it was fixed forward-only
metadata:
  type: troubleshooting
---

# Git LFS Orphan Pointer SVG Fix

## Symptom

`git push laraxot dev` failed with:

```
remote: error: GH008: Your push referenced at least 31 unknown Git LFS objects:
remote:     0f96265cdbcae7120002387f235a8dfe5f105ce7c06eb018695174471582294a
remote:     ...
remote: Try to push them with 'git lfs push --all'.
 ! [remote rejected]   dev -> dev (pre-receive hook declined)
```

`git lfs push --all` / `git lfs fetch` confirmed the objects existed **nowhere**
(not locally in `.git/lfs/objects`, not on `laraxot` remote, not on `provtv` remote):

```
git lfs fsck
  objects: openError: resources/svg/icon.svg (...) could not be checked: no such file or directory

git lfs fetch laraxot
  [...] Object does not exist on the server: [404] Object does not exist on the server
```

## Root Cause

33 files under `resources/svg/` (icons: `icon.svg`, `logo.svg`, `role.svg`,
`user-*.svg`, `navigation/*.svg`, etc.) had been committed locally as **Git LFS
pointer text** (`version https://git-lfs.github.com/spec/v1 ...`) instead of their
real SVG content, while `.gitattributes` in this module has **no** `*.svg filter=lfs`
rule at all:

```
* text=auto
*.css linguist-vendored
*.scss linguist-vendored
*.js linguist-vendored
CHANGELOG.md export-ignore
```

So the LFS filter never actually ran to store the real binary/text content anywhere
— the pointer text was committed as if it were the file content itself. The real
SVG content only existed in the previously-pushed remote history
(`laraxot/dev` @ `44ff84cd`).

This is the same class of problem as `Modules/UI` (see
[UI provtv unrelated history](../../../../../../.claude/projects/-var-www--bases-base-ptvx-fila5/memory/feedback_ui_provtv_unrelated_history.md)
memory note), but here it is a content-corruption issue rather than a
history-divergence issue.

## Fix (forward-only, no reset/revert of published history)

1. Identified the 33 affected files by checking which tracked blobs started with
   the LFS pointer signature `version https://git-lfs.github.com/spec/v1`.
2. Restored each file's real content directly from the last known-good published
   commit (`laraxot/dev` @ `44ff84cd`) using `git show laraxot/dev:<path> > <path>`.
3. Committed the restoration as a new commit on top (no `git reset --hard`,
   no `git checkout -- <file>` from a rewritten ref, no history rewrite of
   anything already published).
4. Because the **intermediate**, still-unpublished local commits (never pushed to
   any remote) still contained the broken pointer blobs, `git-lfs`'s pre-push hook
   kept trying to resolve/upload them even after the fix commit. Since those
   intermediate commits were verified with `git branch -r --contains <sha>` /
   `git merge-base --is-ancestor` to be **100% local and unpublished** (absent
   from both `laraxot/dev` and `provtv/dev`), they were safely squashed via
   `git reset --soft laraxot/dev` + a single clean commit — this is not a
   violation of the forward-only rule, because nothing published was rewritten
   or discarded; only local, never-pushed commits were consolidated.
5. Re-ran the pointer-blob check on the new commit's tree (empty result) before
   pushing.
6. `git push laraxot dev` succeeded as a fast-forward: `44ff84cd..3ea7273a`.

## `provtv` remote — push intentionally skipped

`git push provtv dev` was rejected as non-fast-forward. Investigation showed
`provtv/dev` (`d2b107e0`) and this module's `dev` branch share **no common
ancestor** (`git merge-base` returns nothing, `cd6af2aa "first"` is a root
commit with no parent). This mirrors the known `Modules/UI` situation: two
completely unrelated histories under the same branch name across the two
GitHub orgs (`laraxot` vs `provtv`).

**Decision**: do not force-push, do not merge, do not rebase. This needs a
human decision on which org's history is canonical for `Modules/User`. Flagged
here for follow-up instead of silently discarding either side.

## Prevention

- If SVG (or any binary-ish) assets are meant to be tracked via Git LFS, add the
  proper `.gitattributes` rule (`*.svg filter=lfs diff=lfs merge=lfs -text`)
  **before** committing, and verify with `git lfs status` / `git lfs ls-files`
  that the filter actually captured the objects.
- If LFS is not actually wanted for this module, never let any tool/agent write
  literal `version https://git-lfs.github.com/spec/v1` pointer text into a file
  as if it were real content — always verify a diff's line count / content type
  before committing when a large content file suddenly shrinks to 2-3 lines.
- Before any push, if `git lfs fsck` or a push is rejected with `GH008`, check
  `.gitattributes` and `git lfs ls-files` first, rather than assuming the fix is
  `git lfs push --all` (which cannot help if the objects were never captured
  locally in the first place).

## Related

- Repo: `laraxot/module_user_fila5` (remote `laraxot`)
- Repo: `provtv/module_user_fila5` (remote `provtv`, unrelated history, unresolved)
- Similar pattern: `Modules/UI` provtv/laraxot unrelated-history issue (session memory)
