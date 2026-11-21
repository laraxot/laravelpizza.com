---
issues: []
discussions: []
title: "Publish.Yml"
module: "Lang"
type: concept
tags: [publish.yml]
created: 2026-07-14
updated: 2026-07-14
qmd: "publish.yml"
related:
  - "./italian-text-refined-audit-report.md"
---
name: Publish

on:
  push:
    branches:
      - master

permissions: 
  contents: write

jobs:
  build:

    runs-on: ubuntu-latest

    steps:
    - name: Checkout
      uses: actions/checkout@master

    - name: Validate composer.json and composer.lock
      run: composer validate

    - name: Composer
      run: composer install --no-progress --no-suggest

    - name: Node
      run: npm install
      
    - name: Production
      run: npm run prod
      
    - name: CNAME
      run: echo "privacyfed.github.io/doc_extrafield" > ./build_production/CNAME

    - name: gh-pages
      uses: JamesIves/github-pages-deploy-action@v4.4.2
      with:
        branch: gh-pages
        folder: build_production
