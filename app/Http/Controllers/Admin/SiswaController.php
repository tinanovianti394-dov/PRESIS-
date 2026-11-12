<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Services\QrCryptoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Controller Manajemen Siswa oleh Admin.
 *
 * Mengelola CRUD Data Siswa dan generate Kartu QR Siswa.
 */
class SiswaController extends Controller
{
    /**
     * Tampilkan daftar siswa dengan fitur pencarian dan filter kelas.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kelas  = $request->input('kelas');

        $query = Siswa::latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('no_hp_orangtua', 'like', "%{$search}%");
            });
        }

        if (!empty($kelas)) {
            $query->where('kelas', $kelas);
        }

        $siswaList = $query->paginate(15)->withQueryString();
        $kelasList = Siswa::select('kelas')->distinct()->pluck('kelas');

        return view('admin.siswa.index', compact('siswaList', 'kelasList', 'search', 'kelas'));
    }

    /**
     * Form tambah siswa baru.
     */
    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Simpan data siswa baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn'           => 'required|string|size:10|unique:siswa,nisn',
            'nama'           => 'required|string|max:255',
            'kelas'          => 'required|string|max:50',
            'no_hp_orangtua' => 'nullable|string|max:20',
            'password'       => 'required|string|min:6',
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.size'     => 'NISN harus tepat 10 digit.',
            'nisn.unique'   => 'NISN sudah terdaftar di sistem.',
            'nama.required' => 'Nama siswa wajib diisi.',
            'kelas.required' => 'Kelas wajib diisi.',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Siswa::create($validated);

        return redirect()->route('admin.siswa.index')->with('success', "Data siswa {$validated['nama']} berhasil ditambahkan!");
    }

    /**
     * Form edit data siswa.
     */
    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update data siswa.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nisn'           => 'required|string|size:10|unique:siswa,nisn,' . $siswa->id,
            'nama'           => 'required|string|max:255',
            'kelas'          => 'required|string|max:50',
            'no_hp_orangtua' => 'nullable|string|max:20',
            'password'       => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $siswa->update($validated);

        return redirect()->route('admin.siswa.index')->with('success', "Data siswa {$siswa->nama} berhasil diperbarui!");
    }

    /**
     * Hapus data siswa.
     */
    public function destroy(Siswa $siswa)
    {
        $nama = $siswa->nama;
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', "Data siswa {$nama} berhasil dihapus!");
    }

    /**
     * Tampilkan dan cetak QR Code Siswa dari Admin (Kartu Fisik Cetak, Permanen).
     */
    public function qrcode(Siswa $siswa)
    {
        $encryptedPayload = QrCryptoService::generateSiswaQrPayload($siswa, 'card');
        $qrCodeSvg        = QrCode::size(240)->margin(1)->generate($encryptedPayload);

        return view('admin.siswa.qrcode', compact('siswa', 'encryptedPayload', 'qrCodeSvg'));
    }
}
