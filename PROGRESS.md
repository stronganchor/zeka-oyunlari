# Project progress

## Progress persistence setup — 2026-10-30

Request: Save assistant progress, then commit and push the setup.

Completed:
- Added persistent progress instructions to `AGENTS.md`, preserving existing project safety rules.
- Created this repository checkpoint so future sessions can recover completed work and next steps.

Verification:
- Reviewed the documentation changes. No application code changed in this task; application tests are not applicable.

Existing work outside this task:
- Uncommitted changes were present in `games/blocky-bear-adventure/game.php`, `script.js`, `style.css`, and `zeka-oyunlari.php`, with untracked `tests/blocky-bear-levels.js`.
- Their completion and verification status was not established in this chat. They are excluded from this task's commit.

Next steps:
- Commit and push these two documentation files, then verify the remote branch matches the local commit.
- Future tasks should update this log at meaningful milestones and before stopping.

## Serialized anonymous report limits — 2026-11-04

Request: Fix the reviewed report admission race, choose conservative limits,
test, commit and push this repository separately. Do not deploy. The user
explicitly included Zeka in this security-hardening authorization.

Completed locally:
- Updated `zeka-oyunlari.php` to 1.5.99. A bounded site/database named lock now
  covers fresh global, storage, peer and duplicate counts plus private report
  insertion. Every inserted metadata field is verified before admission.
- Preserved the default 30/hour, 1,000 retained-report and five-minute client
  limits. Added bounded form/image validation and orphan-upload cleanup.
- Added `tests/report-admission.php` and updated `tests/security-regression.php`.
- Documented database requirements, limits, verification and future deployment/
  rollback in `SECURITY.md`. Existing reports and account/Roster hard-disables
  remain preserved.

Verification:
- 82 offline admission/concurrency/failure assertions passed, including actual
  handler admission before media work, simultaneous per-peer/global/storage
  boundaries, unavailable/failed-release locks, failed writes, empty optional
  fields, metadata readback failures and WordPress quote/backslash round trips.
- Existing account/report security invariants, PHP syntax, embedded account-
  cleanup JavaScript syntax and `git diff --check` passed.
- These fixtures mock database/media operations. Real hosting-driver lock
  behavior and live submission behavior have not been tested or deployed.

Next steps:
- Parent and independent reviewer completed the bounded diff review and reran the final checks successfully. Separate commit/push is approved; the coordinating chat records remote readback.
- Deployment remains explicitly excluded; use the security runbook only if a
  future deployment is separately authorized.
