<?php

// app/Http/Controllers/Pembimbing/TugasController.php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index()
    {
        $tugasList = Tugas::where('pembimbing_id', Auth::id())
            ->with('pesertas') // Ganti dari 'peserta.user' menjadi 'pesertas'
            ->latest()
            ->get();
        return view('pembimbing.tugas.index', compact('tugasList'));
    }

    public function create()
    {
        // Kita butuh daftar peserta untuk ditampilkan di form dropdown
        $pesertas = Peserta::with('user')->get();
        return view('pembimbing.tugas.create', compact('pesertas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis' => 'required|in:dokumen/proyek,lapangan_teknis',
            'peserta_ids' => 'required|array', // Harus array
            'peserta_ids.*' => 'exists:users,id', // Setiap item di array harus ada di tabel users
        ]);

        // 1. Buat tugasnya dulu
        $tugas = Tugas::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'jenis' => $request->jenis,
            'pembimbing_id' => Auth::id(),
            'tanggal_diberikan' => now(),
            'status' => 'diberikan',
        ]);

        // 2. Lampirkan semua peserta yang dipilih ke tugas baru ini
        $tugas->pesertas()->attach($request->peserta_ids);

        return redirect()->route('pembimbing.tugas.index')->with('success', 'Tugas berhasil dibuat untuk peserta terpilih.');
    }

    public function edit(Tugas $tuga) // Nama variabel harus $tuga, bukan $tugas
    {
        // Keamanan: Pastikan pembimbing hanya bisa edit tugas miliknya
        if ($tuga->pembimbing_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $pesertas = Peserta::with('user')->get();
        return view('pembimbing.tugas.edit', compact('tuga', 'pesertas'));
    }

    public function update(Request $request, Tugas $tuga)
    {
        if ($tuga->pembimbing_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis' => 'required|in:dokumen/proyek,lapangan_teknis',
            'peserta_ids' => 'required|array', // Harus array
            'peserta_ids.*' => 'exists:users,id', // Setiap item di array harus ada di tabel users
        ]);

        // 1. Update data tugasnya
        $tuga->update($request->only(['judul', 'deskripsi', 'jenis']));

        // 2. Sinkronkan pesertanya. sync() akan otomatis menambah/menghapus yg perlu
        $tuga->pesertas()->sync($request->peserta_ids);

        return redirect()->route('pembimbing.tugas.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tuga)
    {
        if ($tuga->pembimbing_id !== Auth::id()) {
            abort(403);
        }

        $tuga->delete();
        return redirect()->route('pembimbing.tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
