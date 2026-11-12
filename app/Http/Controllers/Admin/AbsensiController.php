<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller Manajemen Absensi oleh Admin.
 *
 * Mengelola riwayat absensi, input absensi manual (sakit/izin), dan koreksi data.
 */
class AbsensiController extends Controller
{
    /**
     * Tampilkan data absensi dengan filter lengkap.
     */
    public function index(Request $request)
    {
        $selectedTanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));
        $selectedKelas   = $request->input('kelas');
        $selectedStatus  = $request->input('status');
        $search          = $request->input('search');

        $query = Absensi::with(['siswa', 'guru'])
            ->latest('waktu_scan');

        if (!empty($selectedTanggal)) {
            $query->whereDate('waktu_scan', $selectedTanggal);
        }

        if (!empty($selectedKelas)) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas', $selectedKelas));
        }

        if (!empty($selectedStatus)) {
            $query->where('status', $selectedStatus);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nisn', 'like', "%{$search}%")
                  ->orWhereHas('siswa', fn($sq) => $sq->where('nama', 'like', "%{$search}%"));
            });
        }

        $absensiList = $query->paginate(20)->withQueryString();
        $kelasList   = Siswa::select('kelas')->distinct()->pluck('kelas');

        return view('admin.absensi.index', compact(
            'absensiList',
            'kelasList',
            'selectedTanggal',
            'selectedKelas',
            'selectedStatus',
            'search',
        ));
    }

    /**
     * Form input absensi manual (misal: Sakit, Izin dengan surat keterangan).
     */
    public function create()
    {
        $siswaList = Siswa::orderBy('kelas')->orderBy('nama')->get();
        $guruList  = User::where('role', 'guru')->orderBy('name')->get();

        return view('admin.absensi.create', compact('siswaList', 'guruList'));
    }

    /**
     * Simpan absensi manual.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn'       => 'required|exists:siswa,nisn',
            'id_user'    => 'required|exists:users,id',
            'status'     => 'required|in:hadir,sakit,izin,alfa',
            'waktu_scan' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Absensi::create($validated);

        return redirect()->route('admin.absensi.index')->with('success', 'Data absensi manual berhasil disimpan!');
    }

    /**
     * Form edit status absensi.
     */
    public function edit(Absensi $absensi)
    {
        $absensi->load(['siswa', 'guru']);
        return view('admin.absensi.edit', compact('absensi'));
    }

    /**
     * Update status absensi.
     */
    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'status'     => 'required|in:hadir,sakit,izin,alfa',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $absensi->update($validated);

        return redirect()->route('admin.absensi.index')->with('success', 'Status absensi berhasil diperbarui!');
    }

    /**
     * Hapus data absensi.
     */
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return redirect()->route('admin.absensi.index')->with('success', 'Data absensi berhasil dihapus!');
    }
}
