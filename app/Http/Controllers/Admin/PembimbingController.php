<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Pembimbing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PembimbingController extends Controller
{
    /**
     * Menampilkan daftar semua pembimbing.
     */
    public function index()
    {
        // Mengambil data pembimbing beserta relasi user-nya
        $pembimbings = Pembimbing::with('user')->latest()->get();
        return view('admin.pembimbing.index', compact('pembimbings'));
    }

    /**
     * Menampilkan form untuk membuat pembimbing baru.
     */
    public function create()
    {
        return view('admin.pembimbing.create');
    }

    /**
     * Menyimpan data pembimbing baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nip' => 'required|string|max:20|unique:pembimbings',
            'jabatan' => 'required|string|max:255',
        ]);

        // 2. Buat data user terlebih dahulu
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pembimbing',
        ]);

        // 3. Buat data profil pembimbing yang terhubung dengan user
        Pembimbing::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
        ]);

        // 4. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pembimbing.index')
            ->with('success', 'Data Pembimbing berhasil ditambahkan.');
    }

    public function edit(Pembimbing $pembimbing)
    {
        return view('admin.pembimbing.edit', compact('pembimbing'));
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, Pembimbing $pembimbing)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            // Pastikan email unik, kecuali untuk user ini sendiri
            'email' => 'required|string|email|max:255|unique:users,email,' . $pembimbing->user_id,
            // NIP unik, kecuali untuk pembimbing ini sendiri
            'nip' => 'required|string|max:20|unique:pembimbings,nip,' . $pembimbing->id,
            'jabatan' => 'required|string|max:255',
        ]);

        // 2. Update data di tabel user
        $pembimbing->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // (Opsional) Jika ada input password baru, update passwordnya
        if ($request->filled('password')) {
            $pembimbing->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // 3. Update data di tabel pembimbing
        $pembimbing->update([
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
        ]);

        // 4. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pembimbing.index')
            ->with('success', 'Data Pembimbing berhasil diperbarui.');
    }

    public function destroy(Pembimbing $pembimbing)
    {
        // Karena kita sudah set 'onDelete('cascade')' di migration,
        // seharusnya profil pembimbing akan ikut terhapus jika user-nya dihapus.
        // Jadi, kita cukup hapus data user-nya.
        $pembimbing->user->delete();

        return redirect()->route('pembimbing.index')
            ->with('success', 'Data Pembimbing berhasil dihapus.');
    }
}
