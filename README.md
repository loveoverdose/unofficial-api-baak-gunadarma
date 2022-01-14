# UnOfficial API BAAK Gunadarma

UnOfficial API BAAK Gunadarma adalah sebuah Project API yang saya buat dari hasil scraping langsung ke [https://baak.gunadarma.ac.id/](https://baak.gunadarma.ac.id/) dan ini berguna untuk para mahasiswa Universitas Gunadarma yang ingin membuat Bot Kelasan untuk menghasilkan Informasi dari BAAK tanpa harus membuka situsnya terlebih dahulu.

| Fitur | Status |
|--|--|
Cache Data | ✔
Informasi Kalender Akademik | ✔
Informasi Jadwal Kuliah Berdasarkan Kelas | ✔
Informasi Jadwal Kuliah Berdasarkan Dosen | ✔
Informasi Kelas Untuk Mahasiswa Angkatan Baru | ✔
Informasi Kelas Baru Untuk Mahasiswa Tingkat 2  | ✔

## Pemasangan

Jika ingin melakukan pengembangan lebih terhadap API ini, bisa mengikuti langkah ini terlebih dahulu. Karena API ini menggunakan Redis sebagai layanan penyimpan cache data maka diperlukan menginstall Servernya di Komputer Lokal.

```
# Install Redis Server di Linux
sudo apt install redis-server
```

Menginstall libary pendukung menggunakan composer

```
composer install
```

## Dokumentasi

| Route URL | Deskripsi |
|--|--|
/kalenderakademik | Mendapatkan informasi seputar kalender akademik tahunan
/jadkul/1ia05 | Mendapatkan Informasi tentang jadwal kuliah untuk kelas 1ia05
/mhsbaru/nama/tom | Mendapatkan informasi kelas untuk mahasiswa angkatan baru berdasarkan nama tom
/kelasbaru/kelas/1ia05 | Mendapatkan informasi tentang kelas baru untuk mahasiswa tingkat 2

## Catatan

Karena ini masih dalam tahap pengembangan saya harap ada orang yang ingin membantu mengembangkan API ini entah itu Mengoptimalkan Kode, Menambahkan Fitur dll yang nantinya akan saya tambahkan namanya dibagian Kontribusi :)

## Kontribusi

- Saya