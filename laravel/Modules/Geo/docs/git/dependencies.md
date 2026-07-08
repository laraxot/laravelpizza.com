# Git Script Dependencies

To ensure robustness in CI/CD environments, specific dependencies must be managed carefully.

## Bashscripts
The `bashscripts` directory is a **critical dependency** for many workflows, including `sync_remote_repo.sh`.
It is typically a submodule, but due to potential "zombie submodule" issues in the parent repository (like `docs/public_html/noconsole`), we explicitly disable automated submodule checkout in GitHub Actions to prevent failure.

### Resolution in CI
In GitHub Actions (e.g., `sync-remote-repo.yml`), we use `actions/checkout` to explicitly clone the private `bashscripts` repository using a Personal Access Token (PAT).

**Repository**: `provtv/bashscripts_fila5` (Private)

### Example Workflow Step
```yaml
      - name: Checkout bashscripts
        uses: actions/checkout@v4
        with:
          repository: laraxot/bashscripts_fila5
          token: ${{ secrets.BASHSCRIPTS_PAT }}
          path: bashscripts
          sparse-checkout: |
            .
```

### Secrets Required
- `BASHSCRIPTS_PAT`: A Personal Access Token with access to the private `laraxot/bashscripts_fila5` repository.
