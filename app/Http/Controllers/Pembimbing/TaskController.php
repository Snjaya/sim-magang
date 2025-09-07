<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('pembimbing_id', Auth::id())
            ->with('users')
            ->latest()
            ->get();
        return view('pembimbing.task.index', compact('tasks'));
    }

    public function create()
    {
        $pesertas = Peserta::with('user')->get();
        return view('pembimbing.task.create', compact('pesertas'));
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

        $task = Task::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'jenis' => $request->jenis,
            'pembimbing_id' => Auth::id(),
            'tanggal_diberikan' => now(),
            'status' => 'diberikan',
        ]);

        $task->users()->attach($request->peserta_ids);

        return redirect()->route('pembimbing.task.index')->with('success', 'Task berhasil dibuat untuk peserta terpilih.');
    }

    public function show(Task $task)
    {
        if ($task->pembimbing_id !== Auth::id()) {
            abort(403);
        }
        $task->load('users');
        return view('pembimbing.task.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if ($task->pembimbing_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }
        $pesertas = Peserta::with('user')->get();
        return view('pembimbing.task.edit', compact('task', 'pesertas'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->pembimbing_id !== Auth::id()) {
            abort(403);
        }
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jenis' => 'required|in:dokumen/proyek,lapangan_teknis',
            'peserta_ids' => 'required|array',
            'peserta_ids.*' => 'exists:users,id',
        ]);
        $task->update($request->only(['judul', 'deskripsi', 'jenis']));
        $task->users()->sync($request->peserta_ids);
        return redirect()->route('pembimbing.task.index')->with('success', 'Task berhasil diperbarui.');
    }

    public function destroy(Task $task)
    {
        if ($task->pembimbing_id !== Auth::id()) {
            abort(403);
        }
        $task->delete();
        return redirect()->route('pembimbing.task.index')->with('success', 'Task berhasil dihapus.');
    }

    public function verify(Request $request, Task $task)
    {
        if ($task->pembimbing_id !== Auth::id()) {
            abort(403);
        }
        $request->validate(['status' => 'required|in:selesai,revisi']);
        $task->update(['status' => $request->status]);
        return redirect()->route('pembimbing.task.index')->with('success', 'Task telah berhasil di-verifikasi.');
    }
}
