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

## Anonymous report admission — 1.5.99

Public reports use a site/database-scoped MySQL or MariaDB named lock with a
one-second maximum wait. Fresh SQL counts and private report insertion run
under that lock. A successfully persisted report reserves its capacity before
optional screenshot processing begins. Every inserted metadata value is read
back; a missing value, database error, lost lock, failed insert, or failed lock
release rejects the request and removes any partial new report. There is no unlocked fallback.
Functioning `GET_LOCK`, `IS_USED_LOCK`, and `RELEASE_LOCK` support is required.

The default limits are 30 reports in the preceding hour, one accepted report
per client IP in five minutes, and 1,000 retained reports including trash and
other statuses. Duplicate messages for the same game and client are held for
30 days. Counts use UTC report dates and read the database directly rather
than transients or a stale object cache. Client keys are hashes of canonical
`REMOTE_ADDR`; visitor-supplied forwarding headers are not trusted. Existing
reports are preserved and count toward the global and storage limits. Existing
reports without the new hash metadata are not retroactively assigned clients.

Parsed form data, including field names, is limited to 8 KiB total, 4 KiB per
field, 64 bytes per field name, 20 scalar fields, and one recognized screenshot
file. The advertised multipart request size must not exceed 2 MiB.
Screenshots remain optional JPEG/PNG files up to 1 MiB; actual bytes, matching
image type, maximum 4,096-pixel dimensions, and a nine-megapixel ceiling are
checked before admission. Normal WordPress upload validation still applies.
Uploaded files are removed if creating or linking the attachment fails. The
PHP checks run after the web server parses the request; the host must retain
its own request-size and timeout limits.

Offline verification uses `php tests/report-admission.php` (PHP 8.1+ for
interleaved worker fixtures), `php tests/security-regression.php`, and PHP/JS
syntax checks. The admission tests exercise the actual source helpers and
handler with mocked database/media operations; they do not prove a particular
hosting database driver's lock behavior.

### Future deployment and rollback

No deployment accompanies this source change. Before a separately authorized
deployment, retain the installed plugin and its hash, then verify the named
lock with two independent staging database connections and exercise ordinary,
rate-limited, failed-save, and bounded screenshot submissions. Verify private
report access and the unchanged account/Roster hard-disables. Deploy only the
reviewed plugin version and read back its version/hash and report behavior.

There is no schema migration or automatic deletion of existing reports. A
code rollback restores the independently verified prior plugin files while
preserving all report data. Rolling back to 1.5.98.asker.arslan also restores
the former admission race; close public report submissions if that version
must be restored while a regression is investigated.
