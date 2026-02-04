# 🚀 Quick Start - EtherSay

## Install & Run (3 Langkah)

### 1️⃣ Install Dependencies
```bash
composer install
npm install
npm run build
```

### 2️⃣ Setup Database
```bash
php artisan migrate
php artisan storage:link
```

### 3️⃣ Start Server
**Cara Mudah** - Double click file:
```
start-ethersay.bat
```

**Atau Manual** - Buka 2 terminal:
```bash
# Terminal 1
php artisan serve --host=0.0.0.0

# Terminal 2  
php artisan reverb:start
```

## 🌐 Akses Aplikasi

### Di Komputer Server
```
http://localhost:8000
```

### Di Device Lain (HP/Laptop)
1. Cari IP server dengan `ipconfig` (Windows)
2. Akses: `http://[IP_SERVER]:8000`
   - Contoh: `http://192.168.1.100:8000`

## ✅ Fitur Utama

- 💬 **No Login** - Langsung masuk dengan username
- 👥 **Online Users** - Lihat siapa saja yang online
- 🌐 **Global Chat** - Chat dengan semua orang
- 🔒 **Private Chat** - Chat pribadi 1-on-1
- 📎 **File Share** - Kirim gambar, PDF, ZIP
- ⚡ **Realtime** - Typing indicator & instant messages
- 📱 **Responsive** - Works di HP, Tablet, Desktop

## 🐛 Troubleshooting

**User tidak muncul online?**
- Pastikan Reverb jalan: `php artisan reverb:start`
- Check port 8080 tidak terblokir firewall

**File tidak bisa upload?**
- Jalankan: `php artisan storage:link`
- Check permission folder `storage/`

**Chat tidak realtime?**
- Restart Reverb server
- Clear browser cache
- Check browser console untuk error

## 📱 Mobile Usage

1. **Buka menu** - Tap hamburger (☰) kiri atas
2. **Pilih user** - Tap username untuk private chat  
3. **Kirim message** - Type & tap send (✈)
4. **Attach file** - Tap paperclip (📎)
5. **Back to global** - Tap back arrow (←)

## 🎯 Tips

- Username minimal 3 karakter
- Max file size: 10MB
- Support: JPG, PNG, GIF, PDF, ZIP
- Auto logout setelah 5 menit inactive
- Messages tersimpan di database (SQLite)

---

**Selamat menggunakan EtherSay! 💬✨**
