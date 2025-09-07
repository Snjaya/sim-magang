<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('institusi_asal', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pesertas = $query->paginate(10)->withQueryString();

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
            'institusi_asal' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:15',
        ]);

        $tahun = now()->year;
        $passwordDefault = '#MAGANGPSDBMP';

        $lastPeserta = User::where('name', 'like', "INTERN_{$tahun}_%")->orderBy('name', 'desc')->first();
        $nomorUrut = $lastPeserta ? ((int) substr($lastPeserta->name, -3)) + 1 : 1;
        $username = "INTERN_{$tahun}_" . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
        $email = "intern{$tahun}" . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT) . "@peserta.com";

        $pesertaBaru = null;

        DB::transaction(function () use ($request, $username, $email, $passwordDefault, &$pesertaBaru) {
            $user = User::create([
                'name' => $username,
                'email' => $email,
                'password' => Hash::make($passwordDefault),
                'role' => 'peserta',
            ]);

            $pesertaBaru = Peserta::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->name,
                'institusi_asal' => $request->institusi_asal,
                'status' => 'Aktif',
                'no_hp' => $request->no_hp,
                'nim_nisn' => $username,
                'jurusan' => '-',
                'tanggal_mulai' => now(),
                'tanggal_berakhir' => now()->addMonths(3),
            ]);
        });

        return redirect()->route('peserta.index')
            ->with('success', "Akun untuk {$request->name} ({$username}) berhasil dibuat.")
            ->with('pesertaBaruId', $pesertaBaru->id);
    }

    public function cetakKartu(Peserta $peserta)
    {
        $peserta->load('user');
        $password = '#MAGANGPSDBMP';
        $pdf = Pdf::loadView('admin.peserta.kartu-akun-pdf', compact('peserta', 'password'));
        return $pdf->stream('kartu-akun-' . $peserta->user->name . '.pdf');
    }

    public function edit(Peserta $peserta)
    {
        $peserta->load('user');
        return view('admin.peserta.edit', compact('peserta'));
    }

    public function update(Request $request, Peserta $peserta)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'institusi_asal' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Selesai',
            'no_hp' => 'nullable|string|max:15',
            'nim_nisn' => 'required|string|max:20|unique:pesertas,nim_nisn,' . $peserta->id,
            'jurusan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $peserta->update($request->only([
            'nama_lengkap',
            'institusi_asal',
            'status',
            'no_hp',
            'nim_nisn',
            'jurusan',
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
