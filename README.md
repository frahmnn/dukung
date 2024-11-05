<p align="center"><img src="https://dukung.arifrahman.serv00.net/images/logo.png" width="400"></p>

## Preview Live

Ini adalah dokumentasi Project. Dokumentasi penggunaan apikasi dapat ditemukan di situs Live bagian "Bantuan." *Dukung* versi Production dapat diakses di https://dukung.arifrahman.serv00.net.

- Gunakan email `admin@admin.admin` dan password `aaaaaaaa` Untuk mengakses akun admin.
- Pusher Sandbox Plan membatasi jumlah push yang dapat dilakukan hingga 200.000 request per hari. Harap diperhatikan batasan ini.
- Google SMTP Free Plan memungkinkan pengiriman hingga 500 pesan per hari. Pastikan untuk memperhatikan batasan ini ketika mengelola pengiriman email.
- Beberapa provider internet dapat memicu error "Maximum execution time of 30 seconds exceeded" saat meminta verifikasi email. Mohon untuk mengganti provider internet saat terdapat error, atau akses melalui https://dukung.arifrahman.serv00.net/zzcheatemail untuk memverifikasi semua email.

## Dependensi Proyek

*Dukung* memerlukan dependensi berikut untuk berjalan dengan baik di lingkungan *localhost*:

### Framework & Backend
- **Laravel 11**: Framework utama PHP yang digunakan dalam pengembangan aplikasi.
- **MySQL**: Basis data untuk menyimpan data pengguna, acara, dan interaksi.
- **GD PHP Library**: Diperlukan untuk pemrosesan gambar.
- **Pusher**: Digunakan untuk fitur real-time, seperti notifikasi obrolan.

### Autentikasi & Pengelolaan Pengguna
- **Laravel Breeze**: Paket autentikasi sederhana, mendukung login, pendaftaran, dan reset password.

### UI & Interaksi Frontend
- **Bootstrap**: Framework CSS yang digunakan untuk mempercepat pengembangan UI.
- **jQuery**: Digunakan untuk manipulasi DOM secara interaktif.
- **DataTables**: Plugin jQuery untuk menampilkan tabel dengan fitur pencarian, filter, dan pengurutan.
- **SortableJS**: Library *drag-and-drop* untuk membuat komponen sortable pada tabel atau daftar.

### Sertifikat Keamanan (untuk Pengembangan)
- **cacert.pem**: Sertifikat keamanan untuk mengakses layanan eksternal secara aman pada localhost.

### Pengaturan PHP untuk *Localhost*

Pastikan konfigurasi berikut ditambahkan pada file `php.ini` di environment local Anda agar aplikasi dapat mengakomodasi ukuran maksimal file upload:
```
upload_max_filesize = 50M
post_max_size = 50M
```

Untuk memastikan akses langsung ke folder *storage* untuk gambar dan file lainnya di proyek *Dukung*, pastikan menjalankan perintah-perintah berikut di *Command Prompt* pada *localhost*:

### Membuat Symbolic Link untuk Direktori Penyimpanan

Gunakan perintah di bawah ini untuk membuat *symbolic link* agar file yang diunggah dapat diakses melalui folder `public`. Sesuaikan `path\menuju\dukung` dengan jalur proyek Anda.```
mklink /d path\menuju\dukung\public\images path\menuju\dukung\storage\app\private\images
mklink /d path\menuju\dukung\public\proposals path\menuju\dukung\storage\app\private\proposals
mklink /d path\menuju\dukung\public\verifications path\menuju\dukung\storage\app\private\verifications```
