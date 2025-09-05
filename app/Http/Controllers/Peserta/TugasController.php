<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tugasList = $user->tugas()->with('pembimbing')->get();

        return view('peserta.tugas.index', compact('tugasList'));
    }

    public function show(Tugas $tugas)
    {
        // Load the pembimbing relationship and check access
        $tugas->load('pembimbing');

        // Check if the authenticated user has access to this task
        $hasAccess = Auth::user()->tugas()
            ->where('tugas.id', $tugas->id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'AKSES DITOLAK');
        }

        return view('peserta.tugas.show', compact('tugas'));
    }

    public function submit(Request $request, Tugas $tugas)
    {
        if (!Auth::user()->tugas->contains($tugas)) {
            abort(403);
        }

        if ($tugas->jenis == 'dokumen/proyek') {
            $request->validate([
                'file_laporan' => 'required|file|mimes:pdf,zip,doc,docx|max:10240',
            ]);

            // Cek apakah file ada DAN valid sebelum menyimpan
            if ($request->hasFile('file_laporan') && $request->file('file_laporan')->isValid()) {
                $path = $request->file('file_laporan')->store('laporan_peserta', 'public');
                $tugas->file_path = $path;
            } else {
                // Jika file tidak valid, kembali dengan error
                return back()->withErrors(['file_laporan' => 'File yang diupload tidak valid. Silakan coba lagi.']);
            }
        } elseif ($tugas->jenis == 'lapangan_teknis') {
            $request->validate([
                'laporan_deskripsi' => 'required|string|min:50',
            ]);
            $tugas->laporan_deskripsi = $request->laporan_deskripsi;
        }

        $tugas->status = 'verifikasi';
        $tugas->tanggal_selesai = now();
        $tugas->save();

        return redirect()->route('peserta.tugas.index')->with('success', 'Tugas berhasil dikumpulkan dan sedang menunggu verifikasi.');
    }
}
