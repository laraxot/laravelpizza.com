name: Build & Publish

on:
  push:
    branches:
      - develop
  schedule:
    - cron: "0 2 * * 1-5"

jobs:
  build-site:
    runs-on: ubuntu-latest
    steps:
    - uses: actions/checkout@v3
    - name: Install Composer Dependencies
      run: composer install --no-ansi --no-interaction --no-scripts --no-suggest --no-progress --prefer-dist
    - name: Install NPM Dependencies
      run: npm install
    - name: Build assets
      run: npm run production
    - name: Build Jigsaw site
      run: ./vendor/bin/jigsaw build production
    - name: Create CNAME File
      run: echo "privacyfed.github.io/doc_extrafield" >> build_production/CNAME
    - name: Stage Files
      run: git add -f build_production
    - name: Commit files
      run: |
        git config --local user.email "actions@github.com"
        git config --local user.name "GitHub Actions"
        git commit -m "Build for deploy"
    - name: Publish
      run: |
        git subtree split --prefix build_production -b master
        git push -f origin master:master
        git branch -D master