<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        $q = trim((string) $request->input('q'));

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', '%' . $q . '%')
                    ->orWhere('kode_barang', 'like', '%' . $q . '%');
            });
        }

        $barangs = $query->latest()->get();

        return view('barang.index', compact('barangs'));
    }

    public function dashboard()
    {
        $barangs = Barang::latest()->get();

        return view('dashboard', compact('barangs'));
    }

  public function transaksi(Request $request)
{
    $query = Transaksi::with('barang');

    if ($request->tanggal) {

        $tanggal = Carbon::parse($request->tanggal);

        // FILTER HARI
        $query->whereDate('created_at', $tanggal);

    }

    $transaksis = $query
        ->latest()
        ->get();

    $pemasukan = 0;
    $pengeluaran = 0;

    foreach ($transaksis as $trx) {

        $jumlahAsli = $trx->jumlah;

        $jumlahCancel = $trx->cancel_jumlah ?? 0;

        $jumlahFinal = $jumlahAsli - $jumlahCancel;

        $hargaSatuan = $jumlahAsli > 0
            ? $trx->total_harga / $jumlahAsli
            : 0;

        $totalFinal = $hargaSatuan * $jumlahFinal;

        if ($trx->jenis == 'keluar') {

            // Pemasukan = hasil penjualan barang keluar
            $pemasukan += $totalFinal;

        } else {

            // Modal / Pengeluaran = modal dari barang masuk
            $pengeluaran += $totalFinal;

        }
    }

    return view('transaksi.index', compact(
        'transaksis',
        'pemasukan',
        'pengeluaran'
    ));
}

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kode_barang' => 'required|unique:barangs,kode_barang',
            'stok' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        $data = $request->only([
            'nama',
            'kode_barang',
            'stok',
            'harga_beli',
            'harga_jual'
        ]);

        if ($request->hasFile('gambar')) {

            $file = $request->file('gambar');

            $namaFile = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('images'), $namaFile);

            $data['gambar'] = 'images/' . $namaFile;
        }

        $barang = Barang::create($data);

        // TRANSAKSI MASUK
        Transaksi::create([
            'barang_id' => $barang->id,
            'jenis' => 'masuk',
            'jumlah' => $barang->stok,
            'total_harga' => $barang->harga_beli * $barang->stok,
        ]);

        return redirect('/stok-barang')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);

        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'kode_barang' => 'required',
            'stok' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        $data = $request->only([
            'nama',
            'kode_barang',
            'stok',
            'harga_beli',
            'harga_jual'
        ]);

        if ($request->hasFile('gambar')) {

            $file = $request->file('gambar');

            $namaFile = time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('images'), $namaFile);

            $data['gambar'] = 'images/' . $namaFile;
        }

        $barang->update($data);

        return redirect('/stok-barang')
            ->with('success', 'Barang berhasil diupdate');
    }

    public function masuk(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::where('kode_barang', $request->kode_barang)->first();

        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan');
        }

        $barang->stok += $request->jumlah;

        $barang->save();

        // SIMPAN TRANSAKSI MASUK
        Transaksi::create([
            'barang_id' => $barang->id,
            'jenis' => 'masuk',
            'jumlah' => $request->jumlah,
            'total_harga' => $barang->harga_beli * $request->jumlah,
        ]);

        return back()->with('success', 'Stok berhasil ditambahkan');
    }

    public function keluar(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::where('kode_barang', $request->kode_barang)->first();

        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan');
        }

        if ($barang->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak cukup');
        }

        $barang->stok -= $request->jumlah;

        $barang->save();

        // SIMPAN TRANSAKSI KELUAR
        Transaksi::create([
            'barang_id' => $barang->id,
            'jenis' => 'keluar',
            'jumlah' => $request->jumlah,
            'total_harga' => $barang->harga_jual * $request->jumlah,
        ]);

        return back()->with('success', 'Stok berhasil dikurangi');
    }
    public function cancelTransaksi(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'jumlah_cancel' => 'required|integer|min:1'
        ]);

        // hanya transaksi keluar
        if ($transaksi->jenis != 'keluar') {
            return back()->with('error', 'Hanya transaksi keluar yang bisa dicancel');
        }

        $sisaBisaCancel = $transaksi->jumlah - $transaksi->cancel_jumlah;

        if ($request->jumlah_cancel > $sisaBisaCancel) {

            return back()->with(
                'error',
                'Jumlah cancel melebihi sisa transaksi'
            );
        }

        $barang = Barang::find($transaksi->barang_id);

        // kembalikan stok
        $barang->stok += $request->jumlah_cancel;

        $barang->save();

        // tambah cancel
        $transaksi->cancel_jumlah += $request->jumlah_cancel;

        // jika full cancel
        if ($transaksi->cancel_jumlah >= $transaksi->jumlah) {
            $transaksi->status = 'cancel';
        }

        $transaksi->save();

        return back()->with('success', 'Barang berhasil dicancel');
    }

    public function masukById(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang->stok += $request->jumlah;

        $barang->save();

        // SIMPAN TRANSAKSI MASUK
        Transaksi::create([
            'barang_id' => $barang->id,
            'jenis' => 'masuk',
            'jumlah' => $request->jumlah,
            'total_harga' => $barang->harga_beli * $request->jumlah,
        ]);

        return redirect('/stok-barang/edit/' . $barang->id)
            ->with('success', 'Stok berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        $barang->delete();

        return back()->with('success', 'Barang berhasil dihapus');
    }
}
