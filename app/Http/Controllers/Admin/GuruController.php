<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controller Manajemen Guru oleh Admin.
 *
 * Mengelola CRUD Akun Guru (login menggunakan NIP & Password).
 */
class GuruController extends Controller
{
    /**
     * Tampilkan daftar akun guru.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = User::where('role', 'guru')->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $guruList = $query->paginate(15)->withQueryString();

        return view('admin.guru.index', compact('guruList', 'search'));
    }

    /**
     * Form tambah guru baru.
     */
    public function create()
    {
        return view('admin.guru.create');
    }

    /**
     * Simpan data guru baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip'      => 'required|string|size:18|unique:users,nip',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'nip.required'   => 'NIP wajib diisi.',
            'nip.size'       => 'NIP harus tepat 18 digit angka.',
            'nip.unique'     => 'NIP sudah terdaftar di sistem.',
            'name.required'  => 'Nama guru wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah terdaftar.',
        ]);

        $validated['role']     = 'guru';
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.guru.index')->with('success', "Akun guru {$validated['name']} berhasil ditambahkan!");
    }

    /**
     * Form edit data guru.
     */
    public function edit(User $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Update data guru.
     */
    public function update(Request $request, User $guru)
    {
        $validated = $request->validate([
            'nip'      => 'required|string|size:18|unique:users,nip,' . $guru->id,
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $guru->id,
            'password' => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $guru->update($validated);

        return redirect()->route('admin.guru.index')->with('success', "Data guru {$guru->name} berhasil diperbarui!");
    }

    /**
     * Hapus data guru.
     */
    public function destroy(User $guru)
    {
        $name = $guru->name;
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', "Akun guru {$name} berhasil dihapus!");
    }
}
