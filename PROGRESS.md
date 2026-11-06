# Project progress

## Resolve main merge conflict — 2026-11-06

Request: Fix the interrupted merge with origin/main.

Completed:
- Resolved the version-only conflict in zeka-oyunlari.php, preserving the newer local header version 1.6.00.asker.arslan and synchronizing ZO_PLUGIN_VERSION.
- Retained incoming report-admission/path compatibility fixes and documentation, plus local game and image work.

Verification:
- PHP syntax, security regression invariants, all 82 admission checks, all 43 Windows path/admin checks, and Blocky Bear's 1,000-level/progress checks passed.
- git diff --check passed. No additional hook or security behavior changes were made in resolving the conflict.

Next steps:
- Completed the existing merge with a local merge commit; verified no unmerged paths remain and the working tree is clean. Main is three commits ahead of origin/main. No push or deployment performed; prior deployment boundaries remain in force.

## Helper release exclusion and square featured images — 2026-11-06

Request: Fix the helper-script warning for games/mindsweeper.py and non-square images for Munich Clock, New York Clock, Number Line Jump, and Odd One Out.

Completed:
- Added recursive extension-based export-ignore rules in .gitattributes for Python, PowerShell, shell, batch, and command scripts. Preserved the terminal game in source control and retained the security warning and server protections.
- Replaced featured-image.png in games/time-munich, games/time-new-york, games/Number Line Jump, and games/Odd One Out with square images using built-in imagegen.
- Prompt for each existing image: reframe/extend to square, preserve content, colors, characters and style, avoid stretching; preserve screenshot text/interface where applicable.

Verification:
- Inspected all four generated images; all saved PNGs decode at 1254 x 1254, satisfying the existing square and minimum-size checks.
- git check-attr confirms games/mindsweeper.py has export-ignore set; targeted git archive --worktree-attributes check confirms it is absent from the archive.
- git diff --check passed. No PHP, JavaScript, or WordPress hooks changed.

Remaining / release plan:
- Local changes only; no commit, push, deployment, or live-site verification performed.
- Publish through an archive process honoring .gitattributes, then replace the deployed plugin and recheck. If deployment overlays existing files, remove the old deployed games/mindsweeper.py explicitly; exclusions cannot remove a stale server file.
- A source checkout still reports helper files by design. Rollback: restore the previous four images and .gitattributes from Git if needed; keep server-side script blocking enabled.

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

## Report-mirror path API compatibility — 2026-11-04

Request: Investigate the WordPress technical-issue alert and repair its confirmed
undefined path API failure. The live baseline remains 1.5.98.asker.arslan; the
separate 1.5.99 report-admission changes have not been deployed.

Completed locally on maintained main:
- Bumped the maintained source to 1.5.100 and replaced both unsupported
  `wp_is_absolute_path()` calls with WordPress's `path_is_absolute()` API.
- Added stream-wrapper and null-byte rejection before the core path check.
  Relative, traversal and public-root guards, canonical/symlink verification,
  private permissions and bounded mirror writes remain unchanged. On Windows,
  core checks use native separators while returned paths stay normalized, so
  native public roots remain protected. Non-native drive paths fail closed on
  POSIX.
- Added `tests/report-mirror-paths.php` with a CLI-only WordPress reference
  fixture. It runs the actual snapshot → preparation → path helper chain with
  writes intercepted, and can extract the supported APIs from installed core
  using `ZO_TEST_WP_FUNCTIONS`.

Verification:
- The pre-fix source reproduces the alert's exact undefined-function fatal;
  patched code passes 43 path/admin-snapshot checks on Windows (40 on POSIX)
  with both portable reference and extracted installed core implementations.
- All 82 report-admission checks, existing security invariants, PHP syntax
  checks and `git diff --check` pass.
- Independent owner-context validation with EA PHP 8.1.34 and extracted live
  WordPress 7.1.4 core passes all 40 Linux cases; the pre-fix source fails with
  the original undefined-function fatal under that same runtime.
- No site requests, report data, files, mail or configuration were changed by
  these fixtures. Parent and independent source reviews are complete;
  live repair/verification remain with the coordinating chat.

Next steps:
- Commit and push approved maintained main source; the coordinating chat records
  exact remote readback separately from live deployment.
- The coordinating chat owns a separate 1.5.98.1 compatibility branch based on
  the exact live source, so an incident-only repair can preserve the earlier
  security-release deployment boundary. No deployment is performed here.

### Incident closeout - 2026-11-04

The WordPress technical-issue alert was addressed with a narrow live
compatibility repair, preserving the earlier no-deployment boundary for the
report-admission release. Compatibility 1.5.98.1 was published separately as
`7e6edc0ea8b08a8bfaaf181e40ca8dad0a48624c` from the exact installed c53bd9b
baseline. Maintained main 1.5.100 carries the same path fix at
`4df90bd971aea9abec8f556da389336982dc74c5`.

Actual PHP 8.1/WordPress 7.1.4 path checks and authenticated PHP-FPM Content
Lookup rendering passed; the affected page and public routes returned 200.
Only the compatibility main PHP file was replaced. Report counts, activation
and pre-existing sessions were preserved; temporary verification access was
revoked. The 1.5.99 report-admission changes remain undeployed. Site notes and
private incident receipts record the exact deployed hash and guarded rollback.
No additional account, PIN, upload or paid-service feature was enabled.
