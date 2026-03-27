---
name: bmad-wds-deploy
description: "Packages tested improvements as a pull request and delivers them to the development team with full context. Use when all acceptance criteria pass, the branch is clean, and the improvement is ready for team review."
---

# Deploy — Create PR and Deliver

Packages tested improvements as a pull request and delivers them to the development team. Ensures all acceptance criteria pass, commits are logical, and the PR includes full context for reviewers.

## When to Use

- All acceptance criteria from the test report pass
- Branch is clean with no uncommitted changes
- Commits are logical and well-described
- The improvement is ready for team review and integration

## Workflow

### Step 1: Pre-Deploy Checklist

Verify everything is ready before creating the PR:

- All acceptance criteria pass (from test report)
- Branch is clean (no uncommitted changes)
- Commits are logical and well-described
- No unrelated changes included
- Documentation updated (if applicable)

### Step 2: Create Pull Request

Create a PR from the evolution branch using `gh pr create`. The PR body includes:

- **What changed** — Summary of the improvement
- **Why** — Link to scenario and analysis
- **How to test** — Steps from the test report
- **Screenshots** — Before/after if visual change
- **Acceptance criteria** — Checklist from spec

### Step 3: Package Delivery Context

Create a delivery summary for team handoff with implementation notes and testing results.

LOAD the FULL `{project-root}/_bmad/wds/workflows/8-product-evolution/workflow-deploy.md` for the complete workflow instructions.
