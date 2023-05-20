Aplikasi Sistem Keamanan

Instalation
- PHP minimal versi 8
- composer update
- jika terjadi error
- composer install --ignore-platform-reqs
- php artisan key:generate
- Buat DB sesuai dengan .env (dengan nama "laravel")
- php artisan migrate (untuk membuat tabel-tabel)
- php artisan db:seed (untuk mengisi data pada tabel)
- php artisan optimize (optional) (clear cache laravel)
- php artisan serve


Account : 
- username : admin123
- password : admin123


Task :
- validasi login ✓
- penambahan hasil pencarian script ✓
- penambahan validasi tapi yang salah ✓
- encrypt nama gambar, dikasih saat upload tanggal bulan tahun (log) ✓
- penambahan salt pada enkripsi ✓
- read only button pada saat waktu habis ✓
- akses query raw ✓

Rule :
https://docs.google.com/document/d/1UTJOUKu_2O_oQuifDNFckpo8WMpORvAg5I2bQ1GAsRs/edit?usp=sharing
