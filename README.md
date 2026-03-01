<div align="center">

# 💰 Manajemen Keuangan Grosir

**Sistem Informasi Manajemen Keuangan untuk Usaha Grosir**

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Blade](https://img.shields.io/badge/Blade-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/docs/blade)
[![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)

*Sistem Informasi · Cash Basis Accounting · Manajemen Keuangan*

</div>

---

## 📖 Deskripsi

**Manajemen Keuangan Grosir** adalah sistem informasi berbasis web yang dirancang untuk membantu pengelolaan keuangan usaha grosir secara efisien dan terstruktur. Sistem ini menggunakan metode **Cash Basis Accounting**, yaitu pencatatan transaksi keuangan berdasarkan arus kas nyata (saat uang diterima atau dibayarkan).

Dibangun dengan framework **Laravel** dan template **Blade**, aplikasi ini menyediakan dashboard keuangan yang komprehensif mulai dari pencatatan transaksi, laporan pemasukan & pengeluaran, hingga ringkasan keuangan usaha grosir secara real-time.

### ✨ Fitur Utama

- 💵 **Pencatatan Transaksi** — Catat pemasukan dan pengeluaran berbasis kas (Cash Basis)
- 📊 **Laporan Keuangan** — Laporan laba rugi dan ringkasan arus kas
- 🏪 **Manajemen Produk** — Kelola data barang dan stok grosir
- 👥 **Manajemen Pengguna** — Sistem autentikasi dengan manajemen peran
- 🔄 **GitHub Actions CI/CD** — Pipeline otomatis untuk deployment
- 🌐 **Multi-bahasa** — Dukungan internasionalisasi (folder `lang/`)

---

## 🛠️ Tech Stack

| Kategori | Teknologi |
|---|---|
| **Backend** | PHP, Laravel |
| **Frontend** | Laravel Blade, HTML, CSS |
| **Database** | MySQL |
| **Build Tool** | Vite |
| **CI/CD** | GitHub Actions |
| **Metode Akuntansi** | Cash Basis Accounting |

---

## ⚙️ Prasyarat

Pastikan perangkat kamu sudah terinstal:

- **PHP** >= 8.1
- **Composer** >= 2.x
- **Node.js** >= 18.x & **npm**
- **MySQL** >= 8.x
- **Git**

---

## 📦 Cara Install

### 1. Clone Repository

```bash
git clone https://github.com/Liando18/manajemen-keuangan-grosir.git
cd manajemen-keuangan-grosir
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Install Dependensi JavaScript

```bash
npm install
```

### 4. Konfigurasi Environment

```bash
cp .env.example .env
```

Buka file `.env` dan sesuaikan konfigurasi berikut:

```env
APP_NAME="Manajemen Keuangan Grosir"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=keuangan_grosir
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Buat Database & Jalankan Migrasi

Buat database baru bernama `keuangan_grosir` di MySQL, lalu jalankan:

```bash
php artisan migrate
```

### 7. (Opsional) Isi Data Awal

```bash
php artisan db:seed
```

### 8. Buat Symbolic Link Storage

```bash
php artisan storage:link
```

---

## ▶️ Cara Menjalankan

Buka **dua terminal** secara bersamaan:

### Terminal 1 — Laravel Development Server

```bash
php artisan serve
```

### Terminal 2 — Vite (Asset Frontend)

```bash
npm run dev
```

Aplikasi dapat diakses di: **[http://localhost:8000](http://localhost:8000)**

---

### 🏗️ Build untuk Produksi

```bash
npm run build
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📁 Struktur Folder

```
manajemen-keuangan-grosir/
│
├── .github/
│   └── workflows/          # Konfigurasi CI/CD GitHub Actions
│
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Logic controller aplikasi
│   │   └── Middleware/     # Middleware autentikasi & otorisasi
│   ├── Models/             # Eloquent ORM models
│   └── Providers/          # Service providers
│
├── bootstrap/              # Bootstrap aplikasi Laravel
│
├── config/                 # Konfigurasi aplikasi (database, mail, dll)
│
├── database/
│   ├── migrations/         # Skema tabel database
│   ├── seeders/            # Data awal aplikasi
│   └── factories/          # Factory untuk testing
│
├── lang/                   # File terjemahan (internasionalisasi)
│
├── public/                 # Asset publik & entry point (index.php)
│
├── resources/
│   ├── views/              # Template Blade (UI aplikasi)
│   └── css/ & js/          # File stylesheet dan JavaScript
│
├── routes/
│   ├── web.php             # Definisi routing web
│   └── api.php             # Definisi routing API
│
├── storage/                # File upload, log, dan cache
│
├── tests/                  # Unit & feature testing
│
├── .env.example            # Template konfigurasi environment
├── artisan                 # CLI Laravel
├── composer.json           # Dependensi PHP
├── package.json            # Dependensi JavaScript
├── pint.json               # Konfigurasi Laravel Pint (code formatter)
└── vite.config.js          # Konfigurasi Vite bundler
```

---

## 💡 Tentang Cash Basis Accounting

Metode **Cash Basis Accounting** yang digunakan dalam sistem ini berarti:

- ✅ **Pemasukan** dicatat saat uang benar-benar **diterima**
- ✅ **Pengeluaran** dicatat saat uang benar-benar **dibayarkan**
- ✅ Cocok untuk usaha skala **kecil hingga menengah** seperti usaha grosir

---

## 🤝 Kontribusi

Kontribusi sangat terbuka! Jika ingin berkontribusi:

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b fitur/nama-fitur`)
3. Commit perubahan (`git commit -m 'Menambahkan fitur baru'`)
4. Push ke branch (`git push origin fitur/nama-fitur`)
5. Buat Pull Request

---

## 📄 Lisensi

Didistribusikan di bawah lisensi **MIT**. Lihat file `LICENSE` untuk informasi lebih lanjut.

---

<div align="center">

Dibuat dengan ❤️ menggunakan Laravel & PHP
untuk membantu pengelolaan keuangan usaha grosir yang lebih terstruktur

</div>
