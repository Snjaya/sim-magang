<?php

// app/Http/Controllers/Admin/PesertaController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PesertaController extends Controller
{
    public function index()
    {
        $pesertas = Peserta::with('user')->latest()->get();
        return view('admin.peserta.index', compact('pesertas'));
    }

    public function create()
    {
        return view('admin.peserta.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nim_nisn' => 'required|string|max:20|unique:pesertas',
            'jurusan' => 'required|string|max:255',
            'asal_sekolah_kampus' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'peserta', // Role-nya peserta
        ]);

        Peserta::create([
            'user_id' => $user->id,
            'nim_nisn' => $request->nim_nisn,
            'jurusan' => $request->jurusan,
            'asal_sekolah_kampus' => $request->asal_sekolah_kampus,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Data Peserta berhasil ditambahkan.');
    }

    public function edit(Peserta $peserta)
    {
        return view('admin.peserta.edit', compact('peserta'));
    }

    public function update(Request $request, Peserta $peserta)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $peserta->user_id,
            'nim_nisn' => 'required|string|max:20|unique:pesertas,nim_nisn,' . $peserta->id,
            'jurusan' => 'required|string|max:255',
            'asal_sekolah_kampus' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $peserta->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $peserta->user->update(['password' => Hash::make($request->password)]);
        }

        $peserta->update($request->only([
            'nim_nisn',
            'jurusan',
            'asal_sekolah_kampus',
            'tanggal_mulai',
            'tanggal_berakhir'
        ]));

        return redirect()->route('peserta.index')->with('success', 'Data Peserta berhasil diperbarui.');
    }

    public function destroy(Peserta $peserta)
    {
        $peserta->user->delete();
        return redirect()->route('peserta.index')->with('success', 'Data Peserta berhasil dihapus.');
    }
}
