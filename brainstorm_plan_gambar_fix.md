# Brainstorm plan: Fix gambar barang tidak muncul di preview maupun tabel

## Informasi yang sudah ditemukan

- `create.blade.php` saat ini hanya menampilkan placeholder preview; **tidak ada input image preview (JS)**.
- `BarangController@store()` menyimpan file dengan:
    - `$request->file('gambar')->store('barang', 'public');`
    - Ini menghasilkan path seperti `barang/<filename>` dan tersimpan di `storage/app/public/...`.
- `BarangController@update()` menyimpan file dengan cara berbeda:
    - `$file->move(public_path('images'), $namaFile);`
    - dan menyetel `$data['gambar'] = 'images/' . $namaFile;`
- `index.blade.php` & `edit.blade.php` menampilkan gambar dengan:
    - `asset($b->gambar)` / `asset($barang->gambar)`
- Migration kolom `gambar` menyimpan `string` (jadi perlu path yang cocok untuk `asset()`).

## Masalah utama

1. Preview tidak muncul karena belum ada JS preview untuk input file.
2. Ketidakkonsistenan lokasi penyimpanan gambar:
    - `store()` menyimpan ke `storage/app/public/barang/...`
    - tetapi `index.blade.php` memanggil `asset($b->gambar)` (yang diasumsikan path relatif ke public root seperti `images/<file>`).
    - Akibatnya gambar dari create kemungkinan besar tidak ditemukan di public web root.

## Rencana perbaikan (pilih pendekatan yang konsisten)

### Opsi A (disarankan untuk minimal perubahan): Simpan selalu ke `public/images`

- Ubah `BarangController@store()` supaya sama seperti `update()`:
    - `move(public_path('images'), $namaFile)`
    - `gambar` diset `images/<namaFile>`
- Tambahkan preview gambar di `create.blade.php` menggunakan FileReader.
- (Opsional) Samakan juga tampilan preview edit (sudah ada img tag).

### Opsi B: Simpan ke storage/public lalu pastikan link public/storage

- Simpan konsisten dengan `store('barang', 'public')`.
- Pastikan `php artisan storage:link` dibuat.
- Lalu pastikan view memakai path yang sesuai (mis. set `gambar` jadi `storage/<path>` atau pakai `asset('storage/'.$b->gambar)` ketika b->gambar berisi `barang/...`).

## Yang akan saya lakukan

- Implement **Opsi A** agar view tetap menggunakan `asset($b->gambar)` tanpa perubahan besar.

## Perubahan file

1. `app/Http/Controllers/BarangController.php`
    - Ubah `store()` agar pakai `move(public_path('images'))`.
    - (Opsional) Validasi request.
2. `resources/views/barang/create.blade.php`
    - Tambahkan elemen `<img id="gambarPreview">` atau container yang ditampilkan saat file dipilih.
    - Tambahkan script `onchange` untuk membaca file dan menampilkan preview.

## Follow-up setelah edit

- Jalankan migrasi tidak perlu.
- Pastikan folder `public/images` ada (sudah ada beberapa gambar di repository).
- Test manual:
    - Upload gambar saat create -> preview harus terlihat segera
    - Setelah simpan -> gambar tampil di tabel index
    - Edit -> upload ulang -> gambar tampil benar
