---
title: "agents security guidelines"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
<<<<<<< .merge_file_39qHVu
<<<<<<< .merge_file_1Pryx4
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_GtjvwJ
=======
>>>>>>> .merge_file_W50C2P
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_39qHVu
<<<<<<< .merge_file_1Pryx4
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_GtjvwJ
=======
>>>>>>> .merge_file_W50C2P
qmd: "agents security guidelines"
issues: []
discussions: []
---

# AGENTS Security Guidelines

Linee guida per la sicurezza.

## Authentication & Authorization

- Use Laravel's built-in authentication
- Implement **Policies** for authorization
- Use **Gates** for simple access control
- Validate all input through Form Requests

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
---

title: "agents security guidelines"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "agents security guidelines"
issues: []
discussions: []
## Data Protection

- Never commit credentials (use .env)
- Encrypt sensitive data with Laravel's encryption
- Use prepared statements (Eloquent) against SQL injection

---

<<<<<<< HEAD
=======
=======
## Data Protection

>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
## Security Best Practices

### Never Do

- ❌ Hardcode secrets in source code
- ❌ Commit `.env` files
- ❌ Use `eval()` or similar dangerous functions
- ❌ Skip input validation

### Always Do

- ✅ Use environment variables for secrets
- ✅ Hash passwords with bcrypt
- ✅ Use parameterized queries
- ✅ Implement CSRF protection
- ✅ Use HTTPS in production

---

## 🔗 Link

- [Indice AGENTS](./agents-split-index.md)
<<<<<<< HEAD
- [laravel-security-audit skill available](../../.opencode/skills/laravel-security-audit/SKILL.md)
- [AGENTS.md originale](../../AGENTS.md)
- [AGENTS.md originale](../../AGENTS.md)
=======
<<<<<<< HEAD
<<<<<<< .merge_file_39qHVu
<<<<<<< .merge_file_1Pryx4
<<<<<<< HEAD
- [laravel-security-audit skill available](../../.opencode/skills/laravel-security-audit/SKILL.md)
- [AGENTS.md originale](../../AGENTS.md)
- [AGENTS.md originale](../../AGENTS.md)
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_W50C2P
- [laravel-security-audit skill available](../../.opencode/skills/laravel-security-audit/skill.md)
- [AGENTS.md originale](../../agents.md)
- [agents.md originale](../../agents.md)
=======
- [laravel-security-audit skill available](../../.opencode/skills/laravel-security-audit/SKILL.md)
- [AGENTS.md originale](../../AGENTS.md)
- [AGENTS.md originale](../../AGENTS.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_39qHVu
=======
- [laravel-security-audit skill available](../../.opencode/skills/laravel-security-audit/skill.md)
- [AGENTS.md originale](../../agents.md)
- [agents.md originale](../../agents.md)
=======
- [laravel-security-audit skill available](../../.opencode/skills/laravel-security-audit/skill.md)
- [AGENTS.md originale](../../agents.md)
- [agents.md originale](../../agents.md)
=======
- [laravel-security-audit skill available](../../.opencode/skills/laravel-security-audit/SKILL.md)
- [AGENTS.md originale](../../AGENTS.md)
- [AGENTS.md originale](../../AGENTS.md)
>>>>>>> .merge_file_GtjvwJ
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_W50C2P
- [Index principale](./index.md)
