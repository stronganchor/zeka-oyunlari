# Project progress

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
