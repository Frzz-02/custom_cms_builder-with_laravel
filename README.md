<h1 align="center">⚡ Custom CMS Builder</h1>
<h3 align="center">High-Performance Dynamic Landing Page Engine</h3>

<p align="center">
  CMS Builder berbasis Laravel untuk menyusun landing page dinamis dengan sistem block, manajemen konten terstruktur, dan arsitektur yang ringan untuk performa produksi.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/TailwindCSS-4.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind" />
  <img src="https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite" />
</p>

---

## 📌 Deskripsi Singkat
Aplikasi ini adalah **Custom CMS Builder** (bukan WordPress clone penuh) yang berfokus pada:
- penyusunan halaman berbasis block/shortcode,
- manajemen section konten yang fleksibel,
- dashboard admin untuk update konten cepat,
- dan rendering frontend yang modular untuk kebutuhan landing page modern.

Cocok untuk company profile, product showcase, campaign page, dan website konten dinamis dengan workflow editing yang terstruktur.

---

## 🖼️ Showcase

### Link Google Drive

- **Video Demo dan Tampilan Aplikasi**: [Lihat selengkapnya](https://drive.google.com/drive/folders/1fMB315B1B8XoK69DMSQH9W9Ym0SAztm6?usp=sharing)


### 1) Dashboard Admin
![Dashboard Placeholder](screenshoot/dashboard%20admin.png)

### 2) Page Builder (Drag & Drop Blocks)

<table>
  <tr>
    <td><img src="/screenshoot/edit page.png" alt="Page Builder"></td>
    <td><img src="/screenshoot/ui block library.png" alt="UI Block library"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <img src="/screenshoot/page builder (ui block).png" alt="ui block">
    </td>
  </tr>
</table>


### 3) Frontend Landing Page
<table>
  <tr>
    <td><img src="/screenshoot/landing page 1.png" alt="landing page 1"></td>
    <td><img src="/screenshoot//landing page 2.png" alt="landing page 2"></td>
  </tr>
</table>

### 4) Product & Category Form Input
<table>
  <tr>
    <td><img src="/screenshoot/products.png" alt="Product"></td>
  </tr>
  <tr>
    <td><img src="/screenshoot/product%20categories.png" alt="Product category"></td>
  </tr>
</table>


### 5) Theme File Editor
<table>
  <tr>
    <td><img src="/screenshoot/theme%20file%20editor.png" alt="Theme file editor"></td>
  </tr>
</table>

### 6) Site Setting
<table>
  <tr>
    <td><img src="/screenshoot/site%20setting.png" alt="Site setting"></td>
  </tr>
</table>


---

## 🧰 Tech Stack
### Backend
- **PHP 8.2+**
- **Laravel 12**
- **Eloquent ORM**
- **Laravel Validator & Policies**

### Frontend
- **Blade Templating**
- **Tailwind CSS 4**
- **Vite 7**
- **Vanilla JavaScript** (Page Builder logic)

### Database & Dev Tools
- **MySQL/MariaDB** (via Laravel migration)
- **Seeder & Factory** untuk data awal
- **PHPUnit** untuk testing

---

## ✨ Fitur Utama
- **Dynamic Page Builder** berbasis block (title, text, hero banner, about, services, testimonials, product category, latest news, coming soon, contact, dll).
- **Drag & Drop block sorting** dengan sinkronisasi urutan ke database (`sort_id`).
- **Multi-style section** (contoh: Hero Style 1/2/3, nav style variasi).
- **Media picker integration** untuk pemilihan aset gambar dari library media.
- **CRUD konten admin** untuk Pages, Products, Categories, Blogs, Contacts, Newsletter, Team, dan Settings.
- **SEO fields per konten** (meta title, description, keywords).
- **Configurable navigation system** (navbar/sidebar/footer + menu hierarchy).

---

## 🗂️ Struktur Database & Relasi (Contoh Implementasi)
Berikut contoh relasi yang digunakan dalam project ini.

### 1) One-to-Many
**`product_categories` (1) → (N) `products`**
- Satu kategori produk bisa memiliki banyak produk.
- Satu produk hanya memiliki satu kategori utama.
- Implementasi model:
  - `ProductCategory::products()` → `hasMany(Product::class, 'product_categories_id')`
  - `Product::category()` → `belongsTo(ProductCategory::class, 'product_categories_id')`

### 2) One-to-Many
**`pages` (1) → (N) `page_shortcodes`**
- Satu halaman bisa memiliki banyak block/shortcode.
- Setiap shortcode dimiliki satu halaman.
- Implementasi model:
  - `Page::shortcodes()` → `hasMany(PageShortcode::class, 'pages_id')`
  - `PageShortcode::page()` → `belongsTo(Page::class, 'pages_id')`

### 3) Many-to-Many (Praktis via JSON IDs)
Pada builder ini, beberapa relasi blok disimpan sebagai array ID dalam kolom JSON (mis. `section_service_id`, `section_testimoni_id`, `section_brand_id`, `contact_id`) di tabel `page_shortcodes`.

Artinya:
- satu shortcode dapat mengacu ke banyak entitas section,
- satu entitas section juga bisa dipakai di banyak shortcode.

> Ini adalah pendekatan many-to-many praktis tanpa pivot table terpisah, dipilih untuk fleksibilitas block builder.

### 4) Self-Relation (Hierarki Menu)
**`navbar` parent-child**
- Menu dapat memiliki submenu melalui `parent_id`.
- Implementasi model:
  - `Navbar::parent()` → `belongsTo(Navbar::class, 'parent_id')`
  - `Navbar::children()` → `hasMany(Navbar::class, 'parent_id')`

---

## 🚀 Cara Instalasi
### 1. Clone repository
```bash
git clone https://github.com/Frzz-02/custom_cms_builder-with_laravel.git
cd custom_cms_builder-with_laravel
```

### 2. Install dependency
```bash
composer install
npm install
```

### 3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi database
- Atur `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` di `.env`

Lalu jalankan:
```bash
php artisan migrate --seed
```

### 5. Jalankan project
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Aplikasi siap diakses di:
- `http://127.0.0.1:8000`

---

## 📁 Struktur Folder Ringkas
```bash
app/
  Http/Controllers/
    Auth/
    Backend/
    Frontend/
  Models/
resources/
  views/
    auth/
    backend/
    frontend/
      layouts/
      pages/
      section/
  js/
  css/
public/
  assets/
database/
  migrations/
  seeders/
routes/
  web.php
```

---

## 🎯 Catatan Portofolio
Project ini menunjukkan kemampuan pada area:
- perancangan arsitektur CMS custom,
- implementasi CRUD kompleks dan relasi data,
- optimasi UX editor (page builder),
- integrasi frontend-backend untuk landing page dinamis.

---

## 👤 Penutup & Kontak
Project ini dikembangkan oleh **Feri Irawan**  
Siswa Rekayasa Perangkat Lunak - **SMK Negeri 1 Bantul**.  
Fokus pada pengembangan **Back-End** dan optimasi sistem website.
- LinkedIn : https://www.linkedin.com/in/feri-irawan-633178339/
- GitHub : Frzz-02
- Email : pc.feriirawan0211@gmail.com

---

## 📄 License
Project ini menggunakan lisensi **MIT**.
