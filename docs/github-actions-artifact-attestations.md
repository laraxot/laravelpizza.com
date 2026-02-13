# GitHub Actions - Artifact Attestations

**Versione**:
**Data**:
**Status**: ✅ Implementato
**Standards**: SLSA v1.0 Build Level 2

---

## 📋 Indice

1. [Cos' sono le Artifact Attestations](#cos-sono-le-artifact-attestations)
2. [Perché usarle](#perché-usarle)
3. [Come funzionano](#come-funzionano)
4. [Implementazione nel Progetto](#implementazione-nel-progetto)
5. [Workflow Configurati](#workflow-configurati)
6. [Verifica delle Attestations](#verifica-delle-attestations)
7. [Best Practices](#best-practices)
8. [Troubleshooting](#troubleshooting)

---

## 🎯 Cos' sono le Artifact Attestations

Le **GitHub Artifact Attestations** sono firme digitali crittografiche che legano un artefatto di build (binario, pacchetto, container image, archivio) alle informazioni sul processo di build che lo ha generato.

### Componenti Chiave

1. **Soggetto (Subject)**: L'artefatto attestato (es. `laravelpizza-abc123.tar.gz`)
2. **Predicato (Predicate)**: Informazioni sul processo di build in formato SLSA Provenance
3. **Firma (Signature)**: Firma digitale generata con certificato Sigstore
4. **Archiviazione**: Le attestations sono memorizzate nell'API GitHub Attestations

### Formato

Le attestations usano il formato **in-toto**:
```json
{
  "_type": "https://in-toto.io/Statement/v0.1",
  "subject": [
    {
      "name": "laravelpizza-deployment-abc123",
      "digest": {"sha256": "abc123..."}
    }
  ],
  "predicateType": "https://slsa.dev/provenance/v1"
}
```

---

## 🔒 Perché usarle

### Benefici di Sicurezza

1. **Supply Chain Security**: Garantisce che l'artefatto provenga dal repository e workflow specificati
2. **Integrity**: Verifica che l'artefatto non sia stato modificato dopo la build
3. **Traceability**: Traccia l'artefatto fino al commit sorgente e al workflow di build
4. **Compliance**: Soddisfa requisiti SLSA v1.0 Build Level 2
5. **Trust**: Fornisce garanzie agli utenti e sviluppatori

### Casi d'Uso

- ✅ Verificare che un deployment in produzione provenga dal repository corretto
- ✅ Garantire che i pacchetti npm/composer non siano stati manomessi
- ✅ Tracciare l'origine di container images
- ✅ Conformità ai requisiti di sicurezza aziendali
- ✅ Audit trail per incidenti di sicurezza

---

## ⚙️ Come funzionano

### Flusso di Generazione

```
1. GitHub Actions Workflow
   ↓
2. Build dell'artefatto (es. tar.gz, npm package, container image)
   ↓
3. actions/attest-build-provenance@v2
   ↓
4. Calcolo SHA256 digest dell'artefatto
   ↓
5. Generazione SLSA Provenance predicate
   ↓
6. Firma con certificato Sigstore (OIDC token)
   ↓
7. Upload all'API GitHub Attestations
   ↓
8. Associazione al repository e workflow run
```

### Componenti Tecnicamente

#### OIDC Token
- GitHub Actions genera un token OIDC
- Il token viene usato per richiedere un certificato di firma Sigstore
- Il certificato è valido solo per breve tempo (minuti)

#### Sigstore
- **Repository Pubblici**: Usa l'istanza pubblica Sigstore
- **Repository Privati**: Usa l'istanza privata GitHub Sigstore
- Firma crittografica con chiave a breve termine

#### SLSA Provenance
- **Build Type**: Identifica il tipo di build (GitHub Actions)
- **Builder**: Identifica il builder che ha creato l'artefatto
- **Invocation**: Informazioni sul workflow (commit, branch, trigger)
- **Materials**: Input della build (commit SHA, dependencies)
- **Metadata**: Timestamp, run ID, ecc.

---

## 🚀 Implementazione nel Progetto

### Permessi Richiesti

Ogni workflow che usa `actions/attest-build-provenance` deve avere:

```yaml
permissions:
  contents: read        # Necessario per leggere il repository
  id-token: write       # Necessario per generare token OIDC
  attestations: write   # Necessario per salvare attestations
```

### Versione dell'Action

```yaml
- uses: actions/attest-build-provenance@v2
```

**IMPORTANTE**: Usare sempre `@v2` che è la versione stabile più recente.

---

## 📦 Workflow Configurati

### 1. CI Workflow (`.github/workflows/ci.yml`)

#### Scopo
Validare la qualità del codice e creare attestations per gli asset del tema.

#### Attestation Generata

```yaml
- name: Build theme attestation
  uses: actions/attest-build-provenance@v2
  with:
    subject-path: './laravel/Themes/Meetup/public/build'
    subject-name: 'laravelpizza-meetup-theme-assets'
```

**Cosa viene attestato**:
- Tutti gli asset compilati del tema Meetup
- CSS, JS, immagini ottimizzate
- Digest SHA256 di tutti i file

**Perché**:
- Garantisce che gli asset in produzione provengono dalla build corretta
- Permette di verificare che non ci sia inject di codice malevolo

#### Jobs del Workflow

1. **phpstan**: Analisi PHPStan Level 10
2. **phpmd**: Analisi qualità codice
3. **phpinsights**: Metriche qualità
4. **pint**: Verifica formattazione
5. **pest**: Suite di test con coverage
6. **build-theme**: Build asset tema + attestation
7. **quality-summary**: Riepilogo risultati

### 2. Deploy Workflow (`.github/workflows/deploy.yml`)

#### Scopo
Deploy su staging/production con attestations dell'artefatto di deployment.

#### Attestations Generate

##### Staging Deployment

```yaml
- name: Create deployment attestation
  uses: actions/attest-build-provenance@v2
  with:
    subject-path: 'laravelpizza-${{ github.sha }}.tar.gz'
    subject-name: 'laravelpizza-deployment-${{ github.sha }}'
```

**Cosa viene attestato**:
- Archivio tar.gz completo dell'applicazione
- Tutto il codice (esclusi dev dependencies)
- Configurazione ottimizzata

##### Production Deployment

```yaml
- name: Create production deployment attestation
  uses: actions/attest-build-provenance@v2
  with:
    subject-path: 'laravelpizza-prod-${{ github.sha }}.tar.gz'
    subject-name: 'laravelpizza-production-deployment-${{ github.sha }}'
```

**Cosa viene attestato**:
- Archivio tar.gz per production
- Stesso formato di staging ma con environment production

#### Jobs del Workflow

1. **deploy-staging**: Deploy su staging + attestation
2. **deploy-production**: Deploy su production + attestation (dipende da staging)

---

## 🔍 Verifica delle Attestations

### Usando GitHub CLI

#### Installazione

```bash
# Ubuntu/Debian
sudo apt update
sudo apt install gh

# macOS
brew install gh

# Windows (scoop)
scoop install gh
```

#### Autenticazione

```bash
gh auth login
```

#### Verifica Attestation

```bash
# Verifica un artefatto specifico
gh attestation verify laravelpizza-abc123.tar.gz \
  --repo github.com/laraxot/laravelpizza

# Verifica con digest specifico
gh attestation verify \
  --digest sha256:abc123... \
  --repo github.com/laraxot/laravelpizza

# Verifica artefatti tema
gh attestation verify ./laravel/Themes/Meetup/public/build \
  --repo github.com/laraxot/laravelpizza
```

#### Output Esempio

```
✓ Verified attestation from laraxot/laravelpizza
  Subject: laravelpizza-deployment-abc123.tar.gz
  Digest: sha256:abc123...
  Signature: Valid
  Workflow: Deploy - LaravelPizza.com
  Run ID: 1234567890
  Commit: abc123def456
  Branch: main
  Timestamp: YYYY-MM-DDTHH:MM:SSZ
```

### Verifica Automatizzata

#### Script di Verifica

```bash
#!/bin/bash
# verify-deployment.sh

ARTIFACT=$1
REPO="github.com/laraxot/laravelpizza"

echo "Verifying artifact: $ARTIFACT"
gh attestation verify "$ARTIFACT" --repo "$REPO"

if [ $? -eq 0 ]; then
    echo "✅ Artifact verified successfully"
    exit 0
else
    echo "❌ Artifact verification failed"
    exit 1
fi
```

#### Uso nel Deployment

```bash
# Prima del deploy
./verify-deployment.sh laravelpizza-abc123.tar.gz

# Se verifica fallisce, il deploy viene bloccato
if [ $? -eq 0 ]; then
    tar -xzf laravelpizza-abc123.tar.gz
    # Continua con deploy
fi
```

### Verifica in Kubernetes

Per deployments Kubernetes, usare il **GitHub Admission Controller**:

```yaml
apiVersion: v1
kind: Namespace
metadata:
  name: laravelpizza-production
  annotations:
    policy.sigstore.dev/verify: "true"
```

Questo controller rifiuterà container images senza attestation valida.

---

## 📚 Best Practices

### 1. Attestare Tutto

**✅ DA FARE**:
- Attestare deployment artifacts (tar.gz)
- Attestare container images
- Attestare pacchetti npm/composer
- Attestare asset del tema

**❌ DA EVITARE**:
- Non attestare solo alcuni artefatti
- Non saltare attestation in staging

### 2. Nomi Chiari e Descrittivi

```yaml
# ✅ BUONO
subject-name: 'laravelpizza-production-deployment-v1.2.3'

# ❌ SCARSO
subject-name: 'artifact'
```

### 3. Versioning dell'Action

```yaml
# ✅ BUONO - Versione specifica
- uses: actions/attest-build-provenance@v2

# ❌ SCARSO - Versione non specificata
- uses: actions/attest-build-provenance
```

### 4. Attestation dopo la Build

```yaml
# ✅ BUONO - Attestation dopo build
- name: Build artifact
  run: npm run build

- name: Create attestation
  uses: actions/attest-build-provenance@v2
  with:
    subject-path: './dist'

# ❌ SCARSO - Attestation prima della build
- name: Create attestation
  uses: actions/attest-build-provenance@v2
  with:
    subject-path: './dist'
```

### 5. Verifica nel Deployment

```bash
# ✅ BUONO - Verifica prima del deploy
gh attestation verify artifact.tar.gz --repo laraxot/laravelpizza
if [ $? -eq 0 ]; then
    ./deploy.sh artifact.tar.gz
fi

# ❌ SCARSO - Deploy senza verifica
./deploy.sh artifact.tar.gz
```

### 6. Documentazione

Documenta sempre:
- Quali artefatti vengono attestati
- Come verificare le attestations
- Cosa fare se la verifica fallisce

---

## 🛠️ Troubleshooting

### Errore: "Permission denied"

**Problema**: Permessi insufficienti nel workflow

**Soluzione**:
```yaml
permissions:
  contents: read
  id-token: write
  attestations: write
```

### Errore: "Attestation verification failed"

**Problema**: L'artefatto è stato modificato dopo la build

**Soluzione**:
1. Verifica che l'artefatto non sia stato modificato
2. Riesegui la build e genera nuova attestation
3. Verifica il digest SHA256

### Errore: "No attestations found"

**Problema**: Non ci sono attestations per l'artefatto

**Soluzione**:
1. Verifica che il workflow sia completato con successo
2. Controlla che `actions/attest-build-provenance` sia presente
3. Verifica i permessi del workflow

### Errore: "OIDC token not available"

**Problema**: Token OIDC non generato

**Soluzione**:
```yaml
permissions:
  id-token: write  # Assicurati che questo sia impostato
```

### Errore: "Subject not found"

**Problema**: L'artefatto specificato non esiste

**Soluzione**:
```yaml
# Verifica il path
- uses: actions/attest-build-provenance@v2
  with:
    subject-path: './correct/path/to/artifact'  # Usa path relativo
```

---

## 📖 Riferimenti

- [GitHub Artifact Attestations Documentation](https://docs.github.com/actions/security-for-github-actions/using-artifact-attestations)
- [actions/attest-build-provenance Repository](https://github.com/actions/attest-build-provenance)
- [SLSA Specification](https://slsa.dev/spec/v1.0)
- [Sigstore Project](https://sigstore.dev/)
- [GitHub CLI Documentation](https://cli.github.com/manual/gh_attestation)

---

## 📊 Metriche e Reporting

### Attestations Generate

Il progetto genera attestations per:
- ✅ Deployment artifacts (staging e production)
- ✅ Theme assets (CSS, JS, immagini)
- ✅ Tutte le build in main branch

### Frequenza

- **CI**: A ogni push su dev/develop/main
- **Deploy**: A ogni deploy su staging/production
- **Theme**: A ogni modifica del tema Meetup

### Compliance

- ✅ **SLSA v1.0 Build Level 2**: Completamente conforme
- ✅ **Supply Chain Security**: Massima sicurezza
- ✅ **Audit Trail**: Tracciabilità completa

---

## 🎓 Formazione

### Per Nuovi Sviluppatori

1. Leggi questa documentazione
2. Verifica le attestations esistenti:
   ```bash
   gh attestation list --repo laraxot/laravelpizza
   ```
3. Capisci come funziona il flusso di generazione
4. Impara a verificare attestations
5. Pratica con artifact di test

### Per DevOps Engineers

1. Configura admission controller Kubernetes
2. Integra verifica nei deployment scripts
3. Monitora attestations nel dashboard GitHub
4. Configura alert per verifiche fallite
5. Mantieni documentazione aggiornata

---

## 🔄 Changelog

### Initial Release
- ✅ Implementazione iniziale
- ✅ CI workflow con attestation tema
- ✅ Deploy workflow con attestation deployment
- ✅ Documentazione completa
- ✅ SLSA v1.0 Build Level 2 compliance

---

## 📞 Supporto

Per problemi o domande:
1. Consulta questa documentazione
2. Verifica i logs di GitHub Actions
3. Controlla i riferimenti esterni
4. Apri issue nel repository

---

**Status**: ✅ Production Ready
**Maintained By**: DevOps Team
**Last Updated**:
**Next Review**: (Quarterly)