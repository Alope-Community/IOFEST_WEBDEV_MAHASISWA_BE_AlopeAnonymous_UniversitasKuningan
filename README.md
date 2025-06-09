# API SPECIFICATION

API Backend untuk platform Pijar Nusantara menggunakan Laravel + Sanctum authentication.

---

***Note***
Tolong lakukan ini terlebih dahulu sebelum menggunakan:
```bash
npm install
php artisan storage:link
php artisan icon:cache
```

## 🛡️ Authentication

### 🔐 Register
**POST** `/api/register`

**Body:**
```json
{
  "name": "Nama User",
  "email": "user@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

### 🔑 Login
**POST** `/api/login`

**Body:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

### 🔓 Logout
**POST** `/api/logout`

**Header:** `Authorization: Bearer {token}`

### 👤 Profile
**GET** `/api/profile`

**Header:** `Authorization: Bearer {token}`

---

## 🎯 Program Relawan

### 📄 List Program
**GET** `/api/relawan`

**Query Parameters (optional):**
- `search`: string untuk pencarian berdasarkan nama atau deskripsi
- `limit`: jumlah item per halaman (default: 10)

### 🔍 Detail Program
**GET** `/api/relawan/{id}`

### 📝 Daftar
**POST** `/api/relawan/{id}/daftar`

**Header:** `Authorization: Bearer {token}`

**Body:**
```json
{
  "no_hp": "08123456789",
  "motivasi": "Saya ingin membantu orang lain."
}
```

---

## ⭐ Testimoni Relawan

### 📋 Semua Testimoni
**GET** `/api/relawan/all/testimoni`

### ✍️ Tambah Testimoni
**POST** `/api/relawan/testimoni`

**Header:** `Authorization: Bearer {token}`

**Body:**
```json
{
  "rating": 4,
  "pesan": "Pengalaman yang luar biasa dan penuh makna."
}
```

---

## 💰 Program Donasi

### 📄 List Program
**GET** `/api/donasi`

### 🔍 Detail Program
**GET** `/api/donasi/{id}`

### 📝 Daftar Donasi
**POST** `/api/donasi/{id}/daftar`

**Header:** `Authorization: Bearer {token}`

**Body:**
```json
{
  "nominal": 100000,
  "ucapan": "Semoga bermanfaat"
}
```

---

## 📰 Artikel Blog

### 📄 List Artikel
**GET** `/api/artikel`

**Query Parameters:**
- `search`: pencarian berdasarkan judul/lokasi
- `limit`: jumlah item per halaman

### 🔍 Detail Artikel
**GET** `/api/artikel/{id}`

---

## 💬 Forum Diskusi

### 📄 List Forum
**GET** `/api/forum`

**Query Parameters:**
- `search`: pencarian berdasarkan judul/konten
- `limit`: jumlah item per halaman

### 🔍 Detail Forum + Komentar
**GET** `/api/forum/{id}`

### ✍️ Tambah Komentar
**POST** `/api/forum/{id}/komentar`

**Header:** `Authorization: Bearer {token}`

**Body:**
```json
{
  "komentar": "Pendapat saya tentang topik ini..."
}
```

---

## 🧪 Test Endpoint

### 👤 Get User Info
**GET** `/api/user`

**Header:** `Authorization: Bearer {token}`

---

## 🧑‍💻 Contribution

1. Fork repo ini.
2. Buat branch baru:
   ```bash
   git checkout -b feature-branch-name
   ```
3. Commit perubahan:
   ```bash
   git commit -m "Add feature description"
   ```
4. Push branch:
   ```bash
   git push origin feature-branch-name
   ```
5. Open Pull Request.

---

## 📄 License

Proyek ini berlisensi **Alope-Community**.  
Dikembangkan oleh [Dikri Fauzan Amrulloh](https://github.com/dikrifzn).