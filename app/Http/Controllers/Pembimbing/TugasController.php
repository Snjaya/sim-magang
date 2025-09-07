<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index()
    {
        $tugasList = Tugas::where('pembimbing_id', Auth::id())
            ->with('pesertas')
            ->latest()
            ->get();
        return view('pembimbing.tugas.index', compact('tugasList'));
    }

    public function create()
    {
        $pesertas = Peserta::with('user')->get();
        return view('pembimbing.tugas.create', compact('pesertas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis' => 'required|in:dokumen/proyek,lapangan_teknis',
            'peserta_ids' => 'required|array',
            'peserta_ids.*' => 'exists:users,id',
        ]);

        $tugas = Tugas::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'jenis' => $request->jenis,
            'pembimbing_id' => Auth::id(),
            'tanggal_diberikan' => now(),
            'status' => 'diberikan',
        ]);

        $tugas->pesertas()->attach($request->peserta_ids);

        return redirect()->route('pembimbing.tugas.index')->with('success', 'Tugas berhasil dibuat untuk peserta terpilih.');
    }

    public function show(Tugas $tugas)
    {
        if ($tugas->pembimbing_id !== Auth::id()) {
            abort(403);
        }

        $tugas->load('pesertas');
        return view('pembimbing.tugas.show', compact('tugas'));
    }

    public function edit(Tugas $tugas)
    {
        if ($tugas->pembimbing_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $pesertas = Peserta::with('user')->get();
        return view('pembimbing.tugas.edit', compact('tugas', 'pesertas'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        if ($tugas->pembimbing_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis' => 'required|in:dokumen/proyek,lapangan_teknis',
            'peserta_ids' => 'required|array',
            'peserta_ids.*' => 'exists:users,id',
        ]);

        $tugas->update($request->only(['judul', 'deskripsi', 'jenis']));
        $tugas->pesertas()->sync($request->peserta_ids);

        return redirect()->route('pembimbing.tugas.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tugas)
    {
        if ($tugas->pembimbing_id !== Auth::id()) {
            abort(403);
        }

        $tugas->delete();
        return redirect()->route('pembimbing.tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }

    public function verify(Request $request, Tugas $tugas)
    {
        dd('ID Pemilik Tugas:', $tugas->pembimbing_id, 'ID Anda yang Login:', Auth::id());
        if ($tugas->pembimbing_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['status' => 'required|in:selesai,revisi']);

        $tugas->update(['status' => $request->status]);

        return redirect()->route('pembimbing.tugas.index')->with('success', 'Tugas telah berhasil di-verifikasi.');
    }
}
