# TODO

## Step 1: Ubah endpoint dari `/barang` menjadi `/stok-barang`
- [ ] Update `routes/web.php`
  - `GET /barang` -> `GET /stok-barang`
  - `GET /barang/create` -> `GET /stok-barang/create`
  - `POST /barang` -> `POST /stok-barang`
  - `GET /barang/edit/{id}` -> `GET /stok-barang/edit/{id}`
  - `POST /barang/update/{id}` -> `POST /stok-barang/update/{id}`
  - `POST /barang/keluar` -> `POST /stok-barang/keluar`
  - `POST /barang/masuk` -> `POST /stok-barang/masuk`
  - `POST /barang/masuk/{id}` -> `POST /stok-barang/masuk/{id}`
  - `DELETE /barang/{id}` -> `DELETE /stok-barang/{id}`

## Step 2: Update semua link & form di Blade
- [ ] Update `resources/views/barang/index.blade.php`
- [ ] Update `resources/views/barang/create.blade.php`
- [ ] Update `resources/views/barang/edit.blade.php`
- [ ] Update `resources/views/layouts/app.blade.php` / sidebar bila perlu

## Step 3: Verifikasi cepat
- [ ] Cek halaman `/stok-barang`
- [ ] Coba tambah barang (submit)
- [ ] Coba edit & update
- [ ] Coba form keluar/masuk stok

