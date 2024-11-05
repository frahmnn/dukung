<p align="center"><img src="https://dukung.arifrahman.serv00.net/images/logo.png" width="400"></p>

## Preview Live

Ini adalah dokumentasi Project. Dokumentasi penggunaan apikasi dapat ditemukan di situs Live bagian "Bantuan." *Dukung* versi Production dapat diakses di https://dukung.arifrahman.serv00.net.

- Gunakan email "admin@admin.admin" dan password "aaaaaaaa" Untuk mengakses akun admin.
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

Pastikan konfigurasi berikut ditambahkan pada file `php.ini` di environment local Anda agar aplikasi dapat mengakomodasi ukuran maksimal file upload:<br>
upload_max_filesize = 50M<br>
post_max_size = 50M<br>

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
