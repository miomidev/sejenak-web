<p align="center">
  <h1>Sejenak 🧘 - Safe Space for Everybody</h1>
</p>

<p align="center">
  <strong>Sebuah platform ruang aman untuk refleksi dan kesejahteraan emosional.</strong>
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/build-passing-brightgreen" alt="Build Status"></a>
  <a href="#"><img src="https://img.shields.io/badge/license-MIT-blue" alt="License"></a>
  <a href="#"><img src="https://img.shields.io/badge/laravel-^12.31.1-red" alt="Laravel Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/contributors-2-orange" alt="Contributors"></a>
</p>

---

## 📜 Tentang Proyek

**Sejenak** adalah sebuah platform web yang dirancang sebagai ruang aman untuk membantu pengguna mengekspresikan perasaan, merenung, dan memulai perjalanan menuju kesejahteraan emosional. Proyek ini dibangun untuk menyediakan sebuah lingkungan yang nyaman di mana pengguna dapat merefleksikan diri tanpa rasa takut.

Kami percaya setiap orang butuh ruang untuk terhubung dengan diri sendiri dan mendapatkan dukungan. Dengan menggabungkan teknologi AI yang cerdas, fitur komunitas, dan jaminan privasi, **Sejenak** hadir sebagai teman dalam perjalanan kesehatan mental Anda.

*Perjalanan menuju kesejahteraan emosional dimulai di sini.*

---

## ✨ Fitur Utama

- **AI Chat & Journaling**: Curhatkan apa pun ke chatbot AI, dan biarkan ia membantu menyusunnya menjadi catatan harian yang personal dan reflektif.
- **Komunitas yang Mendukung**: Terhubung dengan orang lain, berbagi pengalaman, dan saling memberikan dukungan dalam sebuah lingkungan yang positif.
- **Privasi & Keamanan Terjamin**: Kami sangat peduli dengan privasi. Setiap data personal, seperti jurnal harian, dienkripsi *end-to-end* untuk memastikan hanya Anda yang bisa mengaksesnya.
- **Desain Interaktif & Menenangkan**: Antarmuka pengguna yang dirancang dengan animasi halus dan palet warna yang menenangkan untuk memberikan pengalaman terbaik.

---

## 🛠️ Teknologi yang Digunakan

Proyek ini dibangun menggunakan tumpukan teknologi modern dan andal:

- [Laravel](https://laravel.com/)
- [Blade Templating](https://laravel.com/docs/blade)
- [Tailwind CSS](https://tailwindcss.com/)
- JavaScript (Vanilla)

---

## 🚀 Memulai Proyek

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut.

### Prasyarat

Pastikan Anda sudah menginstal perangkat lunak berikut:
- PHP (versi 8.3.24)
- Composer
- Node.js & NPM
- Database (misalnya MySQL, atau PostgreSQL)

### Instalasi

1.  **Clone repository ini:**
    ```sh
    git clone https://github.com/rexxus166/sejenak.git
    cd sejenak
    ```

2.  **Instal semua dependensi:**
    ```sh
    composer install
    npm install
    ```

3.  **Setup file `.env`:**
    ```sh
    cp .env.example .env
    ```
    Kemudian, sesuaikan konfigurasi database di dalam file `.env` Anda.

4.  **Generate kunci aplikasi:**
    ```sh
    php artisan key:generate
    ```

5.  **Jalankan migrasi database:**
    ```sh
    php artisan migrate
    ```

6.  **Compile asset front-end:**
    ```sh
    npm run dev
    ```

7.  **Jalankan server pengembangan:**
    ```sh
    php artisan serve
    ```

Proyek Anda sekarang seharusnya sudah berjalan di `http://127.0.0.1:8000`.