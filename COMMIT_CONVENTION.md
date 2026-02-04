# Semantic Commit Configuration for EtherSay

## Commit Types

- **feat**: A new feature
- **fix**: A bug fix
- **docs**: Documentation only changes
- **style**: Changes that do not affect the meaning of the code (white-space, formatting, missing semicolons, etc)
- **refactor**: A code change that neither fixes a bug nor adds a feature
- **perf**: A code change that improves performance
- **test**: Adding missing tests or correcting existing tests
- **chore**: Changes to the build process, dependencies, or auxiliary tools

## Commit Message Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Examples

```bash
# Feature
git commit -m "feat(chat): add private chat functionality"

# Bug Fix
git commit -m "fix(websocket): resolve CSP policy blocking"

# Documentation
git commit -m "docs: update README with setup guide"

# Refactor
git commit -m "refactor(components): reorganize Livewire components"

# Performance
git commit -m "perf(image): implement client-side compression for file upload"

# With body and footer
git commit -m "feat(online-users): add heartbeat system

- Implement 30-second heartbeat check
- Auto-detect offline users after 5 minutes
- Broadcast UserOnline/UserOffline events

Fixes #42"
```

## Branch Naming

- `feature/description` - Feature development
- `fix/description` - Bug fixes
- `docs/description` - Documentation updates
- `refactor/description` - Code refactoring
- `chore/description` - Maintenance tasks

## Releases

Use semantic versioning: `v{major}.{minor}.{patch}`

- **Major**: Breaking changes
- **Minor**: New features (backward compatible)
- **Patch**: Bug fixes (backward compatible)

Example: `v1.0.0`, `v1.1.0`, `v1.1.1`
