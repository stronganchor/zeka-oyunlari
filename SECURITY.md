# Security policy and 2026-08-12 account incident

## Current status

Game-account creation and the Roster 1000 game are intentionally disabled.
They must not be re-enabled without explicit approval from an adult repository
maintainer and a security review.

## Why the feature was disabled

The account experiments mixed several unsafe or unreliable approaches:

- 4-9 digit PINs were treated as credentials.
- PINs and account records were stored in browser `localStorage` as plaintext.
- One revision exposed anonymous account operations without adequate per-client
  throttling, site-wide budgets, or total storage limits.
- A generated Roster 1000 file was committed with a literal truncation marker,
  leaving invalid JavaScript and missing gameplay/account functions.
- Old WordPress account-creation code remained below an early return, making
  the intended security boundary difficult for future contributors to reason
  about.

Later commits reconstructed the missing Roster source and removed the anonymous
account handlers, but that reconstruction is treated only as a band-aid. The
feature stayed too easy to re-enable incorrectly, so the 2026-08-12 security
release added an explicit early disable and removes known legacy browser stores
when an affected page is visited.

## Requirements for any replacement

A replacement design must document its threat model and receive adult approval.
It must use WordPress authentication or another reviewed server-side identity
system, never browser-stored plaintext credentials. It must prevent username
enumeration and brute force, bound all writes and retained data, use opaque
revocable sessions, apply capability checks to privileged operations, and add
automated abuse, syntax, and browser-flow tests.

Do not interpret a nonce as satisfying those requirements.

## Reporting

Do not put credentials, tokens, cookies, private keys, or personal information
in an issue. Report security concerns privately to the adult repository owner.
