# Sync Remote Repo GitHub Action

This workflow automates the synchronization of remote repository subtrees using the `sync_remote_repo.sh` script.

## Overview

The `sync-remote-repo.yml` workflow allows running the synchronization process directly from GitHub Actions, either on a schedule or manually via workflow dispatch.

## Prerequisites

- **Bashscripts repository**: before executing `sync_remote_repo.sh` inside GitHub Actions you must clone `https://github.com/laraxot/bashscripts_fila5` into the `bashscripts` directory. Questo repo è privato ma è nella stessa organizzazione del presente progetto, quindi il `GITHUB_TOKEN` del workflow (con permesso `contents: write` e SSO abilitato) può già effettuare il checkout. Configurare un PAT dedicato (`BASHSCRIPTS_PAT`) solo se il `GITHUB_TOKEN` perde visibilità in futuro.
- **Verification tools**: every time the workflow is touched you must run automated checks (e.g. `actionlint`, `act`, or an MCP that wraps them) to ensure syntax and runtime prerequisites are satisfied. Document tooling updates in both root docs and module docs so every agent follows the same rule.

## Features

- **Automated Synchronization**: periodically syncs subtrees defined in `gitmodules.ini`.
- **Manual Trigger**: allows manual execution for immediate updates.
- **Organization Rewrite**: supports rewriting URLs to a specific organization (optional).

## Usage

### Workflow Dispatch

1. Go to the "Actions" tab in the repository.
2. Select "Sync Remote Repo" from the left sidebar.
3. Click "Run workflow".
4. (Optional) Provide an organization name to rewrite URLs.

### Configuration

The workflow uses the `sync_remote_repo.sh` script located in `bashscripts/git/subtrees/`.
It requires the `CI` environment variable to be set to `true` to skip interactive steps like backup.

## Workflow File

Location: `.github/workflows/sync-remote-repo.yml`

```yaml
name: Sync Remote Repo

on:
  schedule:
    - cron: '0 0 * * *' # Run daily at midnight
  workflow_dispatch:
    inputs:
      org:
        description: 'Organization to rewrite URLs to (optional)'
        required: false
        type: string

jobs:
  sync:
    runs-on: ubuntu-latest
    env:
      CI: true
    steps:
      - name: Checkout
        uses: actions/checkout@v4
        with:
          fetch-depth: 0
          token: ${{ secrets.GITHUB_TOKEN }}
          submodules: false # Explicitly disable to avoid issues with zombie submodules

      - name: Checkout bashscripts
        uses: actions/checkout@v4
        with:
          repository: laraxot/bashscripts_fila5
          token: ${{ secrets.GITHUB_TOKEN }}
          path: bashscripts

      - name: Configure Git
        run: |
          git config --global user.name "GitHub Action"
          git config --global user.email "action@github.com"

      - name: Run Sync Script
        run: |
          chmod +x bashscripts/git/subtrees/sync_remote_repo.sh
          ./bashscripts/git/subtrees/sync_remote_repo.sh "${{ inputs.org }}"
```
