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


## Admin report path compatibility hotfix - 2026-11-04

Request: Investigate the WordPress technical-issue alert and repair its confirmed
undefined-function failure. Keep the earlier report-admission release undeployed.

- This compatibility branch starts at c53bd9b, exactly matching the live
  1.5.98.asker.arslan main PHP SHA-256
  b37aaeaf2b44a82d5947eb474053243fa13608aa2d8e43315456eace2529c9e4.
- Version 1.5.98.1 changes only the two report-path validation blocks and version
  markers. It uses supported WordPress path_is_absolute with native Windows
  check separators, and rejects streams/null bytes before filesystem checks.
- Existing off-webroot, traversal, realpath, symlink and private-file controls
  remain. The 1.5.99 report-admission changes are intentionally absent here.
- Added the actual-core offline path regression and reference fixture. The
  maintained main branch carries the same fix as 1.5.100.
- Original source reproduces the undefined function; patched functions passed
  native Windows checks and the actual PHP8.1/WordPress7.1.4 Linux fixture.
- The coordinating incident runbook records separate publication, private
  rollback backup, exact deployed hash, admin-page verification and cleanup.

This checkpoint prepares the bounded compatibility release. Deployment state
is recorded in the site incident runbook after the guarded repair.
