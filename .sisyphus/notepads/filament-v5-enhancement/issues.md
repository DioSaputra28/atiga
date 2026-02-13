## 2026-02-13 - QA Blocker: Filament Auth Access

- Playwright QA could reach `/admin/login` but protected resource pages require valid credentials.
- Without working admin credentials in automation, scenario checks for table toggles, helper text visibility, and slug behavior are blocked.
- Recommended follow-up: provide login credentials for automated UI verification, or run manual QA while authenticated.

## 2026-02-13 - Build Tooling Blocker

- `bun run build` fails with `vite: command not found` in this environment.
- This appears to be environment/tooling setup, not a code regression.
- Backend syntax checks, Pint, and PHPUnit/Pest tests pass.
