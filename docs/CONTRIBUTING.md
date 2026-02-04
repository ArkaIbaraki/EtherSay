# Contributing to EtherSay

Terima kasih telah ingin berkontribusi ke EtherSay! Berikut panduan untuk berkontribusi.

## 🐛 Melaporkan Bug

Jika menemukan bug, silakan buat issue dengan detail:
- Deskripsi bug yang jelas
- Steps untuk reproduce
- Expected behavior vs actual behavior
- Screenshots (jika perlu)
- Environment info (browser, OS, versi)

## 💡 Mengusulkan Feature

Silakan buat issue untuk feature request dengan:
- Deskripsi feature yang diinginkan
- Use case dan alasan
- Contoh implementasi (jika ada)

## 🔧 Pull Request Process

### 1. Fork & Clone
```bash
# Fork repository di GitHub
# Clone fork Anda
git clone https://github.com/YOUR_USERNAME/ethersay.git
cd ethersay

# Add upstream remote
git remote add upstream https://github.com/ArkaIbaraki/EtherSay.git
```

### 2. Create Feature Branch
```bash
git checkout -b feature/your-feature-name
# atau fix/bug-name untuk bug fixes
```

### 3. Make Changes
- Write clean, readable code
- Follow existing code style
- Add comments untuk logic yang kompleks
- Test changes Anda secara menyeluruh

### 4. Commit dengan Semantic Messages
```bash
# Format: <type>(<scope>): <subject>
git commit -m "feat(chat): add message search functionality"
git commit -m "fix(websocket): resolve connection timeout"
git commit -m "docs: update setup guide"
```

**Commit types:**
- `feat` - Feature baru
- `fix` - Bug fix
- `docs` - Documentation
- `style` - Code style (whitespace, formatting)
- `refactor` - Code refactoring
- `perf` - Performance improvement
- `test` - Test addition/modification
- `chore` - Build/dependency updates

Lihat [docs/COMMIT_CONVENTION.md](docs/COMMIT_CONVENTION.md) untuk detail lengkap.

### 5. Push & Create PR
```bash
# Update dengan latest changes dari upstream
git fetch upstream
git rebase upstream/main

# Push ke fork Anda
git push origin feature/your-feature-name
```

Buka Pull Request di GitHub dengan:
- Clear title dan description
- Reference issue jika fix untuk issue tertentu
- Screenshots/demo jika ada UI changes

### 6. PR Review Process
- Respond to reviewer feedback
- Make requested changes
- Push updates (jangan close & open PR baru)
- Maintainers akan merge setelah approval

## 📋 Development Setup

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link

# Run development servers
php artisan serve           # Terminal 1
php artisan reverb:start    # Terminal 2
npm run dev                 # Terminal 3
```

## 🎨 Code Style Guidelines

### PHP (Laravel/Livewire)
- PSR-12 coding standard
- Use type hints
- Use meaningful variable names
- Add PHPDoc comments untuk public methods

### JavaScript
- Use const/let, avoid var
- Use arrow functions
- Meaningful variable names
- Add comments untuk complex logic

### Blade Templates
- Use semantic HTML
- Proper indentation (2 spaces)
- Use Livewire directives properly
- Avoid inline styles (use Tailwind classes)

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run with coverage
php artisan test --coverage
```

## 📚 Documentation

- Update README.md jika ada feature/config changes
- Add comments di code yang kompleks
- Update relevant docs di `docs/` folder
- Include examples untuk feature baru

## 🚀 Release Process

Maintainers akan handle releases dengan:
- Version bumping (semantic versioning)
- CHANGELOG update
- Git tag creation
- GitHub Release notes

## ⚖️ License

Dengan berkontribusi, Anda setuju bahwa kontribusi Anda akan di-license di bawah MIT License yang sama dengan project ini.

## 📞 Questions?

- Buka issue untuk questions
- Buka discussion jika ingin diskusi
- Check existing issues & PRs sebelum membuat baru

---

Happy contributing! 🚀
