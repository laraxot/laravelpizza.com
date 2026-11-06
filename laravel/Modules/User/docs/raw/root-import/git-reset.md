---
title: "Git Reset"
type: concept
tags: [git, reset]
created: 2026-07-14
updated: 2026-07-14
qmd: "git-reset git reset"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./changelog-1.md"
  - "./changelog-2.md"
  - "./changelog-3.md"
  - "./changelog-4.md"
  - "./changelog-5.md"
  - "./changelog.md"
  - "./git-reset-1.md"
  - "./pest-test-report-1.md"
---

#!/bin/sh
set -e
git config -f .gitmodules --get-regexp '^submodule\..*\.path$' |
    while read path_key path
    do
        url_key=$(echo $path_key | sed 's/\.path/.url/')
        url=$(git config -f .gitmodules --get "$url_key")
        echo $path
        echo $url
        
        
        
        git submodule add -f $url $path  
    done
    