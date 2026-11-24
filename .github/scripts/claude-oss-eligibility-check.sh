#!/usr/bin/env bash
# Measure honest signals for Anthropic Claude for Open Source eligibility.
# Callers: docs/claude-for-open-source-eligibility.md (manual), maintainers before apply.
# Data: read-only GitHub REST/search JSON + optional Scorecard API; writes nothing.
# User: "fa tutto quello che serve per far diventare questa repo utile ad avere claude code ultra a gratis"
set -euo pipefail

REPO="${1:-laraxot/laravelpizza.com}"
LOGIN="${2:-}"
SINCE="$(date -u -d '12 months ago' +%Y-%m-%d 2>/dev/null || date -u -v-12m +%Y-%m-%d)"
SINCE_90="$(date -u -d '90 days ago' +%Y-%m-%dT%H:%M:%SZ 2>/dev/null || date -u -v-90d +%Y-%m-%dT%H:%M:%SZ)"

if ! command -v gh >/dev/null 2>&1; then
  echo "gh CLI required" >&2
  exit 1
fi

echo "=== Claude OSS eligibility snapshot ==="
echo "repo:   ${REPO}"
echo "since:  ${SINCE} (12m) / ${SINCE_90} (90d)"
echo

echo "--- Repository basics ---"
gh repo view "${REPO}" --json name,visibility,isPrivate,licenseInfo,stargazerCount,forkCount,updatedAt,url \
  --jq '"\(.url)\nvisibility=\(.visibility) private=\(.isPrivate)\nlicense=\(.licenseInfo.key // "none")\nstars=\(.stargazerCount) forks=\(.forkCount)\nupdated=\(.updatedAt)"'

echo
echo "--- Root hygiene files (clone-local if cwd is the repo) ---"
for f in LICENSE CODE_OF_CONDUCT.md SECURITY.md CONTRIBUTING.md README.md; do
  if [[ -f "${f}" ]]; then
    echo "OK  ${f}"
  else
    echo "MISS ${f}"
  fi
done

echo
echo "--- Contributors (API; bots may appear) ---"
gh api "repos/${REPO}/contributors?per_page=100" \
  --jq '.[] | "\(.login)\t\(.contributions)\t\(.type)"'

echo
echo "--- Merged PR authors (sample up to 100 closed PRs) ---"
gh api "repos/${REPO}/pulls?state=closed&per_page=100" \
  --jq '[.[] | select(.merged_at != null) | .user.login] | group_by(.) | map({login: .[0], merged_prs: length}) | sort_by(-.merged_prs) | .[] | "\(.login)\t\(.merged_prs)"'

MERGED_TOTAL="$(gh api "search/issues?q=repo:${REPO}+is:pr+is:merged+created:>${SINCE}" --jq '.total_count')"
echo
echo "merged PRs last 12m (search): ${MERGED_TOTAL}"

echo
echo "--- Commits last 90d (first page length) ---"
gh api "repos/${REPO}/commits?since=${SINCE_90}&per_page=100" --jq 'length'

echo
echo "--- OpenSSF Scorecard (if published) ---"
curl -fsSL "https://api.securityscorecards.dev/projects/github.com/${REPO}" \
  | jq -r '"score=\(.score // "n/a") date=\(.date // "n/a")"' \
  2>/dev/null || echo "scorecard not published yet (run workflow openssf-scorecard.yml)"

if [[ -n "${LOGIN}" ]]; then
  echo
  echo "--- Personal active-contributor track for ${LOGIN} ---"
  AGE="$(gh api "users/${LOGIN}" --jq '.created_at')"
  echo "account_created=${AGE}"
  EXT="$(gh api "search/issues?q=is:pr+is:merged+author:${LOGIN}+-user:${LOGIN}+created:>${SINCE}" --jq '.total_count')"
  echo "merged_prs_outside_own_user_namespace_12m=${EXT} (target >= 100; also exclude your orgs manually)"
fi

echo
echo "--- Interpretation (KISS) ---"
echo "1) Ecosystem impact: apply now with honest narrative + links."
echo "2) Community builder: need >=20 unique EXTERNAL humans with merged PRs in 12m."
echo "3) Active contributor: personal >=100 merged PRs to repos you do not own."
echo "4) Downloads/criticality: long game via published packages / ecosystem dependence."
echo
echo "Apply: https://claude.com/contact-sales/claude-for-oss"
echo "Playbook: docs/claude-for-open-source-eligibility.md"
echo "Script:   .github/scripts/claude-oss-eligibility-check.sh"
