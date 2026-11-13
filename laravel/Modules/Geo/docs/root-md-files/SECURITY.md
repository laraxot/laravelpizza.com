# Security Policy

## Reporting Security Vulnerabilities

Se scopri una vulnerabilità di sicurezza, **non** creare un issue pubblico. Invece:

📧 **Email:** marco.sottana@gmail.com  
🔒 **GitHub Security Advisory:** https://github.com/provtv/base_ptv_fila5_mono/security/advisories/new

Fornisci:
- Descrizione della vulnerabilità
- Versione interessata
- Steps per riprodurla
- Impatto stimato

Risponderemo entro **48 ore**.

---

## Dependabot & Automated Updates

- ✅ Monitoraggio continuo via Dependabot
- ✅ Patch (1.2.3 → 1.2.4) auto-mergiate
- ✅ Minor (1.2.0 → 1.3.0) revisionati prima di merge
- ✅ Major (1.0.0 → 2.0.0) richiedono revisione manuale

Vedi [dependabot-security-policy.md](./docs/dependabot-security-policy.md) per dettagli.

---

## Vulnerabilità Conosciute

Nessuna vulnerabilità critica nota al 2026-05-26.

Se una vulnerabilità è riportata, sarà documentata qui con:
- CVE/CVSS score
- Pacchetto interessato
- Versioni interessate
- Rimedio applicato

---

## Best Practices

### Per Sviluppatori

- ✅ Usa versioni stabili di dipendenze
- ✅ Aggiorna regolarmente (almeno mensile)
- ✅ Rivisa release notes prima di major upgrades
- ✅ Test completo prima di rilasciare

### Per Maintainer

- ✅ Monitora GitHub Security tab settimanalmente
- ✅ Mergia patch updates automaticamente
- ✅ Revisa minor updates prima di merge
- ✅ Comunica major updates ai team

---

## Infrastruttura di Sicurezza

- GitHub Dependabot alerts: **ABILITATO**
- Code scanning (CodeQL): **ABILITATO**
- Branch protection (main/develop): **ABILITATO**
- Require PR review: **SÌ (1 reviewer)**
- Dismiss stale PR approvals: **SÌ**

---

## Changelog Vulnerabilità

### 2026-05-26
- Implementato Dependabot security policy
- Configurato auto-merge per patch updates
- Aggiunto .github/dependabot.yml

---

**Ultimo aggiornamento:** 2026-05-26
