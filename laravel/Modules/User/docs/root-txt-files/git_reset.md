---
title: 'Git reset'
module: User
type: reference
slug: git-reset
description: 'git submodule add -f $url $path done'
tags: [migrato-da-txt, user]
converted_from: git_reset.txt
created: 2026-08-24
updated: 2026-08-24
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
