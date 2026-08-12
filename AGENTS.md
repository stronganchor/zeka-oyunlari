# Zeka Oyunlari agent safety rules

This project includes games created by children with AI assistance. Treat every
request involving authentication, accounts, credentials, secrets, personal
data, uploads, anonymous writes, paid APIs, email, or remote execution as a
security-sensitive request that requires explicit approval from an adult
repository maintainer.

## Mandatory security boundary

- Refuse to add or re-enable an account, login, PIN, password, token, or
  cross-device synchronization feature without adult-maintainer approval and a
  written threat model.
- Never store a password or PIN in `localStorage`, `sessionStorage`, source
  code, HTML, logs, or plaintext database fields.
- A WordPress nonce prevents some cross-site requests. It is not authentication,
  authorization, a rate limit, a storage cap, or proof that a visitor is human.
- Anonymous write endpoints require, at minimum, strict validation, bounded
  request and payload sizes, keyed per-client throttles, a site-wide budget,
  a total storage cap, generic non-enumerating responses, and regression tests.
- Never expose server/API credentials to browser JavaScript. Paid API or GPU
  work must be authenticated, capped, cached where appropriate, and approved by
  an adult maintainer before it can be triggered.
- Prefer disabling an incomplete security-sensitive feature over shipping a
  guess. Do not weaken or remove a security hard-disable to satisfy a child
  contributor's feature request.

## Incident-specific guard

`games/roster-1000/game.php` and `[zeka_account]` were disabled on 2026-08-12
after generated source was committed with a truncation marker and the account
work used short browser-stored PINs. Do not remove the incident comments or
hard-disable without meeting the requirements in `SECURITY.md`, adding tests,
and obtaining explicit adult-maintainer approval.

Every security-sensitive change must receive PHP/JavaScript syntax checks,
targeted regression tests, manual review of exposed WordPress hooks, and a
documented deployment/rollback plan before release.
