---
title: "Email verification delivery"
type: guide
module: User
status: active
tags: [email, verification, notify, production]
---

# Email verification delivery

The User module owns the verification flow, but not the transport. The resend
action and Laravel's `MustVerifyEmail` notification delegate to the Notify mail
configuration. Templates are rendered by `Modules\Notify\Emails\SpatieEmail`.

## Production contract

- `MAIL_MAILER` must select an operational transactional transport.
- `MAIL_FROM_ADDRESS` must use the verified `fixcity.eu` domain.
- Laravel config cache must be rebuilt after changing production variables.
- Queue workers must be restarted after a mailer/configuration change.
- Mailtrap pending-account restrictions are provider-side; changing the User
  action cannot make Gmail delivery work before provider approval.
- Verification mail is transactional: it must not contain marketing content or
  be sent to an address the user did not request. Resends remain rate-limited.
- Deliverability depends on the sender/provider setup: SPF, DKIM, DMARC, TLS,
  forward/reverse DNS, bounce handling and complaint rate are outside this
  module's action class.

## Failure classification

| Symptom | Owner | Action |
|---|---|---|
| `example.com` as From | Deployment config | Set `MAIL_FROM_ADDRESS`, clear/cache config |
| Mailtrap 412 for Gmail | Provider account | Approve the account or use an approved provider |
| Notification queued but not delivered | Queue/Notify | Inspect worker, failed jobs and provider response |
| Recipient never receives mail | DNS/provider | Check SPF, DKIM, DMARC, bounce and spam reputation |

The host-level send/receive runbook is maintained by Notify at
`Modules/Notify/docs/bmad/email-infrastructure-audit-and-runbook.md`.

## Consegna in produzione

Perche' la mail di verifica arrivi in inbox: [Notify story mail-server-send-receive](../../Notify/docs/stories/mail-server-send-receive.story.md).
