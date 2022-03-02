## Tentang Aplikasi

Aplikasi ini dibuat menggunakanmya

-   PHP versi 7.3
-   Framework Laravel 8.0
-   Mysql versi 5.7

## Cara instalasi

-   Clone repositori ini **git clone**
-   Copy **.env.example** dan rubah menjadi **.env** kemudian edit
-   jalankan **composer install**
-   jalankan **php artisan key:generate**
-   jalankan **php artisan migrate --seed**
-   jalankan **php artisan passport:install**
-   jalankan **npm install**
-   jalankan **npm run dev**

## Akun

-   admin
    -   username admin@mail.com password : password
-   Kabag Umum
    -   username kabag_umum@mail.com password : password
-   Kabag Kepegawaian
    -   username kabag_pegawai@mail.com password : password

## Cara Penggunaan Aplikasi

-   lakukan login terlebih dahulu
-   untuk menambahkah data transportasi, driver, dan user yang menyetujui maka pengguna perlu masuk sebagai admin
-   apabila terdapat pemesanan admin perlu masuk kedalam menu rental
-   setelah itu admin dapat memasukan driver berserta trasnportasi yang akan dipakai
-   tahapan selanjutnya data rental tersebut tinggal menunggu persetujuan dari kabag umum serta kabag kepegawaian
-   untuk melakukan persetujuan terhadap pemesanan, diharuskan untuk melakukan login sebagai kabag umum dan kabag khusus. kemudian masuk kedalam menu rental dan klik acc pada tabel. setelah mendapatkan perseujuan dari kedua pihak maka driver sudah bisa menggunakan mobil
-   untuk melihat grafik dan melakukan proses export Excel maupun PDF, user dapat mengakses menu dashboard.
