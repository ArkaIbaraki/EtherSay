# EtherSay - Local Network Chat Application

![Laravel](https://img.shields.io/badge/Laravel-11.0-FF2D20?style=flat-square&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-4.0-FB70A9?style=flat-square&logo=livewire)
![WebSocket](https://img.shields.io/badge/WebSocket-Reverb-00D084?style=flat-square)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-4.0-38B2AC?style=flat-square&logo=tailwind-css)
![Status](https://img.shields.io/badge/Status-WIP-orange?style=flat-square)

⚠️ **STATUS: Work In Progress (WIP)** - Project ini masih dalam tahap pengembangan aktif. Aplikasi masih banyak kemungkinan bug dan fitur mungkin berubah tanpa pemberitahuan. Gunakan dengan hati-hati di production environment!

EtherSay adalah aplikasi chat real-time untuk jaringan lokal (LAN) yang dibangun dengan Laravel 11, Livewire 4, dan WebSocket Reverb. Tidak memerlukan login/password - cukup input username dan langsung bisa chat!

## ✨ Fitur Utama

### 🔑 Tanpa Login/Password
- Username sementara berbasis session
- Tidak perlu registrasi atau autentikasi
- Langsung masuk dan mulai chat

### 👥 Online Users List (Realtime)
- Melihat siapa saja yang online
- Update otomatis saat user join/leave
- Klik username untuk private chat

### 💬 Chat System
- **Global Chat**: Ruang chat umum untuk semua user
- **Private Chat**: Chat 1-on-1 antar user
- Pesan hanya terlihat oleh pengirim & penerima

### ⚡ Realtime Interaction
- WebSocket dengan Laravel Reverb
- Typing indicator ("User sedang mengetik...")
- Read status (✓ terkirim, ✓✓ dibaca)
- Online/offline detection otomatis

### 📎 File Sharing
- Upload & kirim file (Image, PDF, ZIP)
- Preview gambar langsung di chat
- Download file dengan mudah
- Max file size: 10MB

### 💫 System Messages
- "User bergabung"
- "User keluar"
- Timestamp setiap pesan

## 🛠️ Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Livewire 4 + Blade
- **Styling**: Tailwind CSS 4
- **WebSocket**: Laravel Reverb
- **Database**: SQLite (lightweight)
- **File Storage**: Local Storage

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js & npm
- SQLite

## 🚀 Cara Install & Jalankan

### 1. Clone & Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Build assets
npm run build
```

### 2. Setup Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database & run migrations
touch database/database.sqlite
php artisan migrate

# Create storage symlink
php artisan storage:link
```

### 3. Jalankan Server

Buka **3 terminal terpisah**:

**Terminal 1 - Laravel Development Server:**
```bash
php artisan serve --host=0.0.0.0
```

**Terminal 2 - Laravel Reverb (WebSocket Server):**
```bash
php artisan reverb:start
```

**Terminal 3 - Queue Worker (opsional, untuk background jobs):**
```bash
php artisan queue:work
```

### 4. Akses Aplikasi

**Di server (host):**
- Buka browser: `http://localhost:8000`

**Di client (device lain di LAN yang sama):**
- Cari IP server: `ipconfig` (Windows) atau `ifconfig` (Linux/Mac)
- Misal IP server: `192.168.1.100`
- Buka browser: `http://192.168.1.100:8000`

## 📱 Cara Menggunakan

1. **Buka aplikasi** di browser
2. **Masukkan username** (min 3 karakter)
3. **Klik "Join Chat"** - langsung masuk ke chat room
4. **Lihat online users** di sidebar kiri
5. **Global Chat** - chat dengan semua user
6. **Private Chat** - klik username untuk chat pribadi
7. **Kirim file** - klik ikon attachment, pilih file
8. **Leave Chat** - klik tombol "Leave Chat" di bawah

## 🎯 Fitur Detail

### Private Chat
- Klik username di sidebar untuk memulai private chat
- Pesan hanya terlihat oleh kedua pihak
- Read status menunjukkan apakah pesan sudah dibaca

### Typing Indicator
- Muncul saat user lain sedang mengetik
- Hilang otomatis setelah 3 detik

### File Sharing
- Support: JPG, PNG, GIF, PDF, ZIP
- Preview otomatis untuk gambar
- Download dengan klik file

### Auto Scroll
- Chat otomatis scroll ke pesan terbaru
- Responsif dan smooth

## 🔧 Konfigurasi

### Ubah Port Server
Edit `.env`:
```env
APP_URL=http://192.168.1.100:8000
```

Jalankan dengan port custom:
```bash
php artisan serve --host=0.0.0.0 --port=8080
```

### Ubah Port Reverb (WebSocket)
Edit `.env`:
```env
REVERB_PORT=8080
```

### Max File Size
Edit `app/Livewire/Chat.php`, line ~83:
```php
'file' => 'nullable|file|max:10240', // 10MB
```

## � Documentation

Dokumentasi lengkap tersedia di folder `docs/`:
- [QUICKSTART.md](docs/QUICKSTART.md) - Panduan singkat memulai
- [FILE_UPLOAD_GUIDE.md](docs/FILE_UPLOAD_GUIDE.md) - Panduan upload file
- [RESPONSIVE.md](docs/RESPONSIVE.md) - Responsive design guide
- [BUGFIXES.md](docs/BUGFIXES.md) - Troubleshooting dan bug fixes
- [CHANGELOG.md](docs/CHANGELOG.md) - History rilis dan roadmap

## 🐛 Troubleshooting

### User tidak terlihat online
- Pastikan Reverb server jalan: `php artisan reverb:start`
- Check browser console untuk error WebSocket
- Cek firewall tidak block port 8080
- Lihat detail di [BUGFIXES.md](docs/BUGFIXES.md)

### File tidak bisa diupload
- Pastikan `php artisan storage:link` sudah dijalankan
- Check permission folder `storage/`
- Verify max upload size di `php.ini`
- Lihat [FILE_UPLOAD_GUIDE.md](docs/FILE_UPLOAD_GUIDE.md) untuk detail

### Chat tidak realtime
- Restart Reverb server
- Clear browser cache
- Check koneksi WebSocket di browser DevTools > Network > WS
- Lihat [BUGFIXES.md](docs/BUGFIXES.md) untuk solusi lengkap

## 📝 Development

### Run in Development Mode
```bash
# Terminal 1
php artisan serve --host=0.0.0.0

# Terminal 2
php artisan reverb:start --debug

# Terminal 3
npm run dev
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 🎨 Customization

### Ubah Warna Tema
Edit `resources/views/livewire/*.blade.php` dan sesuaikan class Tailwind.

### Tambah Fitur
1. Buat Livewire component: `php artisan make:livewire NamaComponent`
2. Buat event: `php artisan make:event NamaEvent`
3. Implement logic di component
4. Broadcast event untuk realtime

## 🚫 Scope yang Tidak Ada (By Design)

- ❌ Authentication & Password
- ❌ Group Chat
- ❌ Voice/Video Call
- ❌ End-to-end Encryption
- ❌ Edit/Delete Message
- ❌ Search Chat History

## 📄 License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

Dibuat dengan ❤️ untuk komunikasi LAN yang mudah dan cepat.

---

**Selamat mencoba EtherSay! 🚀**
