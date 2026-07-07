# Migration archiviate (Gdpr)

Migration storiche per `consents` — **non eseguire** su nuovo ambiente.

## Tabella `consents`

| Stato | File |
|-------|------|
| **Canonica** | `../2024_01_01_000005_create_consents_table.php` |
| Archiviate | `2024_01_01_000001` (connection `gdpr` legacy), `2024_01_01_000002` (CREATE parziale) |

La canonica referenzia `Consent::class`, morph `user`, `type`, `accepted_at`, `ip_address`, `user_agent`, soft delete.
