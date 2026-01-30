# Best Practice di Versioning

## Principi Fondamentali

### 1. Git Flow
- Usare SEMPRE git flow
- Implementare SEMPRE branch protection
- Gestire SEMPRE i merge

### 2. Versioning
- Usare SEMPRE semantic versioning
- Implementare SEMPRE changelog
- Gestire SEMPRE i tag

### 3. Deployment
- Usare SEMPRE CI/CD
- Implementare SEMPRE test automatici
- Gestire SEMPRE gli ambienti

## Esempio di Implementazione

### 1. Git Flow
```bash

# Creazione feature branch
git checkout -b feature/doctor-registration

# Commit delle modifiche
git add .
git commit -m "feat: implement doctor registration"

# Push della feature branch
git push origin feature/doctor-registration

# Merge in develop
git checkout develop
git merge feature/doctor-registration
git push origin develop

# Merge in main
git checkout main
git merge develop
git push origin main
```

### 2. Versioning
```bash

# Creazione tag
git tag -a v1.0.0 -m "First release"
git push origin v1.0.0

# Creazione changelog
git log --pretty=format:"%h - %s (%an)" v1.0.0..HEAD > CHANGELOG.md
```

### 3. Deployment
```yaml

# .github/workflows/deploy.yml
name: Deploy

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
      - name: Install Dependencies
        run: composer install --no-dev
      - name: Run Tests
        run: php artisan test
      - name: Deploy
        run: |
          git config --global user.name "GitHub Actions"
          git config --global user.email "actions@github.com"
          git tag -a v1.0.0 -m "First release"
          git push origin v1.0.0
```

## Errori Comuni

### 1. Git Flow Mancante
❌ Non usare git flow
✅ Usare SEMPRE git flow

### 2. Versioning Mancante
❌ Non usare semantic versioning
✅ Usare SEMPRE semantic versioning

### 3. Deployment Mancante
❌ Non usare CI/CD
✅ Usare SEMPRE CI/CD

## Checklist

### Prima di Creare un Branch
- [ ] Git flow
- [ ] Branch protection
- [ ] Merge strategy
- [ ] Test automatici

### Prima di Creare un Tag
- [ ] Semantic versioning
- [ ] Changelog
- [ ] Test automatici
- [ ] Review del codice

### Prima di Deployare
- [ ] CI/CD
- [ ] Test automatici
- [ ] Ambienti
- [ ] Review del codice 
