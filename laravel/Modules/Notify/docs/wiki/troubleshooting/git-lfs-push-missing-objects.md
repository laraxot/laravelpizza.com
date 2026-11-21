---
title: "git lfs push missing objects"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "git lfs push missing objects"
issues: []
discussions: []
name: git-lfs-push-missing-objects
description: 29 local commits blocked pushing to laraxot with GH008 LFS error; fixed by copying LFS objects from provtv (which already had them) instead of rewriting history
metadata:
  type: troubleshooting
---

# Git LFS Push Missing Objects (Notify)

## Symptom

`git push laraxot dev` (29 commits ahead, `laraxot/dev` confirmed as a real
ancestor via `git merge-base --is-ancestor`) would have failed with:

```
remote: error: GH008: Your push referenced at least N unknown Git LFS objects
```

13 SVG files under `resources/svg/` (`icon.svg`, `logo.svg`,
`*-animated.svg`, `notify-icon.svg`, etc.) are stored as Git LFS pointers in
this module's history.

## Root Cause Check (before assuming corruption)

Unlike the `Modules/User` case (see
[../../../User/docs/wiki/troubleshooting/git-lfs-orphan-pointer-svg-fix.md](../../../User/docs/wiki/troubleshooting/git-lfs-orphan-pointer-svg-fix.md)),
here the LFS objects were **not** actually lost:

```bash
git lfs fetch provtv --all
# fetch: 14 objects found, done.
```

`provtv` remote already had the real LFS objects (registered even though
`.gitattributes` has no explicit `*.svg filter=lfs` rule — only
`*.psd`/`*.zip`/`*.db` are declared). `laraxot` simply never received them.

## Fix (no history rewrite)

```bash
git lfs push laraxot --all   # copies the 13 objects laraxot was missing
git push laraxot dev         # now succeeds as a normal fast-forward
```

Result: `2a6c4b08a..e8ce5a7b7` pushed cleanly to `laraxot`. `provtv` was
already in sync (independently confirmed up to date).

## Lesson

Before treating a `GH008` LFS rejection as content corruption (which requires
restoring/squashing, see the `User` module writeup), always check whether a
**sibling remote already has the missing objects**:

```bash
git lfs fetch <sibling-remote> --all   # does it find objects?
git lfs push <target-remote> --all     # copy them over if so
```

Only fall back to restoring real file content from a known-good ref (and
squashing unpublished local commits) if no remote has the LFS objects at all.

## Related

- `Modules/User` — same symptom, different root cause (real content lost,
  required restoration): `git-lfs-orphan-pointer-svg-fix.md`
- `docs/multi-org-sync-laraxot-provtv.md` (this module) — shared multi-org
  coordination note, updated with cross-module LFS troubleshooting pointers
