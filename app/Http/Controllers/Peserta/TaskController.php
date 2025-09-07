<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tasks = $user->tasks()->with('pembimbing')->latest()->get();
        return view('peserta.task.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        if (!$task->users->contains(Auth::user())) {
            abort(403, 'AKSES DITOLAK');
        }
        return view('peserta.task.show', compact('task'));
    }

    public function submit(Request $request, Task $task)
    {
        if (!$task->users->contains(Auth::user())) {
            abort(403);
        }
        if ($task->jenis == 'dokumen/proyek') {
            $request->validate([
                'file_laporan' => 'required|file|mimes:pdf,zip,doc,docx|max:10240',
            ]);
            if ($request->hasFile('file_laporan') && $request->file('file_laporan')->isValid()) {
                $path = $request->file('file_laporan')->store('laporan_peserta', 'public');
                $task->file_path = $path;
            } else {
                return back()->withErrors(['file_laporan' => 'File yang diupload tidak valid.']);
            }
        } elseif ($task->jenis == 'lapangan_teknis') {
            $request->validate(['laporan_deskripsi' => 'required|string|min:50']);
            $task->laporan_deskripsi = $request->laporan_deskripsi;
        }
        $task->status = 'verifikasi';
        $task->tanggal_selesai = now();
        $task->save();
        return redirect()->route('peserta.task.index')->with('success', 'Task berhasil dikumpulkan dan sedang menunggu verifikasi.');
    }
}
