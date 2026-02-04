# Changelog - EtherSay

All notable changes to this project will be documented in this file.

## [1.0.0] - 2026-02-04

### Added
- **Initial Release**: Complete LAN chat application with real-time communication
- **Authentication**: Session-based username system without login/password
- **Chat Features**:
  - Global chat for all connected users
  - Private 1-on-1 messaging
  - Typing indicators ("User is typing...")
  - Read status indicators (✓ sent, ✓✓ read)
  - Auto-scroll to latest messages
  - System messages for user join/leave events
  - Timestamps on all messages

- **Online Users Management**:
  - Real-time online users list
  - Heartbeat system (30-second intervals)
  - 5-minute offline detection timeout
  - Click-to-chat with online users
  - User join/leave notifications

- **File Sharing**:
  - Support for images, PDF, ZIP, RAR files
  - Automatic image compression (Canvas API)
  - Mobile optimization (5MB limit) vs Desktop (10MB limit)
  - File size validation before upload
  - File preview in chat

- **WebSocket Real-Time Communication**:
  - Laravel Reverb WebSocket server
  - Broadcasting events:
    - `MessageSent` - New message broadcast
    - `UserOnline` - User join event
    - `UserOffline` - User leave event
    - `UserTyping` - Typing indicator
  - Channels: `global-chat`, `chat.{sessionId}`, `online-users`, `typing.{sessionId}`

- **Responsive Design**:
  - Mobile (< 768px): Single column with hamburger menu
  - Tablet (768px - 1024px): Sidebar + chat area
  - Desktop (> 1024px): Full layout with all features
  - Touch-friendly UI on mobile devices

- **Security**:
  - CSRF token protection
  - Content Security Policy (CSP) headers
  - Input validation and sanitization
  - File type and size validation
  - Session-based identification

- **Database**:
  - `messages` table - Chat messages storage
  - `file_shares` table - File metadata
  - `online_users` table - User presence tracking

- **Documentation**:
  - README.md - Main documentation
  - QUICKSTART.md - Quick start guide
  - FILE_UPLOAD_GUIDE.md - File upload documentation
  - RESPONSIVE.md - Responsive design guide
  - BUGFIXES.md - Bug fixes and troubleshooting
  - COMMIT_CONVENTION.md - Git commit conventions
  - GITHUB_PUSH.md - GitHub setup instructions

### Technology Stack
- **Backend**: Laravel 11
- **Frontend**: Livewire 4
- **Styling**: Tailwind CSS 4
- **Real-Time**: Laravel Reverb (WebSocket)
- **Database**: SQLite
- **Package Manager**: Composer, NPM
- **Build Tool**: Vite

### Known Issues
None at release

### Breaking Changes
None (initial release)

---

## Future Roadmap

### v1.1.0 - Planned Features
- [ ] Message search functionality
- [ ] User profiles
- [ ] Message reactions/emoji
- [ ] Voice messages
- [ ] Group chat support
- [ ] Message pinning
- [ ] User blocking/ignore

### v1.2.0 - Planned Features
- [ ] Message encryption
- [ ] User authentication with password
- [ ] Persistent username (database)
- [ ] Message history export
- [ ] Dark mode theme
- [ ] Multiple file share locations

### v2.0.0 - Major Features
- [ ] Mobile native apps (React Native)
- [ ] Desktop app (Electron)
- [ ] Cloud synchronization
- [ ] Inter-network communication
- [ ] Advanced permissions system
- [ ] Message retention policies

---

## Version History

### 1.0.0 (Current)
- Initial release with all core features

---

## Contributing

To contribute, please follow:
1. [Commit Convention](COMMIT_CONVENTION.md)
2. [Code of Conduct](CODE_OF_CONDUCT.md) (if exists)
3. Create PR with semantic commit messages

---

## Release Notes

### How to Release
1. Update version in appropriate files
2. Update CHANGELOG.md with new version
3. Create git tag: `git tag v1.1.0`
4. Push tag: `git push origin v1.1.0`
5. Create Release on GitHub with release notes

### Version Format
Semantic Versioning: `v{major}.{minor}.{patch}`

Example:
- `v1.0.0` - Initial release
- `v1.1.0` - New features added
- `v1.1.1` - Bug fix release

---

Last Updated: 2026-02-04
